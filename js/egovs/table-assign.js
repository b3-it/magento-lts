function assignTable(tableId,name)
{
	this.tableId = tableId;
	this.name = name;
	this.nextID  = 0;
	this.inputtype = 'hidden';

	this.deleteRow = function(rowId) {
		var thisId = parseInt(rowId);

		if ( isNaN(thisId) || thisId <= 0 ) {
			return;
		}

		$j('#delete-' + this.tableId + '-' + thisId).val('1');
		$j('#row-'    + this.tableId + '-' + thisId).toggle();
	}

	this.appendRow = function(data){

		if(!data){
			var data = new Object();
		}

		if(!data.left_value){
			data.left_value = $j('#left-assign-'+this.tableId).find('option:selected').val();
		}

		if(!data.right_value){
			data.right_value = $j('#right-assign-'+this.tableId).find('option:selected').val();
		}

		if(!data.left_text){
			data.left_text = $j('#left-assign-'+this.tableId + ' option[value="'+data.left_value+'"]').text();
		}

		if(!data.right_text){
			data.right_text = $j('#right-assign-'+this.tableId + ' option[value="'+data.right_value+'"]').text();
		}

		if((!data.left_value) || (!data.right_value)){
			return;
		}

		this.nextID +=1;

	    var cellLeft = $j('<td />', {
	        'text': data.left_text
	    });
	    var cellRight = $j('<td />', {
	        'text': data.right_text
	    });

	    var inputLeft = $j('<input />', {
	        'id'   : 'left_value-' + this.tableId + '-' + this.nextID,
	        'name' : this.name +  '['+ this.nextID +'][left_value]',
	        'value': data.left_value,
	        'type' : this.inputtype
	    });
	    var inputRigth = $j('<input />', {
	        'id'   : 'right_value-' + this.tableId + '-' + this.nextID,
	        'name' : this.name +  '['+ this.nextID +'][right_value]',
	        'value': data.right_value,
	        'type' : this.inputtype
	    });
	    var inputDelete = $j('<input />', {
	        'id'   : 'delete-' + this.tableId + '-' + this.nextID,
	        'name' : this.name + '['+ this.nextID +'][delete]',
	        'value': 0,
	        'type' : this.inputtype
	    });
	    var inputId = $j('<input />', {
	        'id'   : 'db_id-' + this.tableId + '-' + this.nextID,
	        'name' : this.name + '['+ this.nextID +'][db_id]',
	        'value': data.db_id,
	        'type' : this.inputtype
	    });
	    cellRight.append(inputLeft).append(inputRigth).append(inputDelete).append(inputId);

		var cellDelete = $j('<button />', {
	        'class':'scalable delete add-widget position-delete',
	        'type' : 'button',
	        'onclick' : 'assign_'+ this.tableId +'.deleteRow('+ this.nextID +')'
	    });
	    cellDelete.append($j('<span />'));

	    var cellFunction = $j('<td />', {
	        'class': 'position-sorting'
	    });
		cellFunction.append(cellDelete);

	    var newRow = $j('<tr />', {
	        'id'        : 'row-' + this.tableId + '-' + this.nextID,
	        'data-id'   : this.nextID,
	        'data-table': this.tableId
	    });
	    newRow.append(cellLeft).append(cellRight).append(cellFunction);

	    $j('#table-' + this.tableId + ' tbody').append(newRow);
	}
}
