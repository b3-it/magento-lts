document.observe("dom:loaded", function() {
	
	var actionTags = new Array("a");
	var noActionClasses = new Array("link-rss", "no-loading-mask");
	
	var currentClickedNoActionElement = null;
	
	$(actionTags).each(function(item) {
		$$(item).each(function(element){
			Event.observe(element, 'click', function(event) {
				var src = Event.element(event);
				$(noActionClasses).each(function(noActionClass) {
					if (!src)
						return;
					
					var oClass;
					if (src.hasAttribute('class')) {
						oClass = src.readAttribute('class');
					} else if (src.up().hasAttribute('class')) {
						oClass = src.up().readAttribute('class');
					}
					
					if (oClass && oClass.indexOf(noActionClass) != -1) {
						currentClickedNoActionElement = src;
						return;
					}
						
					//currentClickedNoActionElement = null;
				});
				
			});
		});
		
	});
	
	$$('form').each(function(form) {
		Event.observe(form, 'submit', function(event) {
			if (event.stopped) {
				var loadingMask = $('loading-mask');
				loadingMask.hide();
			}
		});
	});
	
	var hideMessage=document.readyState?function(){
        setTimeout(function(){
            if(document.readyState!='complete' && document.readyState!='loading'){
            	var loadingMask = $('loading-mask');
				loadingMask.hide();
            } else {
            	/* IE8 specific*/
            	if (Prototype.Browser.IE && parseInt(navigator.userAgent.substring(navigator.userAgent.indexOf("MSIE")+5)) == 8) {
            		$('loading-mask').style.zIndex = 9998 + Math.floor((Math.random()*10)+1);
            		$('loading-mask').down().style.zIndex = $('loading-mask').style.zIndex + 1;
            	}
				hideMessage();
            }
        },100);
    }:function(){
    	var loadingMask = $('loading-mask');
		loadingMask.hide();
    };
    function displayMessage(){
    	var loadingMask = $('loading-mask');
		
		if (!loadingMask.visible() && currentClickedNoActionElement == null) {
			loadingMask.show();
			
			//Workaround for IE all Versions
			//Animated GIF freeze on page loads/submit
			setTimeout(function() {
					var img = $("loading-mask").down().down();
					img.writeAttribute("src", img.readAttribute("src"));
				}, 
				200
			);
			
			return;
		}
    }
    
	Event.observe(window, 'beforeunload', function(event) {
		displayMessage();
        setTimeout(hideMessage,document.readyState?10:5000);
	});
});