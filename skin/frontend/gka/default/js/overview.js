$j(document).ready(function() {
   	$j('#address').accordion({
       	'active'     : false,
       	'collapsible': true,
       	'heightStyle': 'content',
       	'icons'      : {
   			'header'      : 'ui-icon-circle-plus',
   			'activeHeader': 'ui-icon-circle-minus'
       	}
    });
});