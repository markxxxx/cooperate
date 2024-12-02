<?php

class SetupController extends AppController {

    private $per_page = 100;

    public function before_action() {

        parent::before_action();

        if (!$this->user->can_access($this->controller_name, $this->method_name)) {
            $_SESSION['redirect'] = urlencode(substr($_SERVER['REQUEST_URI'], 1));
            $this->redirect('login');
        }
    }

    function index($page=0) {

    }


    function accessory($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $accessories = Accessory::find(array( 'where' => $filter))->fetch_all();
        $total_accessories = Accessory::count(array('where' => $filter));

        $this->set(array(
            'accessories' => $accessories,
            'total_accessories' => $total_accessories,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function accessory_add($accessory_id = 0) {

        $accessory = new Accessory($accessory_id);

        if (!$accessory->id && $accessory_id) {
            $this->redirect("setup/accessory");
        }

        if (isset($_POST['data'])) {

            $accessory->update_map($_POST['data']);

            if ($accessory->id) {
                $accessory->remove_validation('email', 'unique');
            }

            $accessory->email = trim($accessory->email);

            $is_new_accessory = false;

            if ($accessory->validate()) {
                if (!$accessory->id) {

                    $accessory->insert();
                    $is_new_accessory = true;

                } else {
                    $accessory->update();
                }

                if($is_new_accessory) {
                    $this->redirect('setup/accessory?success=1');
                } else {
                    // $this->redirect('accessory/edit/'.$accessory->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('setup/accessory?success=1');
                }

            } else {
                $this->set('project_id', $project->id);
                $_POST['data']['id'] = $accessory->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $accessory->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function accessory_edit($accessory_id = 0) {
        if ($accessory_id == 0) {
            $this->redirect("setup/accessory");
        }
        $this->set_view('setup/accessory_add');
        $this->add($accessory_id);
    }

    public function accessory_delete($accessory_id) {
        Accessory::delete($accessory_id);
        $this->redirect('referer');
    }


    function jobtype($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $jobtypes = Jobtype::find(array( 'where' => $filter))->fetch_all();
        $total_jobtypes = Jobtype::count(array('where' => $filter));

        $this->set(array(
            'jobtypes' => $jobtypes,
            'total_jobtypes' => $total_jobtypes,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function jobtype_add($jobtype_id = 0) {

        $jobtype = new Jobtype($jobtype_id);

        if (!$jobtype->id && $jobtype_id) {
            $this->redirect("jobtype");
        }

        if (isset($_POST['data'])) {

            $jobtype->update_map($_POST['data']);
            $is_new_jobtype = false;

            if ($jobtype->validate()) {
                if (!$jobtype->id) {

                    $jobtype->insert();
                    $is_new_jobtype = true;

                } else {
                    $jobtype->update();
                }

                if($is_new_jobtype) {
                    $this->redirect('jobtype?success=1');
                } else {
                    // $this->redirect('jobtype/edit/'.$jobtype->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('jobtype?success=1');
                }

            } else {
                $this->set('project_id', $project->id);
                $_POST['data']['id'] = $jobtype->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $jobtype->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function jobtype_edit($jobtype_id = 0) {
        if ($jobtype_id == 0) {
            $this->redirect("jobtype");
        }
        $this->set_view('jobtype_add');
        $this->add($jobtype_id);
    }

    public function jobtype_delete($jobtype_id) {
        Jobtype::delete($jobtype_id);
        $this->redirect('referer');
    }


    function cupboardheight($page=0){

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $cupboardheights = Cupboardheight::find(array( 'where' => $filter))->fetch_all();
        $total_cupboardheights = Cupboardheight::count(array('where' => $filter));

        $this->set(array(
            'cupboardheights' => $cupboardheights,
            'total_cupboardheights' => $total_cupboardheights,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function cupboardheight_add($cupboardheight_id = 0) {

        $cupboardheight = new Cupboardheight($cupboardheight_id);

        if (!$cupboardheight->id && $cupboardheight_id) {
            $this->redirect("cupboardheight");
        }

        if (isset($_POST['data'])) {

            $cupboardheight->update_map($_POST['data']);
            $is_new_cupboardheight = false;

            if ($cupboardheight->validate()) {
                if (!$cupboardheight->id) {

                    $cupboardheight->insert();
                    $is_new_cupboardheight = true;

                } else {
                    $cupboardheight->update();
                }

                if($is_new_cupboardheight) {
                    $this->redirect('cupboardheight?success=1');
                } else {
                    // $this->redirect('cupboardheight/edit/'.$cupboardheight->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('cupboardheight?success=1');
                }

            } else {
                $this->set('project_id', $project->id);
                $_POST['data']['id'] = $cupboardheight->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $cupboardheight->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function cupboardheight_edit($cupboardheight_id = 0) {
        if ($cupboardheight_id == 0) {
            $this->redirect("cupboardheight");
        }
        $this->set_view('cupboardheight_add');
        $this->add($cupboardheight_id);
    }

    public function cupboardheight_delete($cupboardheight_id) {
        Cupboardheight::delete($cupboardheight_id);
        $this->redirect('referer');
    }


    function finish($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $finishes = Finish::find(array( 'where' => $filter))->fetch_all();
        $total_finishes = Finish::count(array('where' => $filter));

        $this->set(array(
            'finishes' => $finishes,
            'total_finishes' => $total_finishes,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function finish_add($finish_id = 0) {

        $finish = new Finish($finish_id);

        if (!$finish->id && $finish_id) {
            $this->redirect("finish");
        }

        if (isset($_POST['data'])) {

            $finish->update_map($_POST['data']);
            $is_new_finish = false;

            if ($finish->validate()) {
                if (!$finish->id) {

                    $finish->insert();
                    $is_new_finish = true;

                } else {
                    $finish->update();
                }

                if($is_new_finish) {
                    $this->redirect('finish?success=1');
                } else {
                    // $this->redirect('finish/edit/'.$finish->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('finish?success=1');
                }

            } else {
                $this->set('project_id', $project->id);
                $_POST['data']['id'] = $finish->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $finish->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function finish_edit($finish_id = 0) {
        if ($finish_id == 0) {
            $this->redirect("finish");
        }
        $this->set_view('finish_add');
        $this->add($finish_id);
    }

    public function finish_delete($finish_id) {
        Finish::delete($finish_id);
        $this->redirect('referer');
    }


    function colour($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $colours = Colour::find(array( 'where' => $filter))->fetch_all();
        $total_colours = Colour::count(array('where' => $filter));

        $this->set(array(
            'colours' => $colours,
            'total_colours' => $total_colours,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function colour_add($colour_id = 0) {

        $colour = new Colour($colour_id);

        if (!$colour->id && $colour_id) {
            $this->redirect("colour");
        }

        if (isset($_POST['data'])) {

            $colour->update_map($_POST['data']);
            $is_new_colour = false;

            if ($colour->validate()) {
                if (!$colour->id) {

                    $colour->insert();
                    $is_new_colour = true;

                } else {
                    $colour->update();
                }

                if($is_new_colour) {
                    $this->redirect('colour?success=1');
                } else {
                    // $this->redirect('colour/edit/'.$colour->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('colour?success=1');
                }

            } else {
                $this->set('project_id', $project->id);
                $_POST['data']['id'] = $colour->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $colour->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function colour_edit($colour_id = 0) {
        if ($colour_id == 0) {
            $this->redirect("colour");
        }
        $this->set_view('colour_add');
        $this->add($colour_id);
    }

    public function colour_delete($colour_id) {
        Colour::delete($colour_id);
        $this->redirect('referer');
    }


    function edging($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $edgings = Edging::find(array( 'where' => $filter))->fetch_all();
        $total_edgings = Edging::count(array('where' => $filter));

        $this->set(array(
            'edgings' => $edgings,
            'total_edgings' => $total_edgings,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function edging_add($edging_id = 0) {

        $edging = new Edging($edging_id);

        if (!$edging->id && $edging_id) {
            $this->redirect("edging");
        }

        if (isset($_POST['data'])) {

            $edging->update_map($_POST['data']);
            $is_new_edging = false;

            if ($edging->validate()) {
                if (!$edging->id) {

                    $edging->insert();
                    $is_new_edging = true;

                } else {
                    $edging->update();
                }

                if($is_new_edging) {
                    $this->redirect('edging?success=1');
                } else {
                    // $this->redirect('edging/edit/'.$edging->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('edging?success=1');
                }

            } else {
                $this->set('project_id', $project->id);
                $_POST['data']['id'] = $edging->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $edging->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function edging_edit($edging_id = 0) {
        if ($edging_id == 0) {
            $this->redirect("edging");
        }
        $this->set_view('edging_add');
        $this->add($edging_id);
    }

    public function edging_delete($edging_id) {
        Edging::delete($edging_id);
        $this->redirect('referer');
    }


    function kickplate($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $kickplates = Kickplate::find(array( 'where' => $filter))->fetch_all();
        $total_kickplates = Kickplate::count(array('where' => $filter));

        $this->set(array(
            'kickplates' => $kickplates,
            'total_kickplates' => $total_kickplates,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function kickplate_add($kickplate_id = 0) {

        $kickplate = new Kickplate($kickplate_id);

        if (!$kickplate->id && $kickplate_id) {
            $this->redirect("kickplate");
        }

        if (isset($_POST['data'])) {

            $kickplate->update_map($_POST['data']);
            $is_new_kickplate = false;

            if ($kickplate->validate()) {
                if (!$kickplate->id) {

                    $kickplate->insert();
                    $is_new_kickplate = true;

                } else {
                    $kickplate->update();
                }

                if($is_new_kickplate) {
                    $this->redirect('kickplate?success=1');
                } else {
                    // $this->redirect('kickplate/edit/'.$kickplate->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('kickplate?success=1');
                }

            } else {
                // $this->set('project_id', $project->id);
                $_POST['data']['id'] = $kickplate->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $kickplate->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function kickplate_edit($kickplate_id = 0) {
        if ($kickplate_id == 0) {
            $this->redirect("kickplate");
        }
        $this->set_view('kickplate_add');
        $this->add($kickplate_id);
    }

    public function kickplate_delete($kickplate_id) {
        Kickplate::delete($kickplate_id);
        $this->redirect('referer');
    }


    function topthickness($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $topthicknesses = Topthickness::find(array( 'where' => $filter))->fetch_all();
        $total_topthicknesses = Topthickness::count(array('where' => $filter));

        $this->set(array(
            'topthicknesses' => $topthicknesses,
            'total_topthicknesses' => $total_topthicknesses,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function topthickness_add($topthickness_id = 0) {

        $topthickness = new Topthickness($topthickness_id);

        if (!$topthickness->id && $topthickness_id) {
            $this->redirect("topthickness");
        }

        if (isset($_POST['data'])) {

            $topthickness->update_map($_POST['data']);
            $is_new_topthickness = false;

            if ($topthickness->validate()) {
                if (!$topthickness->id) {

                    $topthickness->insert();
                    $is_new_topthickness = true;

                } else {
                    $topthickness->update();
                }

                if($is_new_topthickness) {
                    $this->redirect('topthickness?success=1');
                } else {
                    // $this->redirect('topthickness/edit/'.$topthickness->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('topthickness?success=1');
                }

            } else {
                // $this->set('project_id', $project->id);
                $_POST['data']['id'] = $topthickness->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $topthickness->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function topthickness_edit($topthickness_id = 0) {
        if ($topthickness_id == 0) {
            $this->redirect("topthickness");
        }
        $this->set_view('topthickness_add');
        $this->add($topthickness_id);
    }

    public function topthickness_delete($topthickness_id) {
        Topthickness::delete($topthickness_id);
        $this->redirect('referer');
    }


    function toptype($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $toptypes = Toptype::find(array( 'where' => $filter))->fetch_all();
        $total_toptypes = Toptype::count(array('where' => $filter));

        $this->set(array(
            'toptypes' => $toptypes,
            'total_toptypes' => $total_toptypes,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function toptype_add($toptype_id = 0) {

        $toptype = new Toptype($toptype_id);

        if (!$toptype->id && $toptype_id) {
            $this->redirect("toptype");
        }

        if (isset($_POST['data'])) {

            $toptype->update_map($_POST['data']);
            $is_new_toptype = false;

            if ($toptype->validate()) {
                if (!$toptype->id) {

                    $toptype->insert();
                    $is_new_toptype = true;

                } else {
                    $toptype->update();
                }

                if($is_new_toptype) {
                    $this->redirect('toptype?success=1');
                } else {
                    // $this->redirect('toptype/edit/'.$toptype->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('toptype?success=1');
                }

            } else {
                // $this->set('project_id', $project->id);
                $_POST['data']['id'] = $toptype->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $toptype->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function toptype_edit($toptype_id = 0) {
        if ($toptype_id == 0) {
            $this->redirect("toptype");
        }
        $this->set_view('toptype_add');
        $this->add($toptype_id);
    }

    public function toptype_delete($toptype_id) {
        Toptype::delete($toptype_id);
        $this->redirect('referer');
    }


    function handlesize($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $handlesizes = Handlesize::find(array( 'where' => $filter))->fetch_all();
        $total_handlesizes = Handlesize::count(array('where' => $filter));

        $this->set(array(
            'handlesizes' => $handlesizes,
            'total_handlesizes' => $total_handlesizes,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function handlesize_add($handlesize_id = 0) {

        $handlesize = new Handlesize($handlesize_id);

        if (!$handlesize->id && $handlesize_id) {
            $this->redirect("handlesize");
        }

        if (isset($_POST['data'])) {

            $handlesize->update_map($_POST['data']);
            $is_new_handlesize = false;

            if ($handlesize->validate()) {
                if (!$handlesize->id) {

                    $handlesize->insert();
                    $is_new_handlesize = true;

                } else {
                    $handlesize->update();
                }

                if($is_new_handlesize) {
                    $this->redirect('handlesize?success=1');
                } else {
                    // $this->redirect('handlesize/edit/'.$handlesize->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('handlesize?success=1');
                }

            } else {
                // $this->set('project_id', $project->id);
                $_POST['data']['id'] = $handlesize->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $handlesize->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function handlesize_edit($handlesize_id = 0) {
        if ($handlesize_id == 0) {
            $this->redirect("handlesize");
        }
        $this->set_view('handlesize_add');
        $this->add($handlesize_id);
    }

    public function handlesize_delete($handlesize_id) {
        Handlesize::delete($handlesize_id);
        $this->redirect('referer');
    }


    function handletype($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $handletypes = Handletype::find(array( 'where' => $filter))->fetch_all();
        $total_handletypes = Handletype::count(array('where' => $filter));

        $this->set(array(
            'handletypes' => $handletypes,
            'total_handletypes' => $total_handletypes,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function handletype_add($handletype_id = 0) {

        $handletype = new Handletype($handletype_id);

        if (!$handletype->id && $handletype_id) {
            $this->redirect("handletype");
        }

        if (isset($_POST['data'])) {

            $handletype->update_map($_POST['data']);
            $is_new_handletype = false;

            if ($handletype->validate()) {
                if (!$handletype->id) {

                    $handletype->insert();
                    $is_new_handletype = true;

                } else {
                    $handletype->update();
                }

                if($is_new_handletype) {
                    $this->redirect('handletype?success=1');
                } else {
                    // $this->redirect('handletype/edit/'.$handletype->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('handletype?success=1');
                }

            } else {
                // $this->set('project_id', $project->id);
                $_POST['data']['id'] = $handletype->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $handletype->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function handletype_edit($handletype_id = 0) {
        if ($handletype_id == 0) {
            $this->redirect("handletype");
        }
        $this->set_view('handletype_add');
        $this->add($handletype_id);
    }

    public function handletype_delete($handletype_id) {
        Handletype::delete($handletype_id);
        $this->redirect('referer');
    }


    function runner($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $runners = Runner::find(array( 'where' => $filter))->fetch_all();
        $total_runners = Runner::count(array('where' => $filter));

        $this->set(array(
            'runners' => $runners,
            'total_runners' => $total_runners,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function runner_add($runner_id = 0) {

        $runner = new Runner($runner_id);

        if (!$runner->id && $runner_id) {
            $this->redirect("runner");
        }

        if (isset($_POST['data'])) {

            $runner->update_map($_POST['data']);
            $is_new_runner = false;

            if ($runner->validate()) {
                if (!$runner->id) {

                    $runner->insert();
                    $is_new_runner = true;

                } else {
                    $runner->update();
                }

                if($is_new_runner) {
                    $this->redirect('runner?success=1');
                } else {
                    // $this->redirect('runner/edit/'.$runner->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('runner?success=1');
                }

            } else {
                // $this->set('project_id', $project->id);
                $_POST['data']['id'] = $runner->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $runner->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function runner_edit($runner_id = 0) {
        if ($runner_id == 0) {
            $this->redirect("runner");
        }
        $this->set_view('runner_add');
        $this->add($runner_id);
    }

    public function runner_delete($runner_id) {
        Runner::delete($runner_id);
        $this->redirect('referer');
    }


    function hinge($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $hinges = Hinge::find(array( 'where' => $filter))->fetch_all();
        $total_hinges = Hinge::count(array('where' => $filter));

        $this->set(array(
            'hinges' => $hinges,
            'total_hinges' => $total_hinges,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function hinge_add($hinge_id = 0) {

        $hinge = new Hinge($hinge_id);

        if (!$hinge->id && $hinge_id) {
            $this->redirect("hinge");
        }

        if (isset($_POST['data'])) {

            $hinge->update_map($_POST['data']);
            $is_new_hinge = false;

            if ($hinge->validate()) {
                if (!$hinge->id) {

                    $hinge->insert();
                    $is_new_hinge = true;

                } else {
                    $hinge->update();
                }

                if($is_new_hinge) {
                    $this->redirect('hinge?success=1');
                } else {
                    // $this->redirect('hinge/edit/'.$hinge->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('hinge?success=1');
                }

            } else {
                // $this->set('project_id', $project->id);
                $_POST['data']['id'] = $hinge->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $hinge->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function hinge_edit($hinge_id = 0) {
        if ($hinge_id == 0) {
            $this->redirect("hinge");
        }
        $this->set_view('hinge_add');
        $this->add($hinge_id);
    }

    public function hinge_delete($hinge_id) {
        Hinge::delete($hinge_id);
        $this->redirect('referer');
    }


    function sink($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $sinks = Sink::find(array( 'where' => $filter))->fetch_all();
        $total_sinks = Sink::count(array('where' => $filter));

        $this->set(array(
            'sinks' => $sinks,
            'total_sinks' => $total_sinks,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function sink_add($sink_id = 0) {

        $sink = new Sink($sink_id);

        if (!$sink->id && $sink_id) {
            $this->redirect("sink");
        }

        if (isset($_POST['data'])) {

            $sink->update_map($_POST['data']);
            $is_new_sink = false;

            if ($sink->validate()) {
                if (!$sink->id) {

                    $sink->insert();
                    $is_new_sink = true;

                } else {
                    $sink->update();
                }

                if($is_new_sink) {
                    $this->redirect('sink?success=1');
                } else {
                    // $this->redirect('sink/edit/'.$sink->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('sink?success=1');
                }

            } else {
                // $this->set('project_id', $project->id);
                $_POST['data']['id'] = $sink->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $sink->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function sink_edit($sink_id = 0) {
        if ($sink_id == 0) {
            $this->redirect("sink");
        }
        $this->set_view('sink_add');
        $this->add($sink_id);
    }

    public function sink_delete($sink_id) {
        Sink::delete($sink_id);
        $this->redirect('referer');
    }


    function prepbowl($page=0) {

        $filter = 'TRUE';
        //$limit = ($page * $this->per_page) . ' , ' . $this->per_page;

        $prepbowls = Prepbowl::find(array( 'where' => $filter))->fetch_all();
        $total_prepbowls = Prepbowl::count(array('where' => $filter));

        $this->set(array(
            'prepbowls' => $prepbowls,
            'total_prepbowls' => $total_prepbowls,
            'per_page' => $this->per_page,
            'page' => $page
        ));

    }

    public function prepbowl_add($prepbowl_id = 0) {

        $prepbowl = new Prepbowl($prepbowl_id);

        if (!$prepbowl->id && $prepbowl_id) {
            $this->redirect("prepbowl");
        }

        if (isset($_POST['data'])) {

            $prepbowl->update_map($_POST['data']);
            $is_new_prepbowl = false;

            if ($prepbowl->validate()) {
                if (!$prepbowl->id) {

                    $prepbowl->insert();
                    $is_new_prepbowl = true;

                } else {
                    $prepbowl->update();
                }

                if($is_new_prepbowl) {
                    $this->redirect('prepbowl?success=1');
                } else {
                    // $this->redirect('prepbowl/edit/'.$prepbowl->id.'?confirmation=detailsupdated&success=1');
                    $this->redirect('prepbowl?success=1');
                }

            } else {
                // $this->set('project_id', $project->id);
                $_POST['data']['id'] = $prepbowl->id;
                $this->set('data', $_POST['data']);
                $this->set('invalid', 1);
            }
        } else {
            $this->set('data', $prepbowl->to_array());
            $this->set('project_id', $project->id);
        }
    }

    public function prepbowl_edit($prepbowl_id = 0) {
        if ($prepbowl_id == 0) {
            $this->redirect("prepbowl");
        }
        $this->set_view('prepbowl_add');
        $this->add($prepbowl_id);
    }

    public function prepbowl_delete($prepbowl_id) {
        Prepbowl::delete($prepbowl_id);
        $this->redirect('referer');
    }

}
?>