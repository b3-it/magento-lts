// Mapseries currently use tools[0] hardcoded

// Testing API
function getAvailableTiles() {
	return tools[0].getSource().getFeatures().filter(function(f) {
		j = $j('#qty-' + f.get('sku'));
		return j.length > 0;
	});
}

function getSelectedTiles() {
	return tools[0].getSource().getFeatures().filter(function(f) {
		j = $j('#qty-' + f.get('sku'));
		return j.length > 0 && j.val() > 0;
	});
}

function selectTiles(ids) {
	ids.each(function(sku) {
		_selectTile(sku, 1);
	});
}

function removeTiles(ids) {
	ids.each(function(sku) {
		_selectTile(sku, -1);
	});
}

// currently only one Tool layer is allowed, and it is the same that does select
// on the tiles

function getAvailableTools() {
	return tools;
}

function getFeaturesByTool(toolLayer) {
	return toolLayer.getSource().getFeatures();
}

/**
 * currently ignores layer and just use sku of the features
 */
function selectWithTool(toolLayer, features) {
	features.each(function(f) {
		_selectTile(f.get('sku'), 1);
	});
}
function removeWithTool(toolLayer, features) {
	features.each(function(f) {
		_selectTile(f.get('sku'), -1);
	});
}

function incLoading() {
	$j('#map').LoadingOverlay("show");
}

function decLoading() {
	$j('#map').LoadingOverlay("hide");
}

// Common part for testing and real code
function _selectTile(sku, val) {
	qty = $j('#qty-' + sku);
	// updates the value with +/- value
	qty.val(function(i, oldval) {
		return parseInt(oldval, 10) + val;
	});
	// call changed so the map get updated
	qty.change();
}


function dialogFunction(list) {
	str = "<table title='Füge hinzu?'>";
	list.forEach(function(f) {
		var sku = f.get('sku');
		var price = $j("#price-" + sku + " .price").text();
		var name = $j("#name-" + sku).text();
		str += "<tr>";

		str += "<td><label><input id='confirm-chk-" + sku
				+ "' type='checkbox' checked='checked' name='ids' value='"
				+ sku + "' />" + name + "</td>";
		str += "<td>" + price + "</td>";
		str += "<td><input id='confirm-qty-" + sku
				+ "' type='number' value='1' min='0' /></td>";

		str += "</tr>";
	});
	str += "</table>";
	$j(str).dialog({
		resizable : false,
		height : "auto",
		width : 400,
		modal : true,
		buttons : {
			Confirm : function() {
				$j(this).find(":checked").each(function(index) {
					sku = $j(this).val();

					v = $j('#confirm-qty-' + sku).val();
					_selectTile(sku, parseInt(v, 10));
				});

				// need to destroy so it is removed from code
				$j(this).dialog("destroy").remove();
			},
			Cancel : function() {
				// need to destroy so it is removed from code
				$j(this).dialog("destroy").remove();
			}
		}
	});
};