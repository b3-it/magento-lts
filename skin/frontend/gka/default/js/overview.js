$j(document).ready(function() {
   	$j('.name-middlename').remove();
	
	$j('#address').accordion({
       	'active'     : false,
       	'collapsible': true,
       	'heightStyle': 'content',
       	'icons'      : {
   			'header'      : 'ui-icon-circle-plus',
   			'activeHeader': 'ui-icon-circle-minus'
       	},
       	'activate': function(event, ui) {
       		$j('body').getNiceScroll().resize();
       	}
    });
});