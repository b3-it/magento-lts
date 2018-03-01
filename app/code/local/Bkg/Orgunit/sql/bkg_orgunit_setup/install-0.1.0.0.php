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

/** @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$unit = $installer->getTable('bkg_orgunit/unit');
$unit_address = $installer->getTable('bkg_orgunit/unit_address_entity');
if (!$installer->tableExists($unit))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$unit};
	CREATE TABLE {$unit} (
	  `id` int(11) unsigned NOT NULL auto_increment,
        `shortname` varchar(255) default '',
        `name` varchar(255) default '',
        `line` varchar(255) default '',
        `note` varchar(128) default '',
        `parent_id` int(11) unsigned default null,
    
	  PRIMARY KEY (`id`),
     FOREIGN KEY (`parent_id`) REFERENCES `{$unit}`(`id`) ON DELETE SET NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
}

$org_eav_attribute = $installer->getTable('bkg_orgunit/eav_attribute');

if (!$installer->tableExists($org_eav_attribute)) {
    $installer->run("CREATE TABLE {$org_eav_attribute} (
        `attribute_id` smallint(5) unsigned NOT NULL COMMENT 'Attribute Id',
        `is_visible` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Is Visible',
        `input_filter` varchar(255) DEFAULT NULL COMMENT 'Input Filter',
        `multiline_count` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Multiline Count',
        `validate_rules` text COMMENT 'Validate Rules',
        `is_system` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is System',
        `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sort Order',
        `data_model` varchar(255) DEFAULT NULL COMMENT 'Data Model',
        PRIMARY KEY (`attribute_id`),
        FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB");
}

$installer->addEntityType('bkg_orgunit', array(
    'entity_model'               => 'bkg_orgunit/unit_address',
    'table'                      => 'bkg_orgunit/unit_address_entity',
    'additional_attribute_table' => 'bkg_orgunit/eav_attribute'
));

if (!$installer->tableExists($unit_address))
{
    $installer->run("
	-- DROP TABLE IF EXISTS {$unit_address};
	CREATE TABLE {$unit_address} (
	  `entity_id` int(11) unsigned NOT NULL auto_increment,
	  `unit_id` int(11) unsigned NOT NULL,
      `name` varchar(255) default '',
    
	  PRIMARY KEY (`entity_id`),
	  FOREIGN KEY (`unit_id`) REFERENCES `{$unit}`(`id`) ON DELETE CASCADE
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
        'type'  => 'int',
        'label' => 'Organisation',
		'input' => 'select',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
        'source'    => 'bkg_orgunit/entity_attribute_source_unit',
        'backend'    => 'bkg_orgunit/entity_attribute_backend_unit',
    ));
    
    /**
     * @var Mage_Eav_Model_Attribute $attr
     */
    $attrId = $installer->getAttributeId('customer', 'org_unit');
    $this->getConnection()->insert($this->getTable('customer/form_attribute'), array(
        'form_code'     => 'adminhtml_customer',
        'attribute_id'  => $attrId
    ));
}

$org_form_attribute = $installer->getTable('bkg_orgunit/form_attribute');

if (!$installer->tableExists($org_form_attribute)) {
    
    $installer->run("CREATE TABLE {$org_form_attribute} (
        `form_code` varchar(32) NOT NULL COMMENT 'Form Code',
        `attribute_id` smallint(5) unsigned NOT NULL COMMENT 'Attribute Id',
        PRIMARY KEY (`form_code`,`attribute_id`),
        KEY (`attribute_id`),
        FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB");
}


$store = 0;

$addressHelper = Mage::helper('customer/address');
// update customer address system attributes data
$attributes = array(
    'prefix'            => array(
        'backend_type'      => 'varchar',
        'frontend_label'    => 'Prefix',
        'is_user_defined'   => 0,
        'is_system'         => 0,
        'is_visible'        => $addressHelper->getConfig('prefix_show', $store) == '' ? 0 : 1,
        'sort_order'        => 10,
        'is_required'       => $addressHelper->getConfig('prefix_show', $store) == 'req' ? 1 : 0,
    ),
    'firstname'         => array(
        'backend_type'      => 'varchar',
        'frontend_label'    => 'First Name',
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
        'frontend_label'    => 'Middle Name/Initial',
        'is_user_defined'   => 0,
        'is_system'         => 0,
        'is_visible'        => $addressHelper->getConfig('middlename_show', $store) == '' ? 0 : 1,
        'sort_order'        => 30,
        'is_required'       => $addressHelper->getConfig('middlename_show', $store) == 'req' ? 1 : 0,
    ),
    'lastname'          => array(
        'backend_type'      => 'varchar',
        'frontend_label'    => 'Last Name',
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
        'frontend_label'    => 'Suffix',
        'is_user_defined'   => 0,
        'is_system'         => 0,
        'is_visible'        => $addressHelper->getConfig('suffix_show', $store) == '' ? 0 : 1,
        'sort_order'        => 50,
        'is_required'       => $addressHelper->getConfig('suffix_show', $store) == 'req' ? 1 : 0,
    ),
    'company'           => array(
        'backend_type'      => 'varchar',
        'frontend_label'    => 'Company',
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
        'backend_type'      => 'varchar', // FIXME text currently break the code
        'backend_model'     => 'customer/entity_address_attribute_backend_street',
        'frontend_label'    => 'Street Address',
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
        'frontend_label'    => 'City',
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
        'frontend_input'    => 'select',
        'frontend_label'    => 'Country',
        'source_model'      => 'customer/entity_address_attribute_source_country',
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
        'frontend_label'    => 'Zip/Postal Code',
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
        'frontend_label'    => 'Telephone',
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
        'frontend_label'    => 'Fax',
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
        'frontend_label'    => 'e-Mail',
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
        'frontend_label'    => 'Web',
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
    'unit_id'           => array(
        'backend_type'      => 'static', // need to be static otherwise insert fail
        'is_user_defined'   => 0,
        'is_system'         => 1,
    )
);
/**
 * @var Mage_Eav_Model_Config $eavConfig
 */
$eavConfig = Mage::getSingleton('eav/config');
foreach ($attributes as $attributeCode => $data) {
    if (!$installer->getAttribute('bkg_orgunit', $attributeCode)) {
        $attribute = $eavConfig->getAttribute('bkg_orgunit', $attributeCode);
        $attribute->addData($data);
        $attribute->save();

        $this->getConnection()->insert($org_form_attribute, array(
            'form_code'     => 'adminhtml_bkg_orgunit_address',
            'attribute_id'  => $attribute->getAttributeId()
        ));
    }
}

if (!$installer->getAttribute('customer_address', 'org_address_id'))
{
    $installer->addAttribute('customer_address', 'org_address_id', array(
        'type' => 'static',
        'label' => 'Organisation Address',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        //'source'    => 'eav/entity_attribute_source_boolean',
    ));
}

$customer_address = $installer->getTable('customer/address_entity');

if (!$installer->getConnection()->tableColumnExists($customer_address, 'org_address_id')) {
    $installer->getConnection()->addColumn($customer_address, 'org_address_id', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => true,
        'default'   => null,
        'comment'   => "id to bkg_orgunit address"
    ));
    // extra check if FK exist?
    $fkName = $installer->getFkName($customer_address, 'org_address_id', $unit_address, 'entity_id');
    $installer->getConnection()->addForeignKey($fkName, $customer_address, 'org_address_id', $unit_address, 'entity_id');
}

$installer->endSetup();
