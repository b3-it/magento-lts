<?php

/* @var $installer Dwd_ConfigurableVirtual_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();


$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'bearbeiter_email', array(
		'type'                    => Varien_Db_Ddl_Table::TYPE_VARCHAR,
		'backend'                 => '',
		'frontend'                => '',
		'label'                   => 'EMail Bearbeiter',
		'input'                   => '',
		'class'                   => '',
		'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'                 => false,
		'required'                => true,
		'user_defined'            => false,
		'default'                 => '0',
		'searchable'              => false,
		'filterable'              => false,
		'comparable'              => false,
		'visible_on_front'        => false,
		'unique'                  => false,
		'apply_to'                => Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL,
		'is_configurable'         => false,
		'used_in_product_listing' => false
));


$emailData = array();
$emailData['template_code'] = "Konfigurierbare Virtuelle Produkte - Bearbeiterinfo (Template)";
$emailData['template_subject'] = "Produkt {{var product_name}} {{var product_sku}} wurde verkauft";
$emailData['config_data_path'] = "configvirtual/email/owner_template";
$emailData['template_type'] = "2";
$emailData['text'] = "Das Produkt {{var product_name}} {{var product_sku}} wurde verkauft.<br/> Die Details zur Bearbeitung finden Sie hier: <a href=\"{{var link}}\">{{var link}}</a>";

if (!$installer->templateExists($emailData['template_code'])) {
	$installer->createEmail($emailData);
}

$installer->endSetup();