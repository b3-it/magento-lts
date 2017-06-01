<?php

$installer = $this;

$installer->startSetup();



	$data = array();
	$data['general']['title'] = "Rechnung";
	$data['general']['type'] = 1; 
	$data['general']['status'] = Egovs_Pdftemplate_Model_Status::STATUS_ENABLED;
	
	$html = '<table><tr>
<td width="132mm" align="right" ><h1>Amt für Angelegenheiten</h1></td>
<td width="8mm" ></td>
<td><img src="{{config.logo}}" alt="logo" width="37mm"  height="22mm" border="0" /></td>
</tr></table>';
	$data['header']['top'] = 10;
	$data['header']['left'] = 20;
	$data['header']['width'] = 210;
	$data['header']['height'] = 30;
	$data['header']['content'] = $html;
	
	$html = '<table >
	<tr><td style="font-weight:bold;font-size:8pt;">Ihr Ansprechpartner</td></tr>
	<tr><td style="font-size:8pt">Frau Müller</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>
	
	<tr><td style="font-weight:bold;font-size:8pt;color:black;">Durchwahl</td></tr>
	<tr><td style="font-size:8pt;">Telefon 0351/123456</td></tr>
	<tr><td style="font-size:8pt;">Fax 0351/123456</td></tr>
	<tr><td style="font-size:8pt;">beratung@amt.de</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>
	
	<tr><td style="font-weight:bold;font-size:8pt;color:black;">Hausanschrift</td></tr>
	<tr><td style="font-size:8pt;">Amt für Angelegenheiten</td></tr>
	<tr><td style="font-size:8pt;">Holzweg 3a</td></tr>
	<tr><td style="font-size:8pt;">12345 Witzhausen</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>
	
	<tr><td style="font-size:8pt;">Witzhausen</td></tr>
	<tr><td style="font-size:8pt;">{{(date)created_at_store_date}}</td></tr>
	</table>
	';
	$data['marginal']['top'] = 50;
	$data['marginal']['left'] = 162;
	$data['marginal']['width'] = 0;
	$data['marginal']['height'] = 0;
	$data['marginal']['occurrence'] = 1;
	$data['marginal']['content'] = $html;
	
	$html = '<table >
	<tr><td style="font-size:6pt;">Amt für Angelegenheiten</td></tr>
	<tr><td style="font-size:6pt;">Holzweg 3a | 12345 Witzhausen</td></tr>
	<tr><td style="font-size:6pt;"></td></tr>
	<tr><td>{{billing_address.firstname}} {{billing_address.lastname}}</td></tr>
	<tr><td>{{billing_address.company}}</td></tr>
	<tr><td>{{billing_address.street}}</td></tr>
	<tr><td>{{billing_address.postcode}} {{billing_address.city}}</td></tr>
	</table>
	';
	$data['address']['top'] = 50;
	$data['address']['left'] = 22;
	$data['address']['width'] = 38;
	$data['address']['height'] = 0;
	$data['address']['content'] = $html;
	
	$html = '<h2>Rechnung</h2><h2>Buchungsnummer: {{order.payment.kassenzeichen}}</h2>
	<table border="1" cellpadding="1" style="font-size:8pt;" >
	<thead>
		<tr style="background-color:#DFDFDF; ">
		<td style="width:87mm;">Versand an</td>
		<td style="width:85mm;">Bestelldetails</td>
		</tr>
	</thead>
	<tr>
	<td style="width:87mm;">{{shipping_address.firstname}} {{shipping_address.lastname}}<br>{{shipping_address.street}}<br>{{shipping_address.postcode}} {{shipping_address.city}}</td>
	<td style="width:85mm;">Kundennummer:{{order.customer_id}} <br>Bestellnummer: {{order.increment_id}} <br>Bestelldatum: {{(date)created_at_store_date}} <br>{{order.payment_info}}</td>
	</tr>
	</table>
	<table border="1" cellpadding="1" style="font-size:8pt;">
	<thead>
		<tr style="background-color:#DFDFDF; "><td style="width:12mm;">Menge</td><td style="width:75mm;">Name</td><td style="width:40mm;">Artikelnummer</td><td style="width:20mm;">Einzelpreis</td><td style="width:25mm;">Gesamt</td></tr>
	</thead>
	{{items}}<tr><td style="width:12mm;" align="center">{{(int)qty}}</td>
	<td style="width:75mm;">{{name}}</td>
	<td style="width:40mm;">{{sku}}</td>
	<td style="width:20mm;" align="right" >{{(price)price}}</td>
	<td style="width:25mm;" align="right">{{(price)base_row_total}}</td></tr>{{items}}
	<tr><td colspan="4" style="border-width:0;">Zwischensumme</td><td align="right">{{(price)subtotal}}</td></tr>
	<tr><td colspan="4">Versand</td><td align="right">{{(price)shipping_amount}}</td></tr>
	<tr><td colspan="4">Mwst</td><td align="right">{{(price)tax_amount}}</td></tr>
	<tr><td colspan="4">Gesamtsumme</td><td align="right">{{(price)grand_total}}</td></tr>
	</table><br><br>Der Rechnungsbetrag ist zu bezahlen.';
	$data['body']['top'] = 110;
	$data['body']['left'] = 22;
	$data['body']['width'] = 0;
	$data['body']['height'] = 0;
	$data['body']['content'] = $html;
	
	$html = '<table >
	<tr><td style="font-weight:bold;font-size:8pt;">Bankverbindung</td><td style="font-size:8pt;">BLZ 850 503 00</td><td style="font-size:8pt;">SWIFT OSDD DE 81</td></tr>
	<tr><td style="font-size:8pt;">Sparkasse Dresden</td><td style="font-size:8pt;">Kto: 321 456 789</td><td style="font-size:8pt;">IBAN DE09 8505 0300 3155 8250 05</td></tr>
	</table>
	';
	$data['footer']['top'] = 285;
	$data['footer']['left'] = 22;
	$data['footer']['width'] = 0;
	$data['footer']['height'] = 0;
	$data['footer']['content'] = $html;
	
	$this->CreateTemplate($data);
	
	
	
	
		$data = array();
	$data['general']['title'] = "Lieferschein";
	$data['general']['type'] = 3;
	$data['general']['status'] = Egovs_Pdftemplate_Model_Status::STATUS_ENABLED;
	
	$html = '<table><tr>
