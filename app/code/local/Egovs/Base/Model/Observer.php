<?php
class Egovs_Base_Model_Observer
{
    /**
     * Abkürzungen im HTML-Code mit der Auszeichnung ABBR versehen
     * 
     * @param Varien_Event_Observer $observer
     */
    public function replaceTemplateAbbr( Varien_Event_Observer $observer ) {

        if ( !$observer->hasBlock() ) {
            return;
        }

        /* @var $block Mage_Core_Block_Abstract */
        $transport   = $observer->getTransport();
        $old = $html = $transport->getHtml();
        $fileName    = $observer->getBlock()->getTemplateFile();

        // Da im BE nichts geändert werden soll, ist der Wert dann FALSE
        if ( (strpos($fileName, 'adminhtml') !== false) OR ($fileName == '') ) {
            return;
        }

        $data = array(
                       'inkl.'  => 'inklusive',
                       'Inkl.'  => 'Inklusive',
                       'zzgl.'  => 'zuz&uuml;glich',
                       'Zzgl.'  => 'Zuz&uuml;glich',
                       'MwSt.'  => 'Mehrwertsteuer',
                       'etc.'   => 'und so weiter',
                       'etw.'   => 'etwas',
                       'VIES'   => 'VAT Information Exchange System',
                       'USt.ID' => 'Umsatzsteuer-ID',
                       'BZSt'   => 'Bundeszentralamt f&uuml;r Steuern',
                       'MIAS'   => 'Mehrwertsteuer-Informationsaustauschsystem',
                       //'' => '',

                       // Allgemiene Abkürzungen der Deutschen Bank
                       //'ann.'       => 'annualisiert',
                       //'BaFin'      => 'Bundesanstalt f&uuml;r Finanzdienstleistungsaufsicht',
                       //'BDA'        => 'Bundesvereinigung der Arbeitgeberverb&auml;nde',
                       //'BdB'        => 'Bundesverband deutscher Banken',
                       //'BDI'        => 'Bundesverband der Deutschen Industrie',
                       //'BfA'        => 'Bundesversicherungsanstalt f&uuml;r Angestellte',
                       //'Bill.'      => 'Billionen',
                       //'BIP'        => 'Bruttoinlandsprodukt',
                       //'BIZ'        => 'Bank f&uuml;r Internationalen Zahlungsausgleich',
                       //'BMF'        => 'Bundesministerium der Finanzen',
                       //'BuBa'       => 'Bundesbank',
                       //'DAX'        => 'Deutscher Aktienindex',
                       //'DIW'        => 'Deutsches Institut f&uuml;r Wirtschaftsforschung',
                       //'EBWE'       => 'Europ&auml;ische Bank f&uuml;r Wiederaufbau und Entwicklung',
                       //'EG'         => 'Europ&auml;ische Gemeinschaft',
                       //'EIB'        => 'Europ&auml;ische Investitionsbank',
                       //'EP'         => 'Euro&auml;isches Parlament',
                       //'EStG'       => 'Einkommensteuergesetz',
                       //'EU'         => 'Europ&auml;ische Union',
                       //'EuGH'       => 'Europ&auml;ischer Gerichtshof',
                       //'EuRH'       => 'Europ&auml;ischer Rechnungshof',
                       //'Eurostat'   => 'Europ&auml;isches Amt der EU',
                       //'Euro-STOXX' => 'Europ&auml;ischer Aktienindex',
                       //'EZB'        => 'Europ&auml;ische Zentralbank',
                       //'HGB'        => 'Handelsgesetzbuch',
                       //'HVPI'       => 'Handels- und Verbraucherpreisindex',
                       //'H1'         => '1. Halbjahr',
                       //'H2'         => '2. Halbjahr',
                       //'H3'         => '3. Halbjahr',
                       //'H4'         => '4. Halbjahr',
                       //'Ifo'        => 'Institut f&uuml;r Wirtschaftsforschung',
                       //'IfW'        => 'Institut f&uuml;r Weltwirtschaft',
                       //'IWF'        => 'Internationaler W&auml;hrungsfond',
                       //'nom.'       => 'nominal',
                       //'p.a.'       => 'per annum',
                       //'Q1'         => '1. Quartal',
                       //'Q2'         => '2. Quartal',
                       //'Q3'         => '3. Quartal',
                       //'Q4'         => '4. Quartal',
                       //'WKM'        => 'Wechselkursmechanismus',
                       //'WTO'        => 'Welthandelsorganisation'
                     );

        foreach ( $data AS $key => $val ) {
            $replace = '<abbr title="' . $val . '">' . $key . '</abbr>';
            // nur ersetzen, wenn noch nicht enthalten und Abk. überhaupt enthalten
            if ( !strpos($html, $replace) ) {
                $html = str_replace($key, $replace, $html);
            }
            
            // Fehlerhaftes Ersetzen in DATA-Tags von HTML-Elementen korrigieren
            if ( strpos($html, '="<abbr') ) {
                $html = str_replace('="' . $replace, '="' . $key, $html);
            }
        }
        
        if ( $old != $html ) {
            $transport->setHtml($html);
        }
    }
}