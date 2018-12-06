<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();




$fktable = $installer->getTable('pdftemplate/template');
if (!$installer->getConnection()->tableColumnExists($installer->getTable('eventmanager/event'), 'pdftemplate_id')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('eventmanager/event')}
			ADD COLUMN signature_original_filename varchar(255),
			ADD COLUMN signature_filename varchar(255),
			ADD COLUMN signature_title varchar(255),
			ADD COLUMN event_place varchar(255)
			");

}

if (!$installer->tableExists($installer->getTable('eventmanager/event_pdftemplate')))
{
    $installer->run("
			-- DROP TABLE IF EXISTS {$this->getTable('eventmanager/event_pdftemplate')};
			CREATE TABLE {$this->getTable('eventmanager/event_pdftemplate')} (
			`id` int(11) unsigned NOT NULL auto_increment,
			`pdftemplate_id` int(11) unsigned not null,
			`event_id` int(11) unsigned not null,
			`store_id` smallint(6) unsigned not null,
			FOREIGN KEY (pdftemplate_id) REFERENCES {$fktable}(pdftemplate_template_id) ON DELETE CASCADE,
			FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE,
			FOREIGN KEY (`event_id`) REFERENCES `{$this->getTable('eventmanager/event')}`(`event_id`) ON DELETE CASCADE,
			PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

$columnName = 'use4_participation_certificate';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_item'), $columnName)) {
    $installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), $columnName, array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => true,
        'length' => 6,
        'default' => null,
        'comment' => 'use4_participation_certificate'
    ));
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
    $installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => true,
        'length' => 6,
        'default' => null,
        'comment' => 'use4_participation_certificate'
    ));
}

if (!$installer->getAttribute('catalog_product', 'use4_participation_certificate')) {
    $installer->addAttribute('catalog_product', 'use4_participation_certificate', array(
        'label' => 'Used In Participation Certificate',
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
        'default' => '0',
        //'option' => $option,
        'group' => 'General',
        'apply_to' => Mage_Catalog_Model_Product_Type::TYPE_SIMPLE, Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL,
    ));
}

$installer->endSetup();