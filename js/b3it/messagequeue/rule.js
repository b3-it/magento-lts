Rule = function() {
	
	this.compareinputlist = "";
	
	this.setCompareInputList = function(list)
	{
		this.compareinputlist = list;
	}
	
	this.switchCompare = function(){
		var select = $j( "#rule_compare option:selected" ).val();
		var input = this.compareinputlist[select];
		
		$j('#compare_input').html(input);
		
		
	}
	
	this.getRule = function(){
		var res = {};
		res.compare_text = $j( "#rule_compare option:selected" ).text();
		res.compare = $j( "#rule_compare option:selected" ).val();
		
		var compare = res.compare = $j( "#rule_compare option:selected" ).val();
		res.compare_value = $j( "#compare-value-"+compare).val();
		res.compare_value_text = $j( "#compare-value-"+compare + " :selected").text();
		
		
		res.join_text = $j( "#compare_join_operator option:selected" ).text();
		res.join = $j( "#compare_join_operator option:selected" ).val();
		res.compare_source = $j( "#compare_source" ).val();
		res.compare_source_text = $j( "#compare_source" ).val();
		
		res.not_text = $j("#compare_is_not:checked").val()?"not": "";
		res.not = $j("#compare_is_not:checked").val()?"1": "0";
		
		res.compare_operator_text = $j( "#compare_operator option:selected" ).text();
		res.compare_operator = $j( "#compare_operator option:selected" ).val();
		
		return res;
	}
}


RuleSet = function(elementId,name) {
       
        this.elementId = elementId;
        this.inputName = name;
        var instance = this;
        this.my_id = 0;
        
        
        this.processTemplate = function(template,data)
        {
        	$j.each(data, function(key,value){
        		template = template.replace(new RegExp("{{"+key+"}}", 'g'), value);
        	});
        	
        	return template;
        }
        

        this.removeRow = function(_id)
        {
        	var row = $j('#row-'+this.elementId+'-'+_id);
            $j('#deleted-'+this.elementId+'-'+_id).val(1);
            row.hide();
        }
        
        
        this.addRow = function(data)
        {
        	data.id = "";
        	data.ruleset_id = 0;
        	this.appendRow(data);
        }
        
        this.appendRow = function(data) {
        	this.my_id++;
            data.elementId = this.elementId;
            data.my_id = this.my_id;
            data.inputname = this.inputName;
          
            //damits plausibler aussieht
           if(this.my_id == 1){
        	   data.join_text = "";
           }
           
           var newTableRow = this.processTemplate(this.getTemplate(),data);

           $j('#table-'+this.elementId+'_grid tbody').append(newTableRow);
            //this.setPosition();
            //this.toogleUpDownButtons();
        }

        this.getTemplate = function() {
            return $j("#"+this.elementId+"_template").html();
        }

       
}



