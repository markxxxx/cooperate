$(function(){	

	$('.finantial_header').click(function(){
		$('.report_break_down').hide();
		$('#report_'+$(this).attr('data-year')).show();
	});
	var navSelector = "ul#menu li";/** define the main navigation selector **/

	/** set up rounded corners for the selected elements **/
	 $('.box-container').corners("5px bottom");
	 $('.box h4').corners("5px top");
	 $('ul.tab-menu li a').corners("5px top");
	 $('textarea#wysiwyg, .wysiwyg ').wysiwyg();
	 //$("div#sys-messages-container a, div#to-do-list ul li a").colorbox({fixedWidth:"50%", transitionSpeed:"100", inline:true, href:"#sample-modal"}); /** jquery colorbox modal boxes for system
	 //messages and to-do list - see colorbox help docs for help: http://colorpowered.com/colorbox/ **/

	$('.tab-menu').tabs();		 

	//$("ul.list-links").accordion();/** side menu accordion - see jquery ui docs for help:  http://jqueryui.com/demos/  **/
	$('a[href*="delete"]').click(function(e){
		var delete_record = confirm('Are you sure that you want to delete this record');
		if(delete_record == true) {
			parent.location.href = $(this).attr('href');
		}
		return false;
	});

	$(".colorbox").colorbox();

	$('body').delegate('a.colorbox', 'click', function() { 
		$(this).colorbox();
	 });



 
	jQuery(navSelector).find('a').css( {backgroundPosition: "0 0"} );
	
	jQuery(navSelector).hover(function(){/** build animated dropdown navigation **/
		jQuery(this).find('ul:first:hidden').css({visibility: "visible",display: "none"}).show("fast");
		jQuery(this).find('a').stop().animate({backgroundPosition:"(0 -40px)"},{duration:150});
 	   jQuery(this).find('a.top-level').addClass("blue");
		},function(){
		jQuery(this).find('ul:first').css({visibility: "hidden", display:"none"});
		jQuery(this).find('a').stop().animate({backgroundPosition:"(0 0)"}, {duration:75});
		jQuery(this).find('a.top-level').removeClass("blue");
		});
	});