<?php


function smarty_function_uploader($params, &$smarty) {
	return '<br />
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span class="btn btn-success fileinput-button uploadbutton" style="width:185px;text-align:center">Add attachment</span>
        <input id="fileupload" type="file" name="files[]" multiple />
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress hidden">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
    ';


}
?>