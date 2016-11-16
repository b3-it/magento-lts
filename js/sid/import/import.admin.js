
function fechData(url) {
	var los = $j("#default_los option:selected").val();
	if(!los){
		alert('Bitte geben Sie das Los an!');
		return;
	}
	url += 'los/' + los;
	setLocation(url);
	
}
  			