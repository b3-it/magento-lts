$j(document).ready(function(){
    // Loading-Layer beim Klicken auf Link sichtbar machen
    $j('a').click(function(){
        if ( $j(this).attr('id') !== undefined ) {
            var debug = $j(this).attr('id').slice(0, 2);
        }
        else {
            var debug = '';
        }

        if ( debug != 'dj' && debug != 'eg' ) {
            if ( $j(this).next().size() > 0 ) {
                // Abfrage sichert ungewollte Klicks gegen den Layer ab
                if ( ($j(this).parent().get(0).tagName != 'LI') &&
                     ($j(this).next().get(0).tagName != 'UL') &&
                     ($j(this).next().get(0).id != 'header-cart') &&       // Link des Header-Warenkorb
                     (!$j(this)[0].hasAttribute('data-target-element'))    // Link zum Benutzer-Menü
                   ) {
                    $j('#loading-mask').toggle();
                }
            }
            else {
                if ( !$j(this).hasClass('skip-link-close')          // Schließen-Button im Header-Warenkorb
                   ) {
                    $j('#loading-mask').toggle();
                }
            }
        }
    });

    // Loading-Layer beim Button auf Link sichtbar machen
    $j('button').click(function(){
        if ( !$j(this).hasClass('btn-cart')
           ) {
            $j('#loading-mask').toggle();
        }
    });
});