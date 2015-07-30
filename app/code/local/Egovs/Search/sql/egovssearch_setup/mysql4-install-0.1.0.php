<?php


$installer = $this;

$installer->startSetup();


$installer->addAttribute('catalog_product', 'search_available_in_stock', array(
    'label' => 'Availability',
    'input' => 'multiselect',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => false,
    'required' => false,
    'user_defined' => true,
    'searchable' => true,
    'comparable' => true,
    'visible_on_front' => false,
    'visible_in_advanced_search' => true,
	'used_in_product_listing' => false,
	//'backend_model' =>'egovs_search/entity_backend_available',
	'type' => 'varchar',
	//'frontend_model' => '',
	'used_for_sort_by' => false,
	'source' => 'egovs_search/config_source_available',
	//frontend_input='select'
));


$installer->addAttribute('catalog_product', 'product_category_search', array(
    'label' => 'Category',
    'input' => 'multiselect',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => false,
    'required' => false,
    'user_defined' => true,
    'searchable' => true,
    'comparable' => true,
    'visible_on_front' => false,
    'visible_in_advanced_search' => true,
	'used_in_product_listing' => false,
	//'backend' =>'egovs_search/entity_backend_available',
	'type' => 'varchar',
	//'frontend_model' => '',
	'used_for_sort_by' => false,
	'source' => 'egovs_search/config_source_category',
	//frontend_input='select'
));


$installer->run("
DROP TABLE IF EXISTS {$this->getTable('egovssearch/soundex')};
CREATE TABLE {$this->getTable('egovssearch/soundex')}
(
  `product_id` int(10) unsigned NOT NULL,
  `store_id` smallint(5) unsigned NOT NULL,
  `soundex` varchar(50),	
	FOREIGN KEY (`product_id`) REFERENCES {$this->getTable('catalog_product_entity')}(`entity_id`) ON DELETE CASCADE,
	FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')}(`store_id`) ON DELETE CASCADE,
	INDEX (soundex)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->updateAttribute('catalog_product', 'meta_keyword', 'is_searchable', 1);
$installer->updateAttribute('catalog_product', 'meta_description', 'is_searchable', 1);
$installer->updateAttribute('catalog_product', 'meta_title', 'is_searchable', 1);




$installer->endSetup(); 