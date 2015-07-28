<?php

$installer = $this;

$installer->startSetup();

$data = array();
$data['general']['title'] = "SEPA Mandat";
$data['general']['type'] = Egovs_Pdftemplate_Model_Type::TYPE_SEPAMANDAT;
$data['general']['status'] = Egovs_Pdftemplate_Model_Status::STATUS_ENABLED;

$html = '';
$data['header']['top'] = 0;
$data['header']['left'] = 0;
$data['header']['width'] = 0;
$data['header']['height'] = 0;
$data['header']['content'] = $html;

$html = '';
$data['marginal']['top'] = 0;
$data['marginal']['left'] = 0;
$data['marginal']['width'] = 0;
$data['marginal']['height'] = 0;
$data['marginal']['occurrence'] = 1;
$data['marginal']['content'] = $html;

$html = '';
$data['address']['top'] = 0;
$data['address']['left'] = 0;
$data['address']['width'] = 0;
$data['address']['height'] = 0;
$data['address']['content'] = $html;

$html = '<table style="font-size:10pt; border:0.3mm solid #000000;">
    <tr>
        <td style="height:20mm; width:30mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">
            &nbsp;
        </td>
        <td style="height:20mm; width:120mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000; text-align:center;">
            <div style="font-weight:bold;">SEPA-Lastschriftmandat</div>
            <div>{{Reference}}</div>
            <div style="font-size:7pt;">Mandatsreferenznummer</div>
            <div style="height: 5mm; font-size:3pt;">&nbsp;</div>
        </td>
        <td style="height:20mm; width:35mm; border-bottom:0.2mm solid #000000;">
            &nbsp;
        </td>
    </tr>

    <tr>
        <td colspan="3" style="height:17mm; width:185mm; border-bottom:0.2mm solid #000000; font-size:7pt;">Ich
            ermächtige die unten genannte Bundeskasse, Zahlungen von meinem
            Konto mittels Lastschrift einzuziehen. Zugleich weise ich mein
            Kreditinstitut an, die von der Bundeskasse auf mein Konto gezogenen
            Lastschriften einzulösen.<br>Hinweis:
            Ich kann innerhalb von acht Wochen, beginnend mit dem Belastungsdatum,
            die Erstattung des belastenten Betrages verlangen. Es gelten dabei die mit meinem
            Kreditinstitut vereinbarten Bedingungen. Ich bin damit einverstanden, dass zur
            Erleichterung des Zahlungsverkehrs, die grundsätzlich 14-tägige Frist für die
            Information vor Einzug einer fälligen Zahlung bis auf einen Tag vor Belastung
            verkürzt werden kann.
        </td>
    </tr>

    <tr>
        <td colspan="3" style="height:2mm;">&nbsp;</td>
    </tr>

    <tr>
        <td align="left" valign="top" style="height:15mm; width:24mm; font-size:5pt;">Zahlungsempfängerin</td>
        <td align="left" valign="top" style="height:15mm; width:6mm; font-size:5pt;">S07</td>
        <td style="height:15mm; width:156mm;">
            <table style="width:137mm;">
                <tr>
                    <td style="border-bottom:0.2mm solid #000000;">{{imprint.company_first}} {{imprint.company_second}}, {{imprint.street}}, {{imprint.zip}} {{imprint.city}}</td>
                </tr>
            </table>
            <table style="width:137mm;">
                <tr>
                    <td align="center" style="font-size:7pt;">Gläubiger-Identifikationsnummer: {{CreditorId}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:9mm; width:24mm; font-size:5pt;">Zahlungspflichtige/r</td>
        <td align="left" valign="top" style="height:9mm; width:6mm; font-size:5pt;">S14</td>
        <td align="left" valign="top" style="height:9mm; width:156mm;">
            <table style="width:137mm;">
                <tr>
                    <td style="border-bottom:0.2mm solid #000000;">{{DebitorFullname}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:9mm; width:24mm; font-size:5pt;">Anschrift</td>
        <td align="left" valign="top" style="height:9mm; width:6mm; font-size:5pt;">&nbsp;</td>
        <td align="left" valign="top" style="height:9mm; width:156mm;">
            <table style="width:137mm;">
                <tr>
                    <td style="border-bottom:0.2mm solid #000000;">{{DebitorAddress.Street}}, {{DebitorAddress.Zip}} {{DebitorAddress.City}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:12mm; width:24mm; font-size:5pt;" rowspan="2">Zahler/in
            <br>(bitte nur eintragen,<br>wenn Zahlungs-<br>pflichtige/r nicht<br>identisch mit<br>Kontoinhaber/in ist)
        </td>
        <td align="left" valign="top" style="height:12mm; width:6mm; font-size:5pt;">S01</td>
        <td align="left" valign="top" style="height:12mm; width:156mm;">
            <table style="width:150mm; height:4mm; font-size:10pt;" cellspacing="0" cellpadding="1">
                <tr>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000; border-left:0.2mm solid #000000;">{{AccountholderFullname.0}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.1}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.2}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.3}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.4}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.5}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.6}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.7}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.8}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.9}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.10}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.11}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.12}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.13}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.14}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.15}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.16}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.17}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.18}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.19}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.20}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.21}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.22}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.23}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.24}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.25}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.26}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.27}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.28}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.29}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.30}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.31}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.32}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderFullname.33}}</td>
                </tr>
            </table>
            <span style="font-size:7pt;">Vorname und Nachname</span>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:12mm; width:6mm; font-size:5pt;">S02</td>
        <td align="left" valign="top" style="height:12mm; width:156mm;">
            <table style="width:150mm; height:4mm; font-size:10pt;" cellspacing="0" cellpadding="1">
                <tr>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000; border-left:0.2mm solid #000000;">{{AccountholderAddress.Street.0}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.1}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.2}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.3}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.4}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.5}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.6}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.7}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.8}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.9}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.10}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.11}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.12}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.13}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.14}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.15}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.16}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.17}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.18}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.19}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.20}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.21}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.22}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.23}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.24}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.25}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.26}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.27}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.28}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.29}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.30}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.31}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.32}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Street.33}}</td>
                </tr>
            </table>
            <span style="font-size:7pt;">Straße und Hausnummer</span>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:12mm; width:24mm; font-size:5pt;">&nbsp;</td>
        <td align="left" valign="top" style="height:12mm; width:6mm; font-size:5pt;">S03</td>
        <td align="left" valign="top" style="height:12mm; width:156mm;">
            <table style="width:150mm; height:4mm; font-size:10pt;" cellspacing="0" cellpadding="1">
                <tr>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000; border-left:0.2mm solid #000000;">{{AccountholderAddress.Zip.0}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Zip.1}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Zip.2}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Zip.3}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Zip.4}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Zip.5}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Zip.6}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Zip.7}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.Zip.8}}</td>
                    <td style="width:4mm; height:4mm; border-right:0.2mm solid #000000;">&nbsp;</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.0}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.1}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.2}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.3}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.4}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.5}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.6}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.7}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.8}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.9}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.10}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.11}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.12}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.13}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.14}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.15}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.16}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.17}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.18}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.19}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.20}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.21}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.22}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{AccountholderAddress.City.23}}</td>
                </tr>
            </table>
            <span style="font-size:7pt;">Postleitzahl
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp;
                Ort
            </span>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:12mm; width:24mm; font-size:5pt;">&nbsp;</td>
        <td align="left" valign="top" style="height:12mm; width:6mm; font-size:5pt;">S04</td>
        <td align="left" valign="top" style="height:12mm; width:156mm;">
            <table style="width:73mm; height:4mm;">
                <tr>
                    <td style="border-bottom:0.2mm solid #000000;">{{AccountholderAddress.Country}}</td>
                </tr>
            </table>
            <span style="font-size:7pt;">Land</span>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:12mm; width:24mm; font-size:5pt;">Kontoverbindung<br>Zahler/in</td>
        <td align="left" valign="top" style="height:12mm; width:6mm; font-size:5pt;">S05</td>
        <td align="left" valign="top" style="height:12mm; width:156mm;">
            <table style="width:150mm; height:4mm; font-size:10pt;" cellspacing="0" cellpadding="1">
                <tr>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000; border-left:0.2mm solid #000000;">{{BankingAccount.Iban.0}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.1}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.2}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.3}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.4}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.5}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.6}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.7}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.8}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.9}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.10}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.11}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.12}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.13}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.14}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.15}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.16}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.17}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.18}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.19}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.20}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.21}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.22}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.23}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.24}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.25}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.26}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.27}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.28}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.29}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.30}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.31}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.32}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Iban.33}}</td>
                </tr>
            </table>
            <span style="font-size:7pt;">IBAN (International Bank Account Number)</span>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:12mm; width:24mm; font-size:5pt;">&nbsp;</td>
        <td align="left" valign="top" style="height:12mm; width:6mm; font-size:5pt;">S06</td>
        <td align="left" valign="top" style="height:12mm; width:156mm;">
            <table style="width:150mm; height:4mm; font-size:10pt;" cellspacing="0" cellpadding="1">
                <tr>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000; border-left:0.2mm solid #000000;">{{BankingAccount.Bic.0}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.1}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.2}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.3}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.4}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.5}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.6}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.7}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.8}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.9}}</td>
                    <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{BankingAccount.Bic.10}}</td>
                    <td style="width:4mm; height:4mm;">&nbsp;</td>
                    <td style="width:4mm; height:4mm;">&nbsp;</td>
                    <td style="width:84mm; height:4mm; border-bottom:0.2mm solid #000000;">{{BankingAccount.Bankname}}</td>
                </tr>
            </table>
            <span style="font-size:7pt;">BIC (Business Indentifier Code)
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;
                Name der Bank
            </span>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:12mm; width:24mm; font-size:5pt;">&nbsp;</td>
        <td align="left" valign="top" style="height:12mm; width:6mm; font-size:5pt;">S12</td>
        <td align="left" valign="top" style="height:12mm; width:156mm;">
            <table style="width:150mm;" cellspacing="0" cellpadding="1">
                <tr>
                    <td align="center" valign="bottom" style="width:5mm; height:5mm; border:0.2mm solid #000000;">{{if isMultiPayment}}{{else}}X{{/if}}</td>
                    <td style="width:35mm; height:5mm; font-size:7pt;">&nbsp;4 - Einmalige Zahlung (B2C)</td>
                    <td align="center" valign="bottom" style="width:5mm; height:5mm; border:0.2mm solid #000000;">{{if isMultiPayment}}X{{else}}{{/if}}</td>
                    <td style="width:35mm; height:5mm; font-size:7pt;">&nbsp;5 - Mehrmalige Zahlungen (B2C)</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="height:12mm; width:24mm; font-size:5pt;">&nbsp;</td>
        <td align="left" valign="top" style="height:12mm; width:6mm; font-size:5pt;">S13</td>
        <td align="left" valign="top" style="height:12mm; width:156mm;">
            <table style="width:137mm;" cellspacing="0" cellpadding="1"><tr><td style="width:40mm; height:16mm;" valign="bottom">
