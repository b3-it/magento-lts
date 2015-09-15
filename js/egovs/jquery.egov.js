var eGovMenu = {
    'init': function(element) {
        eGovMenu.getCookie(element);

        $j(element + ' li > a').click(function(e) {
            e.preventDefault();
            if( $j(this).parent().find('ul').length > 0 ) {
                eGovMenu.toggleMenu( $j(this).next() );
            }
            else {
                eGovMenu.openURL( $j(this).attr('href') );
            }

            eGovMenu.getStatus(element);
        });
    },
    'toggleMenu': function(target) {
        target.toggle();
    },
    'openURL': function(url) {
        window.location.href = url;
    },
    'getStatus': function(nav) {
        var res = [];
        $j(nav).find('*').each(function(){
            if ( this.tagName == 'UL' ) {
                res.push( $j(this).attr('id') + ':' + $j(this).css('display') );
            }
        });
        eGovMenu.setCookie(nav, res.join(';'));
    },
    'setCookie': function(elem, val) {
        var toDay = new Date();
        toDay.setTime(toDay.getTime());

        /*This time is for One Day Means 24 hour 1=day 1000=1sec 60*60=1hour 24=no of hour.*/
        var expiress = 1 * 1000 * 60 * 60 * 24;
        var expires_date = new Date(toDay.getTime()+(expiress));

        Mage.Cookies.domain  = window.location.hostname;
        Mage.Cookies.expires = expires_date;
        Mage.Cookies.set(elem + '_catalog_status', val);
    },
    'getCookie': function(elem) {
        var val = Mage.Cookies.get(elem + '_catalog_status');

        if ( val !== null ) {
            var arr = val.split(';');
            var anz = arr.length;

            for ( var i = 0; i < anz; i++ ) {
                var sub = arr[i].split(':');
                $j('#' + sub[0]).css('dsplay', sub[1]);
            }
        }
    }
};