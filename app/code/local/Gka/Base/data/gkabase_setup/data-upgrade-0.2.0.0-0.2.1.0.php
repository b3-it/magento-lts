<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();


$data = array();
$data['title']= 'Rechnungstabelle für Terminalzahlung';
$data['ident']= 'content_table';
$data['content']= '</table>';
$data['payment']= 'gka_tkonnektpay_debitcard';
$data['customer_group']= '-1';
$data['shipping']=  'all';
$data['store_id']= '0';
$data['prio']= '0';
$data['pos']= '0';
$data['status']= '1' ;
$data['tax_rule']= 'all';
$this->createBlock($data);

$data = array();
$data['title']= 'Rechnungstabelle für Barzahlung';
$data['ident']= 'content_table';
$data['content']= '	     <tr>
                 <td colspan="3" style="background-color:#DFDFDF; padding-right: 1mm;" align="right"><br><br>Zahlart: {{order.payment_info}}<br>gegebener Betrag: <br></td><td align="right"><br /><br /><br />{{(price)order.payment.given_amount}}<br /></td>
              </tr>
 <!--	     <tr>
                  <td colspan="3" style="background-color:#DFDFDF; padding-right: 1mm;" align="right"><br /><br />Rückgeld<br /></td><td align="right"><br /><br />{{(price)order.payment.given_amount}}-{{(price)grand_total}}<br /></td>
              </tr>-->
 </table>';
$data['payment']= 'epaybl_cashpayment';
$data['customer_group']= '-1';
$data['shipping']=  'all';
$data['store_id']= '0';
$data['prio']= '0';
$data['pos']= '0';
$data['status']= '1' ;
$data['tax_rule']= 'all';
$this->createBlock($data);

$data = array();
$data['title']= 'Breite Terminal';
$data['ident']= 'cell_style';
$data['content']= 'style="width:50mm;"';
$data['payment']= 'gka_tkonnektpay_debitcard';
$data['customer_group']= '-1';
$data['shipping']=  'all';
$data['store_id']= '0';
$data['prio']= '0';
$data['pos']= '0';
$data['status']= '1' ;
$data['tax_rule']= 'all';
$this->createBlock($data);

$data = array();
$data['title']= 'Breite Barkasse';
$data['ident']= 'cell_style';
$data['content']= 'style="width:90mm;"';
$data['payment']= 'epaybl_cashpayment';
$data['customer_group']= '-1';
$data['shipping']=  'all';
$data['store_id']= '0';
$data['prio']= '0';
$data['pos']= '0';
$data['status']= '1' ;
$data['tax_rule']= 'all';
$this->createBlock($data);


/*
const TYPE_HEADER	= 1;
const TYPE_ADDRESS	= 2;
const TYPE_BODY		= 3;
const TYPE_FOOTER	= 4;
const TYPE_MARGINAL	= 5;
*/




$data = array();
$data['general']['title'] = "Rechnung GKA";
$data['general']['type'] = 'invoice';
$data['general']['status'] = Egovs_Pdftemplate_Model_Status::STATUS_ENABLED;

$html = '<table><tr>
 <td width="132mm" align="left" style="font-size:9pt;" >{{imprint.company_first}}<br>{{imprint.street}} | {{imprint.zip}} {{imprint.city}}</td>
 <td width="8mm" ></td>
 <td style="font-size:9pt;">{{imprint.city}}, {{(date)created_at}}</td>
 </tr>
 </table>
 
 <table><tr>
 <td width="180mm" height="15mm"> </td>
 </tr>
 <tr>
 <td width="180mm" align="center"><h1>Quittung</h1> </td>';
$data['header']['top'] = 10;
$data['header']['left'] = 20;
$data['header']['width'] = 210;
$data['header']['height'] = 30;
$data['header']['content'] = $html;

$html = '<pre style="font-size:8pt;">{{order.terminal_customer_receipt}}</pre>';
$data['marginal']['top'] = 80;
$data['marginal']['left'] = 143;
$data['marginal']['width'] = 0;
$data['marginal']['height'] = 0;
$data['marginal']['occurrence'] = 1;
$data['marginal']['content'] = $html;

