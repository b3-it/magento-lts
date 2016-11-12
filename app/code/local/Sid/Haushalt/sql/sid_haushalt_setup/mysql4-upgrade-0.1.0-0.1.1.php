<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();


$fields = array('u4_account'=>'Kosten-/Bestandskonto',
				'u4_article'=>'Artikelschlüssel',
				'u4_dim1' =>'Kontierungskategorie1',
				'u4_dim3' =>'Kontierungskategorie3'
		
);


foreach($fields as $field => $label)
{
	if (!$installer->getAttribute('catalog_product', $field)) {
		$installer->addAttribute('catalog_product', $field, array(
				'label' => $label,
				'input' => 'text',
				'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
				'visible' => true,
				'required' => false,
				'is_user_defined' => false,
				'searchable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'visible_in_advanced_search' => false,
				'group' => 'Agresso BW',
		));
	}

}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'u4_increment_id')) {
	$installer->run("ALTER TABLE `{$installer->getTable('sales/order')}`  ADD `u4_increment_id` varchar(255) default '' ");
}


if (!$installer->tableExists($installer->getTable('sidhaushalt/lg04pool')))
{

	$installer->run("

	-- DROP TABLE IF EXISTS {$this->getTable('sidhaushalt/lg04pool')};
			CREATE TABLE {$this->getTable('sidhaushalt/lg04pool')} (
			`haushalt_lg04pool_id` int(11) unsigned NOT NULL auto_increment,
			`lg_04_increment_id` int(11) unsigned NOT NULL default 0 ,
			`created_time` datetime  DEFAULT NOW(),
			PRIMARY KEY (`haushalt_lg04pool_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			");
}



$installer->endSetup();