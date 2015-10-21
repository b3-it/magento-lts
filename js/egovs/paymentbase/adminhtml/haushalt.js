/**
 * Es wird mindestens Prototype 1.6 benötigt!
 *
 * @category    Egovs
 * @package     Egovs_Paymentbase
 * @copyright   Copyright (c) 2013 EDV-Beratung-Hempel
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * 
 * @see egovs/bind.trigger.prototype.js Sollte in local.xml enthalten sein
 */

Haushalt = Class.create({
	containerId : '',
    container : null,
    selectBox : null,
    
    initialize : function(containerId) {
    	//Wird für getElement(...) benötigt!
    	this.containerId = containerId, this.container = $(this.containerId);
    	this.selectBox = $('type');
    	Event.observe(this.selectBox, 'change', this.onChange.bind(this));
    },
    onChange : function(event) {
    	var src = Event.element(event);
    	if (!src || !this.container) {
    		return;
    	}
    	
    	switch (src.value) {
    		case "2":
    		case "3":
    			this.container.enable();
    			break;
    		default :
    			this.container.disable();
    	}
    },
});

$(document).observe("dom:loaded", function() {
	var haushalt = new Haushalt($('hhstelle'));
	$('type').trigger('change');
});