&nbsp;<br>
<table style="width:40mm;" cellspacing="0" cellpadding="1">
    <tr>
        <td style="border-bottom:0.2mm solid #000000;">{{LocationSigned}}</td>
    </tr>
    <tr>
        <td style="font-size:7pt;">Ort der Unterschrift</td>
    </tr>
</table>
                    </td>
                    <td style="width:5mm; height:16mm;" valign="bottom">&nbsp;</td>
                    <td style="width:37mm; height:16mm;" valign="bottom">
<table style="width:37mm;" cellspacing="0" cellpadding="1">
    <tr>
        <td colspan="8" style="font-size:5pt;">Tag &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Monat &nbsp; &nbsp; &nbsp; Jahr</td>
    </tr>
    <tr>
        <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000; border-left:0.2mm solid #000000;">{{DateSignedAsString.0}}</td>
        <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{DateSignedAsString.1}}</td>
        <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{DateSignedAsString.2}}</td>
        <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{DateSignedAsString.3}}</td>
        <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{DateSignedAsString.4}}</td>
        <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{DateSignedAsString.5}}</td>
        <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{DateSignedAsString.6}}</td>
        <td style="width:4mm; height:4mm; border-bottom:0.2mm solid #000000; border-right:0.2mm solid #000000;">{{DateSignedAsString.7}}</td>
    </tr>
    <tr>
        <td colspan="8" style="font-size:7pt;">Datum der Unterschrift</td>
    </tr>
