<?php declare(strict_types=1)

// require_once('include/fpdf/fpdf.php');

// class PDF extends FPDF
// {

//     // Page header
//     function Header()
//     {
//         // Logo
//         $this->Image('media/customer/logo.png',10,6,30);
//         // Arial bold 15
//         $this->SetFont('Arial','B',15);
//         // Move to the right
//         $this->Cell(80);
//         // Title
//         $this->Cell(80,10,$this->title,1,0,'C');
//         // Line break
//         $this->Ln(30);
//     }

//     // Page footer
//     function Footer()
//     {
//         // Position at 1.5 cm from bottom
//         $this->SetY(-15);
//         // Arial italic 8
//         $this->SetFont('Arial','I',8);
//         // Page number
//         $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
//     }

//     // Better table
//     function ImprovedTable($header, $data)
//     {
//         // Column widths
//         $w = array(95,95);
//         // Header
//         for($i=0;$i<count($header);$i++)
//             $this->Cell($w[$i],7,$header[$i],1,0,'C');
//         $this->Ln();
//         // Data
//         foreach($data as $row)
//         {
//             $this->Cell($w[0],6,$row[0],'LR');
//             $this->Cell($w[1],6,$row[1],'LR');
//             // $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
//             // $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
//             $this->Ln();
//         }
//         // Closing line
//         $this->Cell(array_sum($w),0,'','T');
        
//     }

//         // Colored table
//     function FancyTable($header, $data)
//     {
//         // Colors, line width and bold font
//         $this->SetFillColor(192, 192, 192);
//         $this->SetTextColor(0);
//         $this->SetDrawColor(0, 0, 0);
//         $this->SetLineWidth(.3);
//         $this->SetFont('','B');
//         // Header
//         $w = array(15, 20, 60, 45, 50);
//         for($i=0;$i<count($header);$i++)
//             $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
//         $this->Ln();
//         // Color and font restoration
//         $this->SetFillColor(230, 255, 242);
//         $this->SetTextColor(0);
//         $this->SetFont('');
//         // Data
//         $fill = false;
//         foreach($data as $row)
//         {
//             $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
//             $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
//             $this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
//             $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
//             $this->Cell($w[4],6,number_format($row[4]),'LR',0,'R',$fill);

//             $this->Ln();
//             $fill = !$fill;
//         }
//         // Closing line
//         $this->Cell(array_sum($w),0,'','T');
//     }
// }

class QuoteController extends AppController {

