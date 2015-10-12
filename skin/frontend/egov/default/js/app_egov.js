$j(document).ready(function () {
    // On viewports smaller than 1000px

    if ($j('.page-header-container').length > 0) {
        enquire.register('screen and (max-width: 785px)', {
            match: function() {
                // Welcome-Header eine Ebene nach oben schieben
                $j('.welcome-header').appendTo( $j('.page-header-container') );

                // Shop-Navigation in Mobil-Container schieben
                $j('.nav-primary').appendTo( $j('#header-nav') );
            },
            unmatch: function() {
                // Welcome-Header zurück zu den Skip-Links (Ursprung)
                $j('.welcome-header').appendTo( $j('.skip-links') );

                // Shop-Navigation zurück an Ursprung
                $j('.nav-primary').appendTo( $j('#egov-nav') );
            }
        });
    }

});