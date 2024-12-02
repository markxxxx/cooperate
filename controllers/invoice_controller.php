<?php declare(strict_types=1)

class InvoiceController extends AppController {

    function index($project_id=0) {
        
        $currentProject = new Project($project_id);
        if (!$currentProject->id && $project_id==0) {
            //allinvoices
            $invoices = Invoice::query('
                    SELECT  i.id as invoice_id, 
                            i.created as invoice_created,
                            i.status as invoice_status,
                            i.file as file,
                            p.name as project_name,
                            c.name as customer_name,
                            c.surname as customer_surname,
                            c.contact_number as contact_number,
                            c.company as customer_company
                    FROM `invoices` i
                    LEFT JOIN `projects` p ON (p.id=i.project_id)
                    LEFT JOIN `customers` c ON (c.id=p.customer_id)
            ')->fetch_all();
        }
        else{
             //projectinvoices
            $invoices = Invoice::query("
                    SELECT  i.id as invoice_id, 
                            i.created as invoice_created,
                            i.status as invoice_status,
                            i.file as file,
                            p.name as project_name,
                            c.name as customer_name,
                            c.surname as customer_surname,
                            c.contact_number as contact_number,
                            c.company as customer_company
                    FROM `invoices` i
                    LEFT JOIN `projects` p ON (p.id=i.project_id)
                    LEFT JOIN `customers` c ON (c.id=p.customer_id)
                    WHERE p.id = $project_id;
            ")->fetch_all();
            $this->set('data',array('project_id' =>$project_id, 'project_name'=> $currentProject->name ));
        }
        $this->set('invoices',$invoices);

       // $this->set('customers', Customer::find()->fetch_all());

        $projects = Project::query("SELECT *,p.id AS project_id, 
                                             c.id AS customer_id, 
                                             c.name AS customer_name, 
                                             c.surname AS customer_surname, 
                                             p.name AS project_name,
                                             t.id AS technical_id 
                                    FROM projects p 
                                    LEFT JOIN customers c ON p.customer_id=c.id
                                    LEFT JOIN technicals t ON p.id=t.project_id
                                    ;")->fetch_all();

       $this->set('projects', $projects);
    }  

    function home() {        
        
    }
    
    function add($invoice_id=0) {

        $invoice = new invoice($invoice_id);

        if (!$invoice->id && $invoice_id) {
            $this->redirect("invoice");
        }

        if (isset($_POST['data'])) {

            $invoice->update_map($_POST['data']);
            // var_dump($_POST['data']);exit();
            $customer=new Customer($_POST['data']['customer_id']);

            if ($invoice->id) {
                $invoice->remove_validation('email', 'unique');
            }
      
            $is_new_invoice = false;

            if ($invoice->validate()) {

                if (!$invoice->id) {
                    
                    $invoice->user_id = $this->user->id;
                    $invoice->created = date('Y-m-d H:i:s');

                    $invoice->insert(); //insert here so we have an id
                    $is_new_invoice = true;

                    // Upload document
                    if($_FILES['invoice']['name'])
                    {
                        $extention=explode(".", $_FILES['invoice']['name']);

                        $valid_file = true;
                         // var_dump($_FILES); exit();
                        //if no errors...
                        if(!$_FILES['invoice']['error'])
                        {
                            //now is the time to modify the future file name and validate the file
                            // $new_file_name = strtolower($_FILES['invoice']['tmp_name']); //rename file
                            $new_file_name = $extention[0]."-".$invoice->id.".".$extention[1]; //rename file
                            if($_FILES['invoice']['size'] > (4096000)) //can't be larger than 4 MB
                            {
                                $valid_file = false;
                                $message = 'Oops!  Your file\'s size is to large.';
                            }
                            
                            //if the file has passed the test
                            if($valid_file)
                            {
                                //move it to where we want it to be
                                move_uploaded_file($_FILES['invoice']['tmp_name'], "documents/invoices/".$new_file_name);
                                $invoice->file = $new_file_name;
                                $message = 'Congratulations!  Your file was accepted.';
                            }
                        }
                        //if there is an error...
                        else
                        {
                            //set that to be the returned message
                            $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['invoice']['error'];
                        }
                    }

                    $invoice->update();
                    
                    // $project = Project::query("SELECT *,p.id AS project_id, 
                    //                          c.id AS customer_id, 
                    //                          c.name AS customer_name, 
                    //                          c.surname AS customer_surname, 
                    //                          c.email AS customer_email, 
                    //                          p.name AS project_name,
                    //                          t.id AS technical_id 
                    //                 FROM projects p 
                    //                 LEFT JOIN customers c ON p.customer_id=c.id
                    //                 LEFT JOIN technicals t ON p.id=t.project_id
                    //                 WHERE p.id=$invoice->project_id
                    //                 ;")->fetch();           

                    // $mail_vars = array(
                    //     'name' => $project['customer_name'] .' '.$project['customer_surname'],
                    //     'email' => $project['customer_email']
                    // );

                    // Message_template::send($project['customer_email'], Message_template::INVOICE_CREATED, $mail_vars,$invoice->file);

                } else {
                    $invoice->update();
                }

                if($is_new_invoice) {
                    $this->redirect('referer','?success=1');
                } else {
                    // $this->redirect('invoice/edit/'.$invoice->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('invoice/?failure=1');
                }

            } else {
                $_POST['data']['id'] = $invoice->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $invoice->to_array());
        }
    }
    
    function edit($invoice_id = 0) {

        $this->set('customer', Company::find()->fetch_all());
       $this->set('batches', Batch::find('1=1 order by id asc')->fetch_all());

        
        $invoice = new Invoice($invoice_id);
        $old_data = $invoice->to_array();

        if(!$invoice->id) {
            $this->redirect('admin/');
        }
        
        if(isset($_POST['save'])) {
            $invoice->update_map($_POST['data']);            
            if( $invoice->validate() ) {            
                                
                $invoice->updated = date('Y-m-d H:i:s');
                $invoice->update();
                $this->transaction->log(serialize($invoice->to_array() ), serialize($old_data) );
                $invoice->delete_cache();
                $this->redirect('invoice/?success=1');
                
            } else {
            
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
                $this->set('error',$error);
            }
            
        } else {
        
            $this->set('data', $invoice->to_array());
        }
    }
    
    function delete($invoice_id=0) {
        $invoice = new Invoice($invoice_id);
        // $this->transaction->log(NULL,serialize($invoice->to_array() ) );
        Invoice::delete($invoice_id);        
        $this->redirect('invoice/?success=1');
    }

    function print_doc($invoice_id=0){

        $invoice = new Invoice($invoice_id);
        $company = new Company($invoice->company_id);
        $batch = new Batch($invoice->batch_id);
        $acquisition = new Acquisition($batch->acquisition_id);
        $product = new Product($acquisition->product_id);
       
        $title =$invoice->type. ' Invoice '.$invoice->id;
        // Instanciation of inherited class
        $pdf = new PDF($title);
        $pdf->setTitle($title);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        
        $fromheader = array('From','To');
        $fromdata = array(
                        array('WeedTree',$company->company_name),
                        array('Danube str, ext 10, Lenasia, 1820',$company->company_address),
                        array('0826147353',$company->contact_number),
                        array('ck','ck')

                    );

        $pdf->ImprovedTable($fromheader,$fromdata);
       
        $pdf->Ln(6);

        $header = array('Item', 'Batch', 'Product', 'Quantity' , 'Value');
        $data = array(
                    array('1',$invoice->batch_id,$product->product_name,$invoice->quantity,$invoice->value)
                    // array('1','2','3','4','5'),
                    // array('1','2','3','4','5'),
                    // array('1','2','3','4','5')
                );
        $pdf->FancyTable($header,$data);
        $pdf->Output();    

    }

    function pay($invoice_id=0) {
        
        
            $invoice = new Invoice($invoice_id);
            $old_data = $invoice->to_array();

            $batch = new Batch($invoice->batch_id);

            if ($batch->quantity >= $invoice->quantity){

                $batch->quantity -= $invoice->quantity;
                $batch->update();
                $batch->delete_cache();

                $invoice->updated = date('Y-m-d H:i:s');
                $invoice->type = 'Tax';
                $invoice->update();
                $this->transaction->log(serialize($invoice->to_array() ), serialize($old_data) );
                $invoice->delete_cache();
                $this->redirect('admin/invoice/?success=1');
            }
            else{
                $error = "Batch does not have sufficient quatity";
                $this->set('invalid',1);
                $this->set('error',$error);
                $this->redirect('admin/invoice/?error=1&'.$error);
            }


    }

    function approve($invoice_id=0) {
        
        $invoice = new Invoice($invoice_id);
        // $old_data = $invoice->to_array();
        if (!$invoice->id && $invoice_id) {
            $this->redirect("invoice");
        }

        $invoice->status = "Approved";
        $invoice->update();
        // $invoice->delete_cache();

        $project = Project::query("SELECT *,p.id AS project_id, 
                                         c.id AS customer_id, 
                                         c.name AS customer_name, 
                                         c.surname AS customer_surname, 
                                         c.email AS customer_email, 
                                         p.name AS project_name,
                                         t.id AS technical_id 
                                FROM projects p 
                                LEFT JOIN customers c ON p.customer_id=c.id
                                LEFT JOIN technicals t ON p.id=t.project_id
                                WHERE p.id=$invoice->project_id
                                ;")->fetch();           

        $mail_vars = array(
            'name' => $project['customer_name'] .' '.$project['customer_surname'],
            'email' => $project['customer_email']
        );

        Message_template::send($project['customer_email'], Message_template::INVOICE_CREATED, $mail_vars,$invoice->file);

        $this->redirect('invoice/?success=1');

    }   
}

?>