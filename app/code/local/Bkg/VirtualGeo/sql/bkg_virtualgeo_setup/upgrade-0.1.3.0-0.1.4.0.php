<?php

/* @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getAttribute('catalog_product', 'excludeaffected')) {
	$installer->addAttribute('catalog_product', 'excludeaffected', array(
			'label' => 'Prüfung Betroffenheit - Land ausschließen',
			'input' => 'multiselect',
			'type' => 'varchar',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
			'visible' => true,
			'required' => false,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'source'    =>  'virtualgeo/entity_attribute_source_excludeaffected',
			'backend'    => 'virtualgeo/entity_attribute_backend_excludeaffected',
			//'default' => '1',
			//'option' => $option,
			'group' => 'General',
			'apply_to' => Bkg_VirtualGeo_Model_Product_Type::TYPE_CODE,
	));
}

$tables = array();

$tables[] = 'virtualgeo/components_structure';


foreach ($tables as $table)
{
	if ($installer->tableExists($installer->getTable($table.'_entity'))
			&& !$installer->getConnection()->tableColumnExists($installer->getTable($table.'_entity'), 'show_map'))
	{
		$installer->run("ALTER TABLE {$installer->getTable($table.'_entity')}
		ADD show_map SMALLINT default 0
		");
	}
}


$installer->endSetup();