
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '/message/attach/';


/*
	$('.fileinput-button .minibutton').click(function(){
		$('#fileupload').trigger('click');
	});
*/
	 $('#fileupload').click(function(){
	 	$('#progress').show();
	 });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name.substring(0,10)+'...complete').appendTo('#files');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});