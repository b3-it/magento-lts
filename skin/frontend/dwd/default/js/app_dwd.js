// Allgemeine JS-Funktionen
$j(document).ready(function(){
	if ( $j('body').hasClass('cms-index-index') ) {
		$j('#welcome-msg').html( $j('#welcome-hidden').html() );
	}
});