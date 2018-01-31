<?php
/**
  *
  * @category   	Bkg Orgunit
  * @package    	Bkg_Orgunit
  * @name       	Bkg_Orgunit Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bkg_orgunit/unit')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_orgunit/unit')};
	CREATE TABLE {$installer->getTable('bkg_orgunit/unit')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
        `shortname` varchar(255) default '',
        `name` varchar(255) default '',
        `line` varchar(255) default '',
        `note` varchar(128) default '',
        `parent_id` int(11) unsigned default null,
    
	  PRIMARY KEY (`id`),
     FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('bkg_orgunit/unit')}`(`id`) ON DELETE SET NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

$installer->addEntityType('bkg_orgunit', array(
    'entity_model'    => 'bkg_orgunit/unit_address',
    'table'           =>'bkg_orgunit/unit_address_entity',
));

if (!$installer->tableExists($installer->getTable('bkg_orgunit/unit_address_entity')))
{
    $installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_orgunit/unit_address_entity')};
	CREATE TABLE {$installer->getTable('bkg_orgunit/unit_address_entity')} (
	  `entity_id` int(11) unsigned NOT NULL auto_increment,
	  `unit_id` int(11) unsigned NOT NULL,
      `name` varchar(255) default '',
    
	  PRIMARY KEY (`entity_id`),
	  FOREIGN KEY (`unit_id`) REFERENCES `{$this->getTable('bkg_orgunit/unit')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}




if (!$installer->tableExists($installer->getTable('bkg_orgunit/unit_address_entity_varchar'))) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('bkg_orgunit/unit_address_entity_varchar'))
        ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Value Id')
        ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0',
        ), 'Entity Type Id')
        ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0',
        ), 'Attribute Id')
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0',
        ), 'Entity Id')
        ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Value')
        ->addIndex(
            $installer->getIdxName(
                'bkg_orgunit_unit_address_entity_varchar',
                array('entity_id', 'attribute_id'),
                Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
            ),
            array('entity_id', 'attribute_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
        ->addIndex($installer->getIdxName('bkg_orgunit_unit_address_entity_varchar', array('entity_type_id')),
            array('entity_type_id'))
        ->addIndex($installer->getIdxName('bkg_orgunit_unit_address_entity_varchar', array('attribute_id')),
            array('attribute_id'))
        ->addIndex($installer->getIdxName('bkg_orgunit_unit_address_entity_varchar', array('entity_id')),
            array('entity_id'))
        ->addIndex($installer->getIdxName('bkg_orgunit_unit_address_entity_varchar', array('entity_id', 'attribute_id', 'value')),
            array('entity_id', 'attribute_id', 'value'))
        ->addForeignKey(
            $installer->getFkName('bkg_orgunit_unit_address_entity_varchar', 'attribute_id', 'eav/attribute', 'attribute_id'),
            'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey(
            $installer->getFkName('bkg_orgunit_unit_address_entity_varchar', 'entity_id', 'bkg_orgunit/unit_address_entity_varchar', 'entity_id'),
            'entity_id', $installer->getTable('bkg_orgunit/unit_address_entity'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey(
            $installer->getFkName('bkg_orgunit_unit_address_entity_varchar', 'entity_type_id', 'eav/entity_type', 'entity_type_id'),
            'entity_type_id', $installer->getTable('eav/entity_type'), 'entity_type_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('bkg_orgunit_unit_entity_varchar');
    $installer->getConnection()->createTable($table);

}

 if (!$installer->getAttribute('customer', 'org_unit'))
 {
  $installer->addAttribute('customer', 'org_unit', array(
		'label' => 'Organisation',
		'input' => 'select',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
        'source'    => 'eav/entity_attribute_source_boolean',
    ));
}

$store = 0;

$addressHelper = Mage::helper('customer/address');
// update customer address system attributes data
$attributes = array(
    'prefix'            => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 0,
        'is_visible'        => $addressHelper->getConfig('prefix_show', $store) == '' ? 0 : 1,
        'sort_order'        => 10,
        'is_required'       => $addressHelper->getConfig('prefix_show', $store) == 'req' ? 1 : 0,
    ),
    'firstname'         => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 20,
        'is_required'       => 1,
        'validate_rules'    => array(
            'max_text_length'   => 255,
            'min_text_length'   => 1
        ),
    ),
    'middlename'        => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 0,
        'is_visible'        => $addressHelper->getConfig('middlename_show', $store) == '' ? 0 : 1,
        'sort_order'        => 30,
        'is_required'       => $addressHelper->getConfig('middlename_show', $store) == 'req' ? 1 : 0,
    ),
    'lastname'          => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 40,
        'is_required'       => 1,
        'validate_rules'    => array(
            'max_text_length'   => 255,
            'min_text_length'   => 1
        ),
    ),
    'suffix'            => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 0,
        'is_visible'        => $addressHelper->getConfig('suffix_show', $store) == '' ? 0 : 1,
        'sort_order'        => 50,
        'is_required'       => $addressHelper->getConfig('suffix_show', $store) == 'req' ? 1 : 0,
    ),
    'company'           => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 60,
        'is_required'       => 0,
        'validate_rules'    => array(
            'max_text_length'   => 255,
            'min_text_length'   => 1
        ),
    ),
    'street'           => array(
        'backend_type'      => 'text',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 70,
        'multiline_count'   => $addressHelper->getConfig('street_lines', $store),
        'is_required'       => 1,
        'validate_rules'    => array(
            'max_text_length'   => 255,
            'min_text_length'   => 1
        ),
    ),
    'city'              => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 80,
        'is_required'       => 1,
        'validate_rules'    => array(
            'max_text_length'   => 255,
            'min_text_length'   => 1
        ),
    ),
    'country_id'        => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 90,
        'is_required'       => 1,
    ),
    /*
    'region'            => array(
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 100,
        'is_required'       => 0,
    ),
    'region_id'         => array(
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 100,
        'is_required'       => 0,
    ),*/
    'postcode'          => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 110,
        'is_required'       => 1,
        'validate_rules'    => array(
        ),
    ),
    'telephone'         => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 120,
        'is_required'       => 1,
        'validate_rules'    => array(
            'max_text_length'   => 255,
            'min_text_length'   => 1
        ),
    ),
    'fax'               => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 130,
        'is_required'       => 0,
        'validate_rules'    => array(
            'max_text_length'   => 255,
            'min_text_length'   => 1
        ),
    ),
    'email'               => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 130,
        'is_required'       => 0,
        'validate_rules'    => array(
            'max_text_length'   => 255,
            'min_text_length'   => 1
        ),
    ),
    'web'               => array(
        'backend_type'      => 'varchar',
        'is_user_defined'   => 0,
        'is_system'         => 1,
        'is_visible'        => 1,
        'sort_order'        => 130,
        'is_required'       => 0,
        'validate_rules'    => array(
            'max_text_length'   => 255,
            'min_text_length'   => 1
        ),
    ),
);
$eavConfig = Mage::getSingleton('eav/config');
foreach ($attributes as $attributeCode => $data) {
    $attribute = $eavConfig->getAttribute('bkg_orgunit', $attributeCode);
       $attribute->addData($data);

    $attribute->save();
}

$installer->endSetup();
