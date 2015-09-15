var eGovMenu = {
    'init': function(element) {
        $j(element + ' li>a').click(function(e) {
            e.preventDefault();
            if( $j(this).parent().find('ul').length > 0 ) {
                eGovMenu.toggleMenu( $j(this).next() );
            }
            else {
                eGovMenu.openURL( $j(this).attr('href') );
            }
        });
    },
    'toggleMenu': function(target) {
        target.toggle();
    },
    'openURL': function(url) {
        window.location.href = url;
    }
};