<td width="132mm" align="right" ><h1>Amt für Angelegenheiten</h1></td>
<td width="8mm" ></td>
<td><img src="{{config.logo}}" alt="logo" width="37mm"  height="22mm" border="0" /></td>
</tr></table>';
	$data['header']['top'] = 10;
	$data['header']['left'] = 20;
	$data['header']['width'] = 210;
	$data['header']['height'] = 30;
	$data['header']['content'] = $html;
	
	$html = '<table >
	<tr><td style="font-weight:bold;font-size:8pt;">Ihr Ansprechpartner</td></tr>
	<tr><td style="font-size:8pt">Frau Müller</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>
	
	<tr><td style="font-weight:bold;font-size:8pt;color:black;">Durchwahl</td></tr>
	<tr><td style="font-size:8pt;">Telefon 0351/123456</td></tr>
	<tr><td style="font-size:8pt;">Fax 0351/123456</td></tr>
	<tr><td style="font-size:8pt;">beratung@amt.de</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>
	
	<tr><td style="font-weight:bold;font-size:8pt;color:black;">Hausanschrift</td></tr>
	<tr><td style="font-size:8pt;">Amt für Angelegenheiten</td></tr>
	<tr><td style="font-size:8pt;">Holzweg 3a</td></tr>
	<tr><td style="font-size:8pt;">12345 Witzhausen</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>
	
	<tr><td style="font-size:8pt;">Witzhausen</td></tr>
	<tr><td style="font-size:8pt;">{{(date)created_at_store_date}}</td></tr>
	</table>
	';
	$data['marginal']['top'] = 50;
	$data['marginal']['left'] = 162;
	$data['marginal']['width'] = 0;
	$data['marginal']['height'] = 0;
	$data['marginal']['occurrence'] = 1;
	$data['marginal']['content'] = $html;
	
	$html = '<table >
	<tr><td style="font-size:6pt;">Amt für Angelegenheiten</td></tr>
	<tr><td style="font-size:6pt;">Holzweg 3a | 12345 Witzhausen</td></tr>
	<tr><td style="font-size:6pt;"></td></tr>
	<tr><td>{{shipping_address.firstname}} {{shipping_address.lastname}}</td></tr>
	<tr><td>{{shipping_address.company}}</td></tr>
	<tr><td>{{shipping_address.street}}</td></tr>
	<tr><td>{{shipping_address.postcode}} {{shipping_address.city}}</td></tr>
	</table>
	';
	$data['address']['top'] = 50;
	$data['address']['left'] = 22;
	$data['address']['width'] = 38;
	$data['address']['height'] = 0;
	$data['address']['content'] = $html;
	
	$html = '<h2>Lieferschein</h2><h2>Buchungsnummer: {{order.payment.kassenzeichen}}</h2>
	<table border="1" cellpadding="1" style="font-size:8pt;" >
	<thead>
		<tr style="background-color:#DFDFDF; ">
		<td style="width:87mm;">Versand an</td>
		<td style="width:85mm;">Bestelldetails</td>
		</tr>
	</thead>
	<tr>
	<td style="width:87mm;">{{shipping_address.firstname}} {{shipping_address.lastname}}<br>{{shipping_address.street}}<br>{{shipping_address.postcode}} {{shipping_address.city}}</td>
	<td style="width:85mm;">Kundennummer:{{order.customer_id}} <br>Bestellnummer: {{order.increment_id}} <br>Bestalldatum: {{(date)created_at_store_date}} <br>{{order.payment_info}}</td>
	</tr>
	</table>
	<table border="1" cellpadding="1" style="font-size:8pt;">
	<thead>
		<tr style="background-color:#DFDFDF; "><td style="width:12mm;">Menge</td><td style="width:75mm;">Name</td><td style="width:40mm;">Artikelnummer</td><td style="width:20mm;">Einzelpreis</td><td style="width:25mm;">Gesamt</td></tr>
	</thead>
	{{items}}<tr><td style="width:12mm;" align="center">{{(int)qty}}</td>
	<td style="width:75mm;">{{name}}</td>
	<td style="width:40mm;">{{sku}}</td>
	<td style="width:20mm;" align="right" >{{(price)price}}</td>
	<td style="width:25mm;" align="right">{{(price)base_row_total}}</td></tr>{{items}}
	<tr><td colspan="4" style="border-width:0;">Zwischensumme</td><td align="right">{{(price)subtotal}}</td></tr>
	<tr><td colspan="4">Versand</td><td align="right">{{(price)shipping_amount}}</td></tr>
	<tr><td colspan="4">Mwst</td><td align="right">{{(price)tax_amount}}</td></tr>
	<tr><td colspan="4">Gesamtsumme</td><td align="right">{{(price)grand_total}}</td></tr>
	</table><br><br>Der Rechnungsbetrag ist zu bezahlen.';
	$data['body']['top'] = 110;
	$data['body']['left'] = 22;
	$data['body']['width'] = 0;
	$data['body']['height'] = 0;
	$data['body']['content'] = $html;
	
	$html = '<table >
	<tr><td style="font-weight:bold;font-size:8pt;">Bankverbindung</td><td style="font-size:8pt;">BLZ 850 503 00</td><td style="font-size:8pt;">SWIFT OSDD DE 81</td></tr>
	<tr><td style="font-size:8pt;">Sparkasse Dresden</td><td style="font-size:8pt;">Kto: 321 456 789</td><td style="font-size:8pt;">IBAN DE09 8505 0300 3155 8250 05</td></tr>
	</table>
	';
	$data['footer']['top'] = 285;
	$data['footer']['left'] = 22;
	$data['footer']['width'] = 0;
	$data['footer']['height'] = 0;
	$data['footer']['content'] = $html;
	
	$this->CreateTemplate($data);

	
	$data = array();
	$data['general']['title'] = "Gutschrift";
	$data['general']['type'] = 2;
	$data['general']['status'] = Egovs_Pdftemplate_Model_Status::STATUS_ENABLED;
	
	$html = '<table><tr>