$html = '<table >
 	<!--<tr><td style="font-size:6pt;">{{imprint.company_first}}<br></td></tr>
 	<tr><td style="font-size:6pt;">{{imprint.street}} | {{imprint.zip}} {{imprint.city}}</td></tr>-->
 	<tr><td> </td><td> </td></tr>
 	<tr><td width="30mm">Einzahler: </td><td>{{billing_address.firstname}} {{billing_address.lastname}}</td></tr>
 	<tr><td> </td><td> </td></tr>
         {{if billing_address.company}}
         <tr><td  width="30mm">abw. Einzahler: </td><td>{{billing_address.company}}</td></tr>
         {{/if}}
 	<!--<tr><td>{{billing_address.street}}</td></tr>
 	<tr><td>{{billing_address.postcode}} {{billing_address.city}}</td></tr>-->
 	</table>
 	';
$data['address']['top'] = 50;
$data['address']['left'] = 20;
$data['address']['width'] = 100;
$data['address']['height'] = 0;
$data['address']['content'] = $html;

$html = '<h2>Kassenzeichen: {{order.payment.kassenzeichen}}</h2>
 	<table border="1" cellpadding="1" style="font-size:8pt;" >
 	<thead>
 		<tr style="background-color:#DFDFDF; ">
    		    <td {{if order.terminal_customer_receipt}}style="width:106mm;" {{else}}style="width:146mm;" {{/if}}>Details</td>
 		</tr>
 	</thead>
 	<tr>
    	      <td {{if order.terminal_customer_receipt}}style="width:106mm;" {{else}}style="width:146mm;" {{/if}}>Vorgangsnummer: {{order.increment_id}} <br>Vorgangsdatum: {{(date)created_at_store_date}} <br>{{order.payment_info}}</td>
 	</tr>
 	</table>
 
 	<table border="1" cellpadding="2" style="font-size:8pt;">
 	<thead>
 		<tr style="background-color:#DFDFDF; ">
 
                     <td {{if order.terminal_customer_receipt}}style="width:50mm;" {{else}}style="width:90mm;" {{/if}}><strong>Gebührenart</strong></td>
                     <td align="center" style="width:11mm;"><strong>Anzahl</strong></td>
 
                     <td align="center" style="width:20mm;"><strong>Gebührensatz</strong><br>(Euro/Cent)</td>
                     <td align="right" style="width:25mm;"><strong>Betrag</strong><br>(Euro/Cent)</td>
                  </tr>
 	</thead>
 
 	{{items}}
              <tr>
 	          <td {{block}}cell_style{{/block}}>{{name}}</td>
                   <td style="width:11mm;" align="center">{{(int)qty}}</td>
 
 	          <td  style="width:20mm;" align="center">{{(price)price}}</td>
 	          <td  style="width:25mm;" align="right">{{(price)order_item.base_row_total}}</td>
              </tr>
          {{items}}
 	     <tr>
                  <td colspan="3" style="background-color:#DFDFDF; padding-right: 1mm;" align="right"><br><br>Gesamtbetrag<br></td><td align="right"><br /><br />{{(price)subtotal}}<br></td>
              </tr>
 {{block}}content_table{{/block}}
 <!--	     <tr>
                 <td colspan="3" style="background-color:#DFDFDF; padding-right: 1mm;" align="right"><br><br>Zahlart: {{order.payment_info}}<br>gezahlt: <br></td><td align="right"><br /><br /><br />{{(price)order.payment.given_amount}}<br /></td>
              </tr>
 	     <tr>
                  <td colspan="3" style="background-color:#DFDFDF; padding-right: 1mm;" align="right"><br /><br />Rückgeld<br /></td><td align="right"><br /><br />{{(price)order.payment.given_amount}}-{{(price)grand_total}}<br /></td>
              </tr> 
 	</table>-->
 <br><br>Sie wurden bedient von {{order.customer_firstname}} {{order.customer_lastname}}
 
 <!--<pre style="border-left: 1mm solid #000000;">{{order.terminal_customer_receipt}}</pre>-->
 ';
$data['body']['top'] = 80;
$data['body']['left'] = 20;
$data['body']['width'] = 0;
$data['body']['height'] = 0;
$data['body']['content'] = $html;

$html = '';
$data['footer']['top'] = 285;
$data['footer']['left'] = 22;
$data['footer']['width'] = 0;
$data['footer']['height'] = 0;
$data['footer']['content'] = $html;

$this->CreateTemplate($data);




$installer->endSetup();