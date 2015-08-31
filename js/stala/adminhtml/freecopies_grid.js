Element.prototype.triggerEvent = function(eventName)
{
    if (document.createEvent)
    {
        var evt = document.createEvent('HTMLEvents');
        evt.initEvent(eventName, true, true);

        return this.dispatchEvent(evt);
    }

    if (this.fireEvent)
        return this.fireEvent('on' + eventName);
};

function copyGridRowFreecopyValue(grid, event){
	var target = event.element();
	//Nur bei Klick auf Zeile
	if (!target || target.tagName == "input" || target.tagName == "INPUT") {
		return;
	}
    var element = Event.findElement(event, 'tr');
    var previous = $(element).previous();
    //Prüfen ob es als individuelles Freiexemplar aktiviert ist
    if (!$(element).down().down().checked) {
    	return
    }
    if (!previous) {
    	return;
	}
    
    var freecopy = $(previous).down('.last').down('.input-text');
    if (!freecopy) {
    	return;
    }
    
    var v = $(freecopy).value;
    /*if ($(element).down('.last').next().down().value !== "") {
    	return;
    }*/
    $(element).down('.last').down('.input-text').value = v;
    
    //Ohne Focus geht es nicht!
    $(element).down('.last').down('.input-text').focus();
    
    //Prototype geht nicht!
    //$(element).down('.last').next().down().fire('change');
    //alert('prototype');
    $(element).down('.last').down('.input-text').triggerEvent('change');
    //alert('trigger');
}