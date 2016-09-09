/* Session-Preventer and Loding-Layer */
var debug;

function toggle_loading_layer() {
    $j('#loading-mask').fadeIn();
}

$j(document).ready(function(){
    // Loading-Layer beim Klicken auf Link sichtbar machen
    $j('a').click(function(){
        if ( $j(this).attr('id') !== undefined ) {
            debug = $j(this).attr('id').slice(0, 2);
        }
        else {
            debug = '';
        }

        if ( debug != 'dj' && debug != 'eg' ) {
            if ( $j(this).next().size() > 0 ) {
                // Abfrage sichert ungewollte Klicks gegen den Layer ab
                if ( ($j(this).parent().get(0).tagName != 'LI') &&
                     ($j(this).next().get(0).tagName != 'UL') &&
                     ($j(this).next().get(0).id != 'header-cart') &&       // Link des Header-Warenkorb
                     (!$j(this)[0].hasAttribute('data-target-element'))    // Link zum Benutzer-Menü
                   ) {
                    toggle_loading_layer();
                }
            }
            else {
                if ( !$j(this).hasClass('skip-link-close')          // Schließen-Button im Header-Warenkorb
                   ) {
                    toggle_loading_layer();
                }
            }
        }
    });

    // Loading-Layer beim Button auf Link sichtbar machen
    $j('button').click(function(){
        if ( !$j(this).hasClass('btn-cart')
           ) {
            toggle_loading_layer();
        }
    });
});