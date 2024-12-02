(function ( $ ) {
	$.fn.tabs = function() {
		
		var hashpath = location.hash;
		this.each(function() {

			init($(this));

            $(this).find('a').click(function(){
         		var hashpath = $(this).attr('href');
	    		selected(hashpath, $(this));
	    		return false;
            });
    	});

		function init(el) {
			li = el.find('li');
			a = li.eq(0).children('a');
			hashpath = location.hash;

			hashpath = (hashpath.length > 0) ? hashpath : a.attr('href');

			if(!el.find('li a[href*="'+hashpath+'"]').length) {
				hashpath = a.attr('href');
			}

			selected(hashpath , a);
		}

	    function selected(hashpath ,el) {
	    	ul = el.parent().parent();
	    	ul.find('li').removeAttr('class');
	    	ul.find('a[href*="'+hashpath+'"]').parent().addClass('tabs-selected');
	    	ul.parent().find('> .box-container').hide();
	    	$(hashpath).show();

	    }
	}
}( jQuery ));

