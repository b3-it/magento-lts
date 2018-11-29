<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();




$fktable = $installer->getTable('pdftemplate/template');
if (!$installer->getConnection()->tableColumnExists($installer->getTable('eventmanager/event'), 'pdftemplate_id')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('eventmanager/event')}
			ADD COLUMN pdftemplate_id int(11) unsigned default null,
			ADD COLUMN signature_original_filename varchar(255),
			ADD COLUMN signature_filename varchar(255),
			ADD COLUMN signature_title varchar(255),
			ADD CONSTRAINT fk_pdftemplate_id FOREIGN KEY (pdftemplate_id) REFERENCES {$fktable}(pdftemplate_template_id) ON DELETE SET NULL
			");

}



if (!$installer->getAttribute('catalog_product', 'use_participation_certificate')) {
    $installer->addAttribute('catalog_product', 'use_participation_certificate', array(
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
        'source'    => 'eventmanager/role',
        'default' => '1',
        //'option' => $option,
        'group' => 'General',
        'apply_to' => Mage_Catalog_Model_Product_Type::TYPE_SIMPLE, Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL,
    ));
}

$installer->endSetup();