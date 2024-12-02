<?php /* Smarty version 2.6.29, created on 2022-06-01 08:48:55
         compiled from /home/yourtctw/public_html/cooperate/views/coact/auth_login.tpl */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cooperate</title>
    <!-- Global stylesheets -->
    <link rel="icon" href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/images/favicon.png" >
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /theme JS files -->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/components_modals.js"></script>
</head>

<body class="login-container">

    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content" >
          <!-- <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified">Launch <i class="icon-play3 position-right"></i></button> -->


          <?php if ($this->_tpl_vars['login_error']): ?>
          <?php echo '
              <script>
                $(document).ready(function(){
                  $(\'#modal_iconified\').modal();    
                });
              </script>
          '; ?>

          <?php endif; ?>
          <!-- Iconified modal -->
          <div id="modal_iconified" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-danger">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Login Error</h5>
                </div>

                <div class="modal-body">
                  <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                            <span class="text-semibold">Sorry!</span> seems like that didnt work.
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>

                  <h6 class="text-semibold"><i class="icon-law position-left"></i> Please Try again</h6>
                  <p>Make sure CAPS LOCK is not on :)</p>

                  <hr>

                  <p><i class="icon-mention position-left"></i> If that fails then you should give up. hehehe</p>
                </div>

                <div class="modal-footer">
                  <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                  <!-- <button class="btn btn-primary"><i class="icon-check"></i> Save</button> -->
                </div>
              </div>
            </div>
          </div>
          <!-- /iconified modal -->

            <!-- Main content -->
            <div class="content-wrapper">
                <!-- Content area -->
                <div class="content" >
                    <!-- Simple login form -->
                    <form action="/login" method="post">
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                                <h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <input type="text" class="form-control" placeholder="Email" name="data[email]">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" class="form-control" placeholder="Password" name="data[password]">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn bg-warning-300 btn-block" name="login">Sign in <i class="icon-circle-right2 position-right"></i></button>
                            </div>
                            <div class="text-center">
                                <a href="login_password_recover.html" class="btn bg-blue-400 btn-block">Forgot password?</a><br>
                            </div>

<!--                             <div class="text-center">
                                <a href="/lead/add" class="btn bg-pink-400 btn-block">Capture Sales Lead</a>
                            </div> -->
                        </div>
                    </form>
                    <!-- /simple login form -->
                    <!-- Footer -->
                    <div class="footer text-muted text-center">
                       
                    </div>
                    <!-- /footer -->
                </div>
                <!-- /content area -->
            </div>
            <!-- /main content -->
        </div>
        <!-- /page content -->

        </div>
<?php if ($_GET['activate']): ?>
    <?php echo '
    <script>
        $(document).ready(function(){
          $(\'#modal_theme_activate\').modal(); 
        });
      </script>
    '; ?>

<?php endif; ?>
<!-- activate modal -->
<div id="modal_theme_activate" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Activation</h6>
            </div>

            <div class="modal-body">
                <h6 class="text-semibold">Your Activation was Successful</h6>
                <p>Congrats on a job well done.</p>

                <hr>

                <h6 class="text-semibold">Please close this box and login with your credentials</h6>

                <hr>

                <h6 class="text-semibold">P.S.</h6>
                <p>Every activate is a step closer to the goal.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-activate">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<!-- /activate modal -->


<?php if ($_GET['failure']): ?>
    <?php echo '
    <script>
        $(document).ready(function(){
          $(\'#modal_theme_failure\').modal(); 
        });
      </script>
    '; ?>

<?php endif; ?>
<!-- failure modal -->
<div id="modal_theme_failure" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Failure</h6>
            </div>

            <div class="modal-body">
                <h6 class="text-semibold">Your Activation was Not successful</h6>
                <p>Please contact The administrator.</p>

                <hr>

                <h6 class="text-semibold">P.S.</h6>
                <p>Every activate is a step closer to the goal.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-success">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<!-- /failure modal -->
    </div>
    <!-- /page container -->
</body>

</html>