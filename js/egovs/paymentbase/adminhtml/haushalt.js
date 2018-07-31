/**
 * @category    Egovs
 * @package     Egovs_Paymentbase
 * @copyright   Copyright (c) 2017 B3-IT Systeme GmbH
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

/**
 * Ändert die Aktiv-Option des HH-Elements
 * 
 * @param element
 * @returns
 */
function changeHHType(element)
{
    if( $j(element).attr('name') == 'type' ) {
        var hh_sel = $j(element).val();

        // aus der aktuellen Auswahl den zugehörigen Var-Namen zum Längen-Wert ermitteln
        var name   = 'select' + hh_sel;
        // aus dem dynamischen Var-Namen den betreffenden Wert ermitteln
        var l_neu  = eval( eval(name) );
        // Wert dem Element als max zuweisen
        $j('#value').attr('maxlength', l_neu);

        // Validator-Klasse erzeugen
        var validator_class = 'maximum-length-' + l_neu;
        // Validator-Klasse zuweisen
        $j('#value').removeClass(DefaultValidator).addClass(validator_class);
        // Validator-Klasse speichern
        DefaultValidator = validator_class;

        if ( hh_sel == '2' || hh_sel == '3' ) {
            $j('#hhstelle').prop("disabled", false);
        }
        else {
            $j('#hhstelle').prop("disabled", true);
            $j("#hhstelle > option").removeAttr("selected");
        }
    }
}

/**
 * Dokument fertig geladen; Ändern der HH-Parameter
 * 
 * @returns
 */
$j(document).ready(function(){
    changeHHType('#haushaltsparameter_form select');
});
