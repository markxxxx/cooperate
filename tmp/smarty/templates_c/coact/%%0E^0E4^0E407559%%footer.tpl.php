<?php /* Smarty version 2.6.29, created on 2022-06-01 08:50:21
         compiled from footer.tpl */ ?>

<?php if ($_GET['success']): ?>
    <?php echo '
    <script>
        $(document).ready(function(){
          $(\'#modal_theme_success\').modal(); 
        });
      </script>
    '; ?>

<?php endif; ?>
<!-- Success modal -->
<div id="modal_theme_success" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Success</h6>
            </div>

            <div class="modal-body">
                <h6 class="text-semibold">The operations was successful</h6>
                <p>Congrats on a job well done.</p>

                <hr>

                <h6 class="text-semibold">P.S.</h6>
                <p>Every success is a step closer to the goal.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-success">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<!-- /success modal -->


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
                <h6 class="text-semibold">The operations was not completed successfully</h6>
                <p>Please check your information and retry.</p>
                <hr>
                <h1><?php echo $_GET['failure']; ?>
</h1>
                <h6 class="text-semibold">P.S.</h6>
                <p>If you dont try you will never know... </p>
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
<div class="footer text-muted">
    <!-- © 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a> -->
    <!-- <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_theme_success">Launch <i class="icon-play3 position-right"></i></button> -->
</div>

          

<?php if (@DEBUG): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "profiler.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
</body>
</html>