<td width="132mm" align="right" ><h1>Amt für Angelegenheiten</h1></td>
<td width="8mm" ></td>
<td><img src="{{config.logo}}" alt="logo" width="37mm"  height="22mm" border="0" /></td>
</tr></table>';
	$data['header']['top'] = 10;
	$data['header']['left'] = 20;
	$data['header']['width'] = 210;
	$data['header']['height'] = 30;
	$data['header']['content'] = $html;
	
	$html = '<table >
	<tr><td style="font-weight:bold;font-size:8pt;">Ihr Ansprechpartner</td></tr>
	<tr><td style="font-size:8pt">Frau Müller</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>
	
	<tr><td style="font-weight:bold;font-size:8pt;color:black;">Durchwahl</td></tr>
	<tr><td style="font-size:8pt;">Telefon 0351/123456</td></tr>
	<tr><td style="font-size:8pt;">Fax 0351/123456</td></tr>
	<tr><td style="font-size:8pt;">beratung@amt.de</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>
	
	<tr><td style="font-weight:bold;font-size:8pt;color:black;">Hausanschrift</td></tr>
	<tr><td style="font-size:8pt;">Amt für Angelegenheiten</td></tr>
	<tr><td style="font-size:8pt;">Holzweg 3a</td></tr>
	<tr><td style="font-size:8pt;">12345 Witzhausen</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>
	
	<tr><td style="font-size:8pt;">Witzhausen</td></tr>
	<tr><td style="font-size:8pt;">{{(date)created_at_store_date}}</td></tr>
	</table>
	';
	$data['marginal']['top'] = 50;
	$data['marginal']['left'] = 162;
	$data['marginal']['width'] = 0;
	$data['marginal']['height'] = 0;
	$data['marginal']['occurrence'] = 1;
	$data['marginal']['content'] = $html;
	
	$html = '<table >
	<tr><td style="font-size:6pt;">Amt für Angelegenheiten</td></tr>
	<tr><td style="font-size:6pt;">Holzweg 3a | 12345 Witzhausen</td></tr>
	<tr><td style="font-size:6pt;"></td></tr>
	<tr><td>{{billing_address.firstname}} {{billing_address.lastname}}</td></tr>
	<tr><td>{{billing_address.company}}</td></tr>
	<tr><td>{{billing_address.street}}</td></tr>
	<tr><td>{{billing_address.postcode}} {{billing_address.city}}</td></tr>
	</table>
	';
	$data['address']['top'] = 50;
	$data['address']['left'] = 22;
	$data['address']['width'] = 38;
	$data['address']['height'] = 0;
	$data['address']['content'] = $html;
	
	$html = '<h2>Gutschrift</h2><h2>Buchungsnummer: {{order.payment.kassenzeichen}}</h2>
	<table border="1" cellpadding="1" style="font-size:8pt;" >
	<thead>
		<tr style="background-color:#DFDFDF; ">
		<td style="width:87mm;">Versand an</td>
		<td style="width:85mm;">Bestelldetails</td>
		</tr>
	</thead>
	<tr>
	<td style="width:87mm;">{{shipping_address.firstname}} {{shipping_address.lastname}}<br>{{shipping_address.street}}<br>{{shipping_address.postcode}} {{shipping_address.city}}</td>
	<td style="width:85mm;">Kundennummer:{{order.customer_id}} <br>Bestellnummer: {{order.increment_id}} <br>Bestalldatum: {{(date)created_at_store_date}} <br>{{order.payment_info}}</td>
	</tr>
	</table>
	<table border="1" cellpadding="1" style="font-size:8pt;">
	<thead>
		<tr style="background-color:#DFDFDF; "><td style="width:12mm;">Menge</td><td style="width:75mm;">Name</td><td style="width:40mm;">Artikelnummer</td><td style="width:20mm;">Einzelpreis</td><td style="width:25mm;">Gesamt</td></tr>
	</thead>
	{{items}}<tr><td style="width:12mm;" align="center">{{(int)qty}}</td>
	<td style="width:75mm;">{{name}}</td>
	<td style="width:40mm;">{{sku}}</td>
	<td style="width:20mm;" align="right" >{{(price)price}}</td>
	<td style="width:25mm;" align="right">{{(price)base_row_total}}</td></tr>{{items}}
	<tr><td colspan="4" style="border-width:0;">Zwischensumme</td><td align="right">{{(price)subtotal}}</td></tr>
	<tr><td colspan="4">Versand</td><td align="right">{{(price)shipping_amount}}</td></tr>
	<tr><td colspan="4">Mwst</td><td align="right">{{(price)tax_amount}}</td></tr>
	<tr><td colspan="4">Gesamtsumme</td><td align="right">{{(price)grand_total}}</td></tr>
	</table><br><br>Der Rechnungsbetrag ist zu bezahlen.';
	$data['body']['top'] = 110;
	$data['body']['left'] = 22;
	$data['body']['width'] = 0;
	$data['body']['height'] = 0;
	$data['body']['content'] = $html;
	
	$html = '<table >
	<tr><td style="font-weight:bold;font-size:8pt;">Bankverbindung</td><td style="font-size:8pt;">BLZ 850 503 00</td><td style="font-size:8pt;">SWIFT OSDD DE 81</td></tr>
	<tr><td style="font-size:8pt;">Sparkasse Dresden</td><td style="font-size:8pt;">Kto: 321 456 789</td><td style="font-size:8pt;">IBAN DE09 8505 0300 3155 8250 05</td></tr>
	</table>
	';
	$data['footer']['top'] = 285;
	$data['footer']['left'] = 22;
	$data['footer']['width'] = 0;
	$data['footer']['height'] = 0;
	$data['footer']['content'] = $html;
	
	$this->CreateTemplate($data);

$installer->endSetup(); 