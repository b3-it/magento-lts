var toogleModeCtrl = function(opt_options) {

	var options = opt_options || {};
	inputName = options.inputName || 'radio-toogleMode';
	className = options.className || 'toogleModeCtrl';
	var fields = options.fields;

	var element = document.createElement('div');
	element.className = className + ' ol-unselectable ol-control';

	var i = 0;
	jQuery.each(fields, function(key, value) {
		var label = document.createElement('label');
		label.innerHTML = value;
		label.htmlFor = 'radio-' + key;

		var input = document.createElement('input');
		input.type = 'radio';
		input.id = 'radio-' + key;
		input.name = inputName;
		input.checked = i == 0;

		element.appendChild(label);
		element.appendChild(input);
		i++;
	});

	jQuery(element).find('input[type="radio"]').checkboxradio({
		icon : false
	});
	jQuery(element).controlgroup();

	ol.control.Control.call(this, {
		element : element,
		target : options.target
	});

};
ol.inherits(toogleModeCtrl, ol.control.Control);