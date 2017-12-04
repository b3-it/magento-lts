var buttonCtrl = function(opt_options) {

    var options = opt_options || {};
    
    classname = options['classname'];
    
	var button = $j('<button />', {
		'id': '',
		'class': '',
		'html': options['text'] || "B"
	});
	   
    var this_ = this;
    
    handler = function (event) {
    	options['callback'].call(this_);
    	event.preventDefault();
    }
    button.click(handler);
    
	var container = $j('<div />', {
		'class': classname + ' ol-unselectable ol-control',
	});
	
	container.append(button);
    
	ol.control.Control.call(this, {
		element : container[0],
		target : options.target
	});
}


ol.inherits(buttonCtrl, ol.control.Control);