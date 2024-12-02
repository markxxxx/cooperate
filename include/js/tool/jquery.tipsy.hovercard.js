// tipsy.hovercard, twitter style hovercards for tipsy
// version 0.1.1
// (c) 2010 René Föhring rf@bamaru.de
// released under the MIT license
(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:100,timeout:0};cfg=$.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY;};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev]);}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev]);};var handleHover=function(e){var p=(e.type=="mouseover"?e.fromElement:e.toElement)||e.relatedTarget;while(p&&p!=this){try{p=p.parentNode;}catch(e){p=this;}}if(p==this){return false;}var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);}if(e.type=="mouseover"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob);},cfg.timeout);}}};return this.mouseover(handleHover).mouseout(handleHover);};})(jQuery);
(function($) {
  $.fn.tipsyHoverCard = function(options) {
    var opts = $.extend({}, $.fn.tipsyHoverCard.defaults, options);
    this.tipsy(opts);
  
    function clearHideTimeout(ele) {
      if( ele.data('timeoutId') ) clearTimeout(ele.data('timeoutId'));
      ele.data('timeoutId', null);
    }
    function setHideTimeout(ele) {
      clearHideTimeout(ele);
      var options = ele.tipsy(true).options;
      var timeoutId = setTimeout(function() { $(ele).tipsy('hide'); }, options.hideDelay);
      ele.data('timeoutId', timeoutId);
    }
    
    function show(ele) {
      clearHideTimeout(ele);
      ele.tipsy('show');
      
      var tip = ele.tipsy('tip');
      tip.addClass('tipsy-hovercard');
      tip.data('tipsyAnchor', ele);
      tip.hover(tipEnter, tipLeave);
      
      ele.data('visible', true);
    }
    function hide(ele) {
      setHideTimeout(ele);
      ele.data('visible', false);
    }
    
    function enter() {
      var a = $(this);
      var url = a.attr('data-url');
      if( url && !a.data('ajax-success') ) {
        $.ajax({
          url: url,
          
          success: function(data){
            a.data('ajax-success', true);
            a.attr('title', data);
            if( a.data('visible') ) show(a);
          },
          error: function() {
            a.attr('title', 'Error loading '+url);
            if( a.data('visible') ) show(a);
          },
          failure: function(){
            a.attr('title', 'Failed to load '+url);
            if( a.data('visible') ) show(a);
          }
        });
      }
      show(a);
    }
    function leave() {
      hide($(this));
    }
    
    function tipEnter() {
      var a = $(this).data('tipsyAnchor');
      
      clearHideTimeout(a);
    }
    function tipLeave() {
      var a = $(this).data('tipsyAnchor');
      setHideTimeout(a);
    }

    if( $.fn.hoverIntent && opts.hoverIntent ) {
      // 'out' is called with a latency, even if 'timeout' is set to 0
      // therefore, we're using good ol' mouseleave for out-handling
      var config = $.extend({over: enter, out: function(){}}, opts.hoverIntentConfig);
      this.hoverIntent(config).mouseleave(leave);
    } else {
      this.hover(enter, leave);
    }
    return this;
  }
  
  $.fn.tipsyHoverCard.defaults = {
    gravity: 'n',
    trigger: 'manual', 
    fallback: '<img src="/views/vv/images/ajax-loader.gif" />',
    html: true,
    hideDelay: 300,
    opacity: 1,
    hoverIntent: true,
    hoverIntentConfig: {
      sensitivity: 500,
      interval: 300,
      timeout: 0
    }
  };
})(jQuery);