    function index($project_id=0) {

        // Get the selected project details
        $currentProject = new Project($project_id);

        // Check if no project was selected
        if (!$currentProject->id && $project_id==0) {

            // Get a list of quotes for all projects
            $quotes = Quote::query("
                SELECT
                    q.id as quote_id,
                    q.quote_status as quote_status,
                    q.created as created,
                    q.project_plan as project_plan,
                    q.file as file,
                    p.name as project_name,
                    c.name as customer_name,
                    c.surname as customer_surname,
                    c.contact_number as contact_number,
                    c.company as customer_company
                FROM quotes q
                LEFT JOIN projects p ON p.id = q.project_id
                LEFT JOIN customers c ON c.id = p.customer_id;
            ")->fetch_all();

        }
        else{

            // Get a list of quotes for the selected project
            $quotes = Quote::query("
                SELECT
                    q.id as quote_id,
                    q.quote_status as quote_status,
                    q.created as created,
                    q.project_plan as project_plan,
                    q.file as file,
                    p.name as project_name,
                    c.name as customer_name,
                    c.surname as customer_surname,
                    c.contact_number as contact_number,
                    c.company as customer_company
                FROM quotes q
                LEFT JOIN projects p ON p.id = q.project_id
                LEFT JOIN customers c ON c.id = p.customer_id
                WHERE p.id = $project_id;
            ")->fetch_all();

            $this->set('data',array('project_id' => $project_id, 'project_name' => $currentProject->name ));

        }

        $this->set('quotes',$quotes);

        // Get a list of projects for the project dropdown list for adding additional quotes
        $projects = Project::query("
            SELECT
                *,
                p.id AS project_id,
                c.id AS customer_id,
                c.name AS customer_name,
                c.surname AS customer_surname,
                p.name AS project_name,
                t.id AS technical_id
            FROM projects p
            LEFT JOIN customers c ON p.customer_id=c.id
            LEFT JOIN technicals t ON p.id=t.project_id;
        ")->fetch_all();

        $this->set('projects', $projects);

    }

    // Add a new project quote
    function add($quote_id=0) {
        
        $quote = new quote($quote_id);

        if (!$quote->id && $quote_id) {
            $this->redirect("quote");
        }

        if (isset($_POST['data'])) {

            $quote->update_map($_POST['data']);
            // var_dump($_POST['data']);exit();
            $customer=new Customer($_POST['data']['customer_id']);

            if ($quote->id) {
                $quote->remove_validation('email', 'unique');
            }
      
            $is_new_quote = false;

            if ($quote->validate()) {

                if (!$quote->id) {
                    
                    $quote->user_id = $this->user->id;
                    $quote->created = date('Y-m-d H:i:s');

                    $quote->insert(); //insert here so we have an id
                    $is_new_quote = true;

                    // Upload document quote
                    if($_FILES['quote']['name'])
                    {
                        $extention=explode(".", $_FILES['quote']['name']);

                        $valid_file = true;
                         // var_dump($_FILES); exit();
                        //if no errors...
                        if(!$_FILES['quote']['error'])
                        {
                            //now is the time to modify the future file name and validate the file
                            // $new_file_name = strtolower($_FILES['quote']['tmp_name']); //rename file
                            $new_file_name = $extention[0]."_".$quote->id.".".$extention[1]; //rename file
                            if($_FILES['quote']['size'] > (4096000)) //can't be larger than 4 MB
                            {
                                $valid_file = false;
                                $message = 'Oops!  Your file\'s size is to large.';
                            }
                            
                            //if the file has passed the test
                            if($valid_file)
                            {
                                //move it to where we want it to be
                                move_uploaded_file($_FILES['quote']['tmp_name'], "documents/quotes/".$new_file_name);
                                $quote->file = $new_file_name;
                                $message = 'Congratulations!  Your file was accepted.';
                            }
                        }
                        //if there is an error...
                        else
                        {
                            //set that to be the returned message
                            $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['quote']['error'];
                        }
                    }

                    // Upload document plan(s)
                    if($_FILES['project_plan']['name'])
                    {
                        $extention=explode(".", $_FILES['project_plan']['name']);

                        $valid_file = true;
                         // var_dump($_FILES); exit();
                        //if no errors...
                        if(!$_FILES['project_plan']['error'])
                        {
                            //now is the time to modify the future file name and validate the file
                            // $new_file_name = strtolower($_FILES['quote']['tmp_name']); //rename file
                            $new_file_name = $extention[0]."_".$quote->id.".".$extention[1]; //rename file
                            if($_FILES['project_plan']['size'] > (4096000)) //can't be larger than 4 MB
                            {
                                $valid_file = false;
                                $message = 'Oops!  Your file\'s size is to large.';
                            }
                            
                            //if the file has passed the test
                            if($valid_file)
                            {
                                //move it to where we want it to be
                                move_uploaded_file($_FILES['project_plan']['tmp_name'], "documents/plans/".$new_file_name);
                                $quote->project_plan = $new_file_name;
                                $message = 'Congratulations!  Your file was accepted.';
                            }
                        }
                        //if there is an error...
                        else
                        {
                            //set that to be the returned message
                            $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['quote']['error'];
                        }
                    }

                    $quote->update();
                    
                    $project = Project::query("
                        SELECT
                            *,
                            p.id AS project_id,
                            c.id AS customer_id,
                            c.name AS customer_name,
                            c.surname AS customer_surname,
                            c.email AS customer_email,
                            p.name AS project_name,
                            t.id AS technical_id
                        FROM projects p
                        LEFT JOIN customers c ON p.customer_id=c.id
                        LEFT JOIN technicals t ON p.id=t.project_id
                        WHERE p.id=$quote->project_id;
                    ")->fetch();

                    $mail_vars = array(
                        'name' => $project['customer_name'] .' '.$project['customer_surname'],
                        'email' => $project['customer_email']
                    );

                    Message_template::send($project['customer_email'], Message_template::QUOTE_CREATED, $mail_vars,$quote->file);

                } else {

                    //uploading quote document
                    if($_FILES['quote']['name'])
                    {
                        $extention=explode(".", $_FILES['quote']['name']);

                        $valid_file = true;
                         // var_dump($_FILES); exit();
                        //if no errors...
                        if(!$_FILES['quote']['error'])
                        {
                            //now is the time to modify the future file name and validate the file
                            // $new_file_name = strtolower($_FILES['quote']['tmp_name']); //rename file
                            $new_file_name = $extention[0]."_".$quote->id.".".$extention[1]; //rename file
                            if($_FILES['quote']['size'] > (4096000)) //can't be larger than 4 MB
                            {
                                $valid_file = false;
                                $message = 'Oops!  Your file\'s size is to large.';
                            }
                            
                            //if the file has passed the test
                            if($valid_file)
                            {
                                //move it to where we want it to be
                                move_uploaded_file($_FILES['quote']['tmp_name'], "documents/quotes/".$new_file_name);
                                $quote->file = $new_file_name;
                                $message = 'Congratulations!  Your file was accepted.';
                            }
                        }
                        //if there is an error...
                        else
                        {
                            //set that to be the returned message
                            $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['quote']['error'];
                        }
                    }

                    //upload plan document
                    if($_FILES['project_plan']['name'])
                    {
                        $extention=explode(".", $_FILES['project_plan']['name']);

                        $valid_file = true;
                         // var_dump($_FILES); exit();
                        //if no errors...
                        if(!$_FILES['project_plan']['error'])
                        {
                            //now is the time to modify the future file name and validate the file
                            // $new_file_name = strtolower($_FILES['quote']['tmp_name']); //rename file
                            $new_file_name = $extention[0]."_".$quote->id.".".$extention[1]; //rename file
                            if($_FILES['project_plan']['size'] > (4096000)) //can't be larger than 4 MB
                            {
                                $valid_file = false;
                                $message = 'Oops!  Your file\'s size is to large.';
                            }
                            
                            //if the file has passed the test
                            if($valid_file)
                            {
                                //move it to where we want it to be
                                move_uploaded_file($_FILES['project_plan']['tmp_name'], "documents/plans/".$new_file_name);
                                $quote->project_plan = $new_file_name;
                                $message = 'Congratulations!  Your file was accepted.';
                            }
                        }
                        //if there is an error...
                        else
                        {
                            //set that to be the returned message
                            $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['quote']['error'];
                        }
                    }

                    $quote->update();
                    
                    $project = Project::query("
                        SELECT
                            *,
                            p.id AS project_id,
                            c.id AS customer_id,
                            c.name AS customer_name,
                            c.surname AS customer_surname,
                            c.email AS customer_email,
                            p.name AS project_name,
                            t.id AS technical_id
                        FROM projects p
                        LEFT JOIN customers c ON p.customer_id=c.id
                        LEFT JOIN technicals t ON p.id=t.project_id
                        WHERE p.id=$quote->project_id;
                    ")->fetch();

                    $mail_vars = array(
                        'name' => $project['customer_name'] .' '.$project['customer_surname'],
                        'email' => $project['customer_email']
                    );

                    Message_template::send($project['customer_email'], Message_template::QUOTE_CREATED, $mail_vars,$quote->file);
                }

                if($is_new_quote) {
                    $this->redirect('referer','?success=1');
                } else {
                    // $this->redirect('quote/edit/'.$quote->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('referer','?failure=1'); // $this->redirect('referer','?success=1');
                }

            } else {

                $_POST['data']['id'] = $quote->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);

            }

        } else {

            // Get a list of projects for adding a new quote

            $projects = Project::query("
                SELECT
                    *,
                    p.id AS project_id,
                    c.id AS customer_id,
                    c.name AS customer_name,
                    c.surname AS customer_surname,
                    p.name AS project_name,
                    t.id AS technical_id
                FROM projects p
                LEFT JOIN customers c ON p.customer_id = c.id
                LEFT JOIN technicals t ON p.id = t.project_id;
            ")->fetch_all();

            $this->set('projects', $projects);        
            $this->set('data', $quote->to_array());

        }
    }

    // Update the project quote changes
    public function edit($quote_id = 0) {

        if ($quote_id == 0) {
            $this->redirect("quote");
        }

        $this->set_view('quote_add');
        $this->add($quote_id);

    }

    // Delete the project quote (Make sure that all quote and plan documents are removed as well)
    function delete($quote_id=0) {

        $invoice = new Quote($quote_id);
        // $this->transaction->log(NULL,serialize($invoice->to_array() ) );
        Quote::delete($quote_id);        
        $this->redirect('referer');

    }

//    function delete_plan($plan_id=0) {
//
//        $invoice = new Plan($plan_id);
//        Plan::delete($plan_id);
//        $this->redirect('referer');
//
//    }

    // Get all the plans for the selected quote
    function getplans($quote_id=0) {

        // Get the selected quote details
        $currentQuote = new Quote($quote_id);

        // Check if no quote was selected
        if (!$currentQuote->id && $quote_id==0) {
        }
        else{

            // Get a list of plans for the selected quote
            $plans = Plans::query("
                SELECT
                    p.id as plan_id,
                    p.document as plan_name,
                FROM quote_plans p
                WHERE p.quote_id = $quote_id;
            ")->fetch_all();

        }

        $this->set('plans',$plans);

    }

    function print_doc($quote_id=0){

        $invoice = new Quote($quote_id);
        $company = new Customer($invoice->company_id);
        $batch = new Batch($invoice->batch_id);
        $acquisition = new Acquisition($batch->acquisition_id);
        $product = new Product($acquisition->product_id);
       
        $title =$invoice->type. ' Quote '.$invoice->id;
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

    // Change the status of the quote to "Payed"
    function pay($invoice_id=0) {

        $invoice = new Quote($invoice_id);
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

            $error = "Batch does not have sufficient quantity";
            $this->set('invalid',1);
            $this->set('error',$error);
            $this->redirect('admin/invoice/?error=1&'.$error);

        }

    }

    // Change the status of the quote to "Accepted"
    function accept($quote_id=0) {
        
        $quote = new Quote($quote_id);
        if (!$quote->id && $quote_id) {
            $this->redirect("quote");
        }
        // Update quote status
        $quote->quote_status="Accepted";
        $quote->update();

        $project = new Project($quote->project_id);
        if (!$project->id && $project_id) {
            $this->redirect("quote?failure=cannot find associated project");
        }
        // Update project status
        $project->status = 'Accepted';
        $project->update();

        // Get joint information for emailing
        $project_array = Project::query("
            SELECT
                *,
                p.id AS project_id,
                c.id AS customer_id,
                c.name AS customer_name,
                c.surname AS customer_surname,
                c.email AS customer_email,
                p.name AS project_name,
                t.id AS technical_id
            FROM projects p
            LEFT JOIN customers c ON p.customer_id = c.id
            LEFT JOIN technicals t ON p.id = t.project_id
            WHERE p.id = $project->id;
        ")->fetch();

        $mail_vars = array(
            'name' => $project_array['customer_name'] .' '.$project_array['customer_surname'],
            'email' => $project_array['customer_email']
        );
        Message_template::send($project_array['customer_email'], Message_template::STATUS_ACCEPTED, $mail_vars);

        $this->redirect('quote?success=1');
    }

    // Change the status of the quote to "Declined"
    function decline($quote_id=0) {
        
        $quote = new Quote($quote_id);
        if (!$quote->id && $quote_id) {
            $this->redirect("quote");
        }
        // Update quote status
        $quote->quote_status="Declined";
        $quote->update();

        $project = new Project($quote->project_id);
        if (!$project->id && $project_id) {
            $this->redirect("quote?failure=cannot find associated project");
        }
        // Update project status
        $project->status = 'Declined';
        $project->update();

        // Get joint information for emailing
        $project_array = Project::query("
            SELECT
                *,
                p.id AS project_id,
                c.id AS customer_id,
                c.name AS customer_name,
                c.surname AS customer_surname,
                c.email AS customer_email,
                p.name AS project_name,
                t.id AS technical_id
            FROM projects p
            LEFT JOIN customers c ON p.customer_id = c.id
            LEFT JOIN technicals t ON p.id = t.project_id
            WHERE p.id = $project->id;
        ")->fetch();

        $mail_vars = array(
            'name' => $project_array['customer_name'] .' '.$project_array['customer_surname'],
            'email' => $project_array['customer_email']
        );

        Message_template::send($project_array['customer_email'], Message_template::STATUS_DECLINED, $mail_vars);

        $this->redirect('quote?success=1');

    }

}

?>