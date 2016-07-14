<?php
/**
 * Bfr EventRequest
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('eventrequest/request')))
{

	$installer->run("

	-- DROP TABLE IF EXISTS {$this->getTable('eventrequest/request')};
	CREATE TABLE {$this->getTable('eventrequest/request')} (
	  `eventrequest_request_id` int(11) unsigned NOT NULL auto_increment,
	  `title` varchar(255) NOT NULL default '',
	  `note` text NOT NULL default '',
	  `status` smallint(6) NOT NULL default '0',
	  `customer_id` int(11) unsigned NOT NULL,
	  `quote_id` int(11) unsigned ,
	  `product_id` int(11) unsigned NOT NULL,
	  `created_time` datetime NULL,
	  `update_time` datetime NULL,
	  PRIMARY KEY (`eventrequest_request_id`),
	  FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`quote_id`) REFERENCES `{$this->getTable('sales/quote')}`(`entity_id`) ON DELETE SET NULL,
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->getAttribute('catalog_product', 'eventrequest')) {
	$installer->addAttribute('catalog_product', 'eventrequest', array(
			'label' => 'requires approval',
			'input' => 'select',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => false,
			//'required' => true,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'source'    => 'eav/entity_attribute_source_boolean',
			'default' => '1',
			//'option' => $option,
			'group' => 'General',
			'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
	));
	$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'eventrequest', 'apply_to', Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE);
}

$allEmailData = array();

$emailData = array();
$emailData['template_code'] = "Application accepted (Template)";
$emailData['template_subject'] = "Application accepted";
$emailData['config_data_path'] = "eventrequest/email/eventrequest_accept_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kuendigungsbestaetigung</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$customer.name":"Customer Name",
"store url="customer/account/"":"Customer Account Url",
"var customer.email":"Customer Email",
"var product.name":"Product Name" 
}
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
							<a href="{{store url=""}}"><img src="{{skin url="images/logo_email_dwd.gif" _area="frontend"}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a>
						</td>
					</tr>
				</table>
				<!-- [ middle starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top">
							<p>
							Your Request to {{var product.name}} has been accepted! Visit your  <a href="{{store url="checkout/cart/}}">website</a> again and finalize your application."
							</p>
							<p>
							Ihre Bewerbung für {{var product.name}} wurde akzeptiert! Bitte besuchen Sie unsere <a href="{{store url="checkout/cart/}}">Website</a> ernaut um die Anmeldung abzuschließen."
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