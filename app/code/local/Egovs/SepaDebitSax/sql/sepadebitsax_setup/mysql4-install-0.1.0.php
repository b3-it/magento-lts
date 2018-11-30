<?php
/** @var $this Egovs_Paymentbase_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$entityTypeId = 'order_payment';

$attributes = array(Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_ESHOP_TRANSACTION_ID, 
		Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_SEPA_MATURITY,
		
);

foreach ($attributes as $attributeId)
{
	if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
		if (!$installer->getAttribute($entityTypeId, $attributeId)) {
			$installer->addAttribute($entityTypeId, $attributeId, array(
					'label' => 'EShop Transaction ID',
					'input' => 'text',
					'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
					'visible' => true,
					'required' => false,
					'user_defined' => false,
					'searchable' => false,
					'comparable' => false,
					'visible_on_front' => false,
					'visible_in_advanced_search' => false,
					'default' => '0',
			)
			);
		}
	} else {
		if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
	
			//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
			$installer->getConnection()->addColumn(
					$installer->getTable('sales/order_payment'),
					$attributeId,
					'varchar(255)'
			);
		}
	}
}




$emailData = array();
$emailData['template_code'] = "Sepa Saxmandate (Template)";
$emailData['template_subject'] = "Ihr SEPA Mandat";
$emailData['config_data_path'] = "payment/sepadebitsax/mandate_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SEPA Mandat</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$customer.name":"Customer Name"
"}
@-->

<!--@styles
	body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }
	a { color:#1E7EC8; }
@-->

<div style="font:11px/1.35em Verdana, Arial, Helvetica, sans-serif;">
	<table cellspacing="0" cellpadding="0" border="0" width="98%" style="margin-top:10px; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; margin-bottom:10px;">
		<tr>
			<td align="center" valign="top">
				<!-- [ header starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top">
							<a href="{{store url=""}}"><img src="{{skin url="images/logo_email.gif" _area="frontend"}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a>
						</td>
					</tr>
				</table>
				<!-- [ middle starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top">
							<p>
Sehr geehrte Kundin, <br/>
Sehr geehrter Kunde, <br/>
 <br/>
aufgrund Ihrer erteilten Zustimmung zum Lastschriftverfahren im {{config path="general/store_information/name"}}, erhalten Sie im Anhang zu dieser E-Mail das nötige SEPA-Mandat.
 <br/>
 
<strong>
Erst wenn Ihr unterschriebenes Originalmandat vorliegt, kann Ihre Bestellung weiter bearbeitet werden.
 <br/>
{{block type="egovsbase/email_config" path="payment/sepadebitsax/adr_mandatsverwaltung" }}
</strong>
 <br/>
Vielen Dank
 <br/>
Ihr {{config path="general/store_information/name"}}
							</p>
							
		        </td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
</body>
</html>

';

$allEmailData[] = $emailData;


$emailData = array();
$emailData['template_code'] = "Sepa Saxmandate Notification (Template)";
$emailData['template_subject'] = "Ihre SEPA Lastschrift";
$emailData['config_data_path'] = "payment/sepadebitsax/notification_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SEPA Mandat Lastschrift</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$customer.name":"Customer Name"
"}
@-->

<!--@styles
	body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }
	a { color:#1E7EC8; }
@-->

<div style="font:11px/1.35em Verdana, Arial, Helvetica, sans-serif;">
	<table cellspacing="0" cellpadding="0" border="0" width="98%" style="margin-top:10px; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; margin-bottom:10px;">
		<tr>
			<td align="center" valign="top">
				<!-- [ header starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top">
							<a href="{{store url=""}}"><img src="{{skin url="images/logo_email.gif" _area="frontend"}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a>
						</td>
					</tr>
				</table>
				<!-- [ middle starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top">
							<p>

Sehr geehrte Kundin, <br/>
Sehr geehrter Kunde, <br/>
 <br/>
bezugnehmend auf Ihren Einkauf mit der Bestellnummer  {{var order.increment_id}} informieren wir Sie über den Lastschrift-Einzugstermin.

 

Die Forderung von  {{var betrag}}  ziehen wir mit der SEPA-Lastschrift zum Mandat {{var mandate_reference}} zu der 
		Gläubiger-Identifikationsnummer  {{var glaeubiger_id}} von Ihrem Konto IBAN  {{var iban}} und BIC  {{var bic}} zum {{var faellig}} ein. 
		<br/>
		Fällt der Fälligkeitstag auf einen Feiertag oder ein Wochenende, verschiebt sich der Fälligkeitstag auf den nächsten Werktag. Um einen reibungslosen Ablauf zu unterstützen, bitten wir Sie, für Kontodeckung zu sorgen. 
Bei Rückfragen zu Ihrem Einkauf wenden Sie sich bitte an folgende Adresse {{config path="trans_email/ident_general/email"}}. 
<br/>
		Bitte beachten Sie den Anhang!
		 <br/>
Vielen Dank
 <br/>
Ihr {{config path="general/store_information/name"}}
							</p>
	
		        </td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
</body>
</html>
';

$allEmailData[] = $emailData;






foreach ($allEmailData as $emailData){
	$model = Mage::getModel('core/email_template');
	$template = $model->setTemplateSubject($emailData['template_subject'])
	->setTemplateCode($emailData['template_code'])
	->setTemplateText($emailData['text'])
	->setTemplateType($emailData['template_type'])
	->setModifiedAt(Mage::getSingleton('core/date')->gmtDate())
	->save()
	;

	$this->setConfigData($emailData['config_data_path'], $template->getId());
}




$installer->endSetup();