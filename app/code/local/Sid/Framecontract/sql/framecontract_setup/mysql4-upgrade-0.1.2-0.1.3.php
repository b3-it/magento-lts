<?php

$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('framecontract_contract')} 
  ADD `contractnumber` varchar(255) NOT NULL default ''
  ");

$installer->endSetup(); 
  
  
  
$text = '
<!--@vars
{"store url=\"\"":"Store Url",
"skin url=\"images/logo_email.gif\" _area=\'frontend\'":"Email Logo Image",
"htmlescape var=$order.getCustomerName()":"Customer Name",
"var store.getFrontendName()":"Store Name",
"store url=\"customer/account/\"":"Customer Account Url",
"var order.increment_id":"Order Id",
"var order.getCreatedAtFormated(\'long\')":"Order Created At (datetime)",
"var order.getBillingAddress().format(\'html\')":"Billing Address",
"var payment_html":"Payment Details",
"var order.getShippingAddress().format(\'html\')":"Shipping Address",
"var order.getShippingDescription()":"Shipping Description",
"layout handle=\"sales_email_order_items\" order=$order":"Order Items Grid",
"var order.getEmailCustomerNote()":"Email Order Note"}
@-->

<!--@styles
	body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }
	a { color:#1E7EC8; }
@-->

<style type="text/css">
        tr.summary-details td {font-size: 10px; color: #626465; }
</style>

<div style="font:11px/1.35em Verdana, Arial, Helvetica, sans-serif;">
	<table cellspacing="0" cellpadding="0" border="0" width="98%" style="margin-top:10px; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; margin-bottom:10px;">
		<tr>
			<td align="center" valign="top">
				<!-- [ header starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top"><a href="{{store url=""}}"><img src="{{skin url="images/logo_email.gif" _area=\'frontend\'}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a></td>
					</tr>
				</table>
				<!-- [ middle starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top">
<h2>Abruf aus Rahmenvertrag</h2> 
{{var contract.title}}  / {{var contract.contractnumber }}
<hr />
							<p>Aus dem Angebot Ihres Rahmenvertrages, {{var contract.contractnumber }} / "{{var contract.title}}"  wurde folgendes abgerufen:<br>
Besteller:  <strong>{{htmlescape var=$order.getCustomerName()}}</strong>,<br/>
Sollten Sie Fragen zu dieser Bestellung haben, senden Sie uns eine E-Mail an <a href="mailto:{{block type="imprint/field" value="email"}}" style="color:#1E7EC8;">{{block type="imprint/field" value="email"}}</a>.</p>
							<p>Nachfolgend finden Sie die Bestelldetails</p>
							
							<h3 style="border-bottom:2px solid #eee; font-size:1.05em; padding-bottom:1px; ">Bestellung Nr. {{var order.increment_id}} <small>({{var order.getCreatedAtFormated(\'long\')}})</small></h3>
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
							    <thead>
							        <tr>
							            <th align="left" width="48.5%" bgcolor="#d9e5ee" style="padding:5px 9px 6px 9px; border:1px solid #bebcb7; border-bottom:none; line-height:1em;">Rechnungsadresse:</th>
							            <th width="3%"></th>
							            <th align="left" width="48.5%" bgcolor="#d9e5ee" style="padding:5px 9px 6px 9px; border:1px solid #bebcb7; border-bottom:none; line-height:1em;">Zahlungsmethode:</th>
							        </tr>
							    </thead>
							    <tbody>
							        <tr>
							            <td valign="top" style="padding:7px 9px 9px 9px; border:1px solid #bebcb7; border-top:0; background:#f8f7f5;">
							                {{var order.getBillingAddress().format(\'html\')}}
							            </td>
							            <td>&nbsp;</td>
							            <td valign="top" style="padding:7px 9px 9px 9px; border:1px solid #bebcb7; border-top:0; background:#f8f7f5;">
							                {{var payment_html}}
							            </td>
							        </tr>
							    </tbody>
							</table>
							
							<br/>
							
							{{depend order.getIsNotVirtual()}}
							
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
							    <thead>
							        <tr>
							            <th align="left" width="48.5%" bgcolor="#d9e5ee" style="padding:5px 9px 6px 9px; border:1px solid #bebcb7; border-bottom:none; line-height:1em;">Versandadresse:</th>
							            <th width="3%"></th>
							            <th align="left" width="48.5%" bgcolor="#d9e5ee" style="padding:5px 9px 6px 9px; border:1px solid #bebcb7; border-bottom:none; line-height:1em;">Versandart:</th>
							        </tr>
							    </thead>
							    <tbody>
							        <tr>
							            <td valign="top" style="padding:7px 9px 9px 9px; border:1px solid #bebcb7; border-top:0; background:#f8f7f5;">
							                {{var order.getShippingAddress().format(\'html\')}}
							            </td>
							            <td>&nbsp;</td>
							            <td valign="top" style="padding:7px 9px 9px 9px; border:1px solid #bebcb7; border-top:0; background:#f8f7f5;">
							                {{var order.getShippingDescription()}}
							            </td>
							        </tr>
							    </tbody>
							</table>
							
							<br/>
							
							{{/depend}}
							
							{{layout handle="sales_email_order_items" order=$order}}
							<br/>							
							{{var order.getEmailCustomerNote()}}
						</td>
					</tr>
					<tr>
						<td>
							{{block type="imprint/content" template="symmetrics/imprint/email/footer.phtml"}}
						</td>
					</tr>
					<tr><td style="border-bottom:2px solid #eee;">&nbsp;</td></tr>
					
				</table>
			</td>
		</tr>
	</table>
</div>
';

$emailData = array();
$emailData['template_code'] = "Bestellung zum Rahmenverträge (Template)";
$emailData['template_subject'] = "Bestellung Rahmenvertrag";
$emailData['config_data_path'] = "framecontract/checkout_email/order_template";
$emailData['template_type'] = "2";
$emailData['text'] = $text;

$this->createEmail($emailData);