</table>
                    </td>
                    <td style="width:5mm; height:16mm;" valign="bottom">&nbsp;</td>
                    <td style="width:50mm; height:16mm;" valign="bottom">
&nbsp;<br>
<table style="width:50mm;" cellspacing="0" cellpadding="1">
    <tr>
        <td style="border-bottom:0.2mm solid #000000;">gez.&nbsp;{{if IsCompany}}{{CompanyRepresented}}{{else}}{{if AccountholderDiffers}}{{AccountholderFullname}}{{else}}{{DebitorFullname}}{{/if}}{{/if}}</td>
    </tr>
    <tr>
        <td style="font-size:7pt;">Unterschrift Zahler/in</td>
    </tr>
</table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="height:2mm;">&nbsp;</td>
    </tr>
</table>
<br><br>
<table style="font-size:10pt; border:0.2mm solid #000000; width:194mm;">
    <tr>
        <td align="center" valign="middle" style="width:40mm; border-right:0.2mm solid #000000;">
            <br><br>
            <span style="font-size:5pt;">S16</span>
            &nbsp; &nbsp; &nbsp;
            <span style="font-size:10pt;">{{e_paybl_config.bewirtschafternr}}</span><br>
            <span style="font-size:5pt;">Bewirtschafternummer</span>
        </td>
        <td align="center" valign="top" style="width:80mm; font-size:5pt; border-right:0.2mm solid #000000;"><u>Bitte senden Sie dieses Formular zurück an:</u></td>
        <td align="right" valign="top"><span style="font-size:5pt;">Diese Feld nicht beschriften (nur für interne Zwecke)</span>
            <br><br>
            <span style="font-size:8pt;">Erfassungsdatum:</span> _______________
            <br><br>
            <span style="font-size:8pt;">Erfassung durch:</span> _______________
            <br>
        </td>
    </tr>
</table>';
$data['body']['top'] = 10;
$data['body']['left'] = 16;
$data['body']['width'] = 0;
$data['body']['height'] = 0;
$data['body']['content'] = $html;

$html = '<div style="font-size:9pt;"><strong>032019</strong>   SEPA-Lastschriftmandat für die SEPA-Basislastschrift  <strong>(01/2013)</strong></div>';
$data['footer']['top'] = 283;
$data['footer']['left'] = 17;
$data['footer']['width'] = 190;
$data['footer']['height'] = 10;
$data['footer']['content'] = $html;

$this->CreateTemplate($data);

$installer->endSetup(); 