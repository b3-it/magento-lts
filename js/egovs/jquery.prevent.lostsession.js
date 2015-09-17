$j(document).ready(function(){
    // Loading-Layer beim Klicken auf Link sichtbar machen
    $j('a').click(function(){
        if ( $j(this).next().size() > 0 ) {
            // Abfrage sichert die Klick-Navigation(en) gegen den Layer ab
            if ( ($j(this).parent().get(0).tagName != 'LI') &&
                 ($j(this).next().get(0).tagName != 'UL') &&
                 ($j(this).next().get(0).id != 'header-cart') &&     // Link des Header-Warenkorb
                 (!$j(this)[0].hasAttribute('data-target-element'))  // Link zum Benutzer-Menü
               ) {
                $j('#loading-mask').toggle();
            }
        }
        else {
            if ( !$j(this).hasClass('skip-link-close') ) {     // Schließen-Button im Header-Warenkorb
                $j('#loading-mask').toggle();
            }
        }
    });

    // Loading-Layer beim Button auf Link sichtbar machen
    $j('button').click(function(){
        $j('#loading-mask').toggle();
    });
});