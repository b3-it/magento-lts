$j(document).ready(function(){
    if( $j('#block_content').length ) {
        var code = $j( $j('#block_content').text() );

        $j.each(code.find('img'), function(){
            if ( $j(this).attr('class').indexOf('visible') <= 0 ) {
                $j(this).remove();
            }
        });
        $j('#block_content').text( code.get(2).innerHTML );
    }
});