var sendUpdateInfo = {
	switch_mode0: function() {
  			  	var elements = ['upinfo_customergroups_send','upinfo_title','upinfo_sender_name','upinfo_sender_email','upinfo_message_subject','upinfo_message_body'];
  			  	sendUpdateInfo.toogleEnabled(false);
  				elements.each(function(data){
  					sendUpdateInfo.toogleRequire(data, false);
  				});
  			},
  			
  	switch_mode1: function() {
  				sendUpdateInfo.toogleEnabled(true);
  			  	var elements = ['upinfo_customergroups_send','upinfo_title','upinfo_sender_name','upinfo_sender_email','upinfo_message_subject','upinfo_message_body'];
  				elements.each(function(data){
  					sendUpdateInfo.toogleRequire(data, true);
  				});
  				sendUpdateInfo.customerGroups();
  			},
  			
  	switch_mode2: function() {
  				sendUpdateInfo.toogleEnabled(true);
  			  	var elements = ['upinfo_title','upinfo_sender_name','upinfo_sender_email','upinfo_message_subject','upinfo_message_body'];
  			  	sendUpdateInfo.toogleRequire('upinfo_customergroups_send', false);
  				elements.each(function(data){
  					sendUpdateInfo.toogleRequire(data, true);
  				});
  				sendUpdateInfo.customerGroups();
  			},
  	customerGroups: function(){
		  		
		  		var target = $('upinfo_customergroups_send');
		  		if(target.lenght == 0){
		  			return;
		  		}
		  		while(target.firstChild) {
		  			target.removeChild(target.firstChild);
		  		} 
  				
  				var source = $('page_customergroups_show');
  				 for (var i = 0; i < source.length; i++) {
  			        if (source.options[i].selected)
  			        { 
  			        	var value = source.options[i].value;
  			        	var text = source.options[i].text;
  			        	target.insert(new Element('option', {value: value}).update(text));
  			        };
  			    }
  				
  				
  				
  			},		
  	toogleEnabled: function(enabled){
  				var elements = ['toggleupinfo_message_body','upinfo_store_id','upinfo_customergroups_send','upinfo_title','upinfo_sender_name','upinfo_sender_email','upinfo_message_subject','upinfo_message_body','upinfo_message_body_plain'];
	  			if(!enabled){
	  				elements.each(function(element){
	  					$(element).disable();
  						$(element).addClassName('disabled');
	  				});
	  			}else{
	  				elements.each(function(element){
	  					$(element).enable();
  						$(element).removeClassName('disabled');
	  				});
  				}
  			},
  			
  	toogleRequire:	function(element, required){
  				var text = '<span class=\"required\"> *</span>';
  				if(required){
  					$(element).addClassName('required-entry');
  					var elem = $$('label[for=\"'+element+'\"]');
  					var inner = elem.first().innerHTML;
  					inner = inner.replace(text,'');
  					elem.first().update(inner + text);
  				}
  				else{
  					$(element).removeClassName('required-entry');
  					var elem = $$('label[for=\"'+element+'\"]');
  					var inner = elem.first().innerHTML;
  					inner = inner.replace(text,'');
  					elem.first().update(inner);
  				}
  			}
}
  			