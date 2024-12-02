
{if $smarty.get.success}
    {literal}
    <script>
        $(document).ready(function(){
            $('#modal_theme_success').modal(); 

            window.setTimeout(function () {$("#modal_theme_success").modal("hide");}, 3000);

            // $("#modal_theme_success").modal("show").on("shown", function () {
            //     window.setTimeout(function () {
            //         $("#modal_theme_success").modal("hide");
            //     }, 5000);
            // });
        });
      </script>
    {/literal}
{/if}
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


{if $smarty.get.failure}
    {literal}
    <script>
        $(document).ready(function(){
          $('#modal_theme_failure').modal(); 
        });
      </script>
    {/literal}
{/if}
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
                <h1>{$smarty.get.failure}</h1>
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

          

{if $smarty.const.DEBUG}
    {include file="profiler.tpl"}
{/if}
</body>
</html>