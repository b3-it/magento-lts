<?php

$installer = $this;

$installer->startSetup();

$installer->addEntityType('stationen_stationen', array(
    'entity_model'    => 'stationen/stationen',
    'table'           =>'stationen/stationen',
));



$installer->addEntityType('stationen_set', array(
    'entity_model'    => 'stationen/set',
    'table'           =>'stationen/set',
));

$table = $installer->getConnection()
    ->newTable($installer->getTable('stationen/stationen'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity ID')
    ->addColumn('stationskennung', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array(), 'stationskennung')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Update Time')
    ->addColumn('avail_from', Varien_Db_Ddl_Table::TYPE_DATE, null, array(), 'Avail From Date')
    ->addColumn('avail_to', Varien_Db_Ddl_Table::TYPE_DATE, null, array(), 'Available To Date Time')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Status')
    ->addColumn('lat', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array(), 'Latitude')
    ->addColumn('lon', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array(), 'Longitude')
    ->addColumn('height', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array(), 'Height NN')
    ->addColumn('overwrite', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Overwrite on Import')
    ->addColumn('mirakel_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Mirakel ID')
    ->addColumn('styp', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array(), 'Styp')
    ->addColumn('region', Varien_Db_Ddl_Table::TYPE_VARCHAR, 512, array(), 'Region')
    ->addColumn('landkreis', Varien_Db_Ddl_Table::TYPE_VARCHAR, 512, array(), 'Landkreis')
    ->addColumn('gemeinde', Varien_Db_Ddl_Table::TYPE_VARCHAR, 512, array(), 'Gemeinde')
    ->addColumn('messnetz', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array(), 'Messnetz')
    ->addColumn('ktyp', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array(), 'ktyp')
    ->addColumn('land', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array(), 'Land')
    
     ;
$installer->getConnection()->createTable($table);



$table = $installer->getConnection()
    ->newTable($installer->getTable('stationen/stationen_entity_varchar'))
    ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Value Id')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type Id')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store ID')        
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Id')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, 512, array(
        ), 'Value')
    ->addIndex(
        $installer->getIdxName(
            'stationen_stationen_entity_varchar',
            array('entity_id', 'attribute_id', 'store_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('entity_id', 'attribute_id', 'store_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName('stationen_stationen_entity_varchar', array('attribute_id')),
        array('attribute_id'))
    ->addIndex($installer->getIdxName('stationen_entity_varchar', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('stationen_entity_varchar', array('entity_id')),
        array('entity_id'))
    ->addForeignKey(
        $installer->getFkName('stationen_entity_varchar', 'attribute_id', 'eav/attribute', 'attribute_id'),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName('stationen_entity_varchar', 'entity_id', 'stationen/stationen', 'entity_id'),
        'entity_id', $installer->getTable('stationen/stationen'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName('stationen_entity_varchar', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
    ->newTable($installer->getTable('stationen/stationen_entity_int'))
    ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Value Id')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type Id')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store ID')        
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Id')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Value')
    ->addIndex(
        $installer->getIdxName(
            'stationen_entity_int',
            array('entity_id', 'attribute_id', 'store_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('entity_id', 'attribute_id', 'store_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName('stationen_entity_int', array('attribute_id')),
        array('attribute_id'))
    ->addIndex($installer->getIdxName('stationen_entity_int', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('stationen_entity_int', array('entity_id')),
        array('entity_id'))
    ->addForeignKey(
        $installer->getFkName('stationen_entity_int', 'attribute_id', 'eav/attribute', 'attribute_id'),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName('stationen_entity_int', 'entity_id', 'stationen/stationen', 'entity_id'),
        'entity_id', $installer->getTable('stationen/stationen'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName('stationen_entity_int', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($table);




//sets

$table = $installer->getConnection()
    ->newTable($installer->getTable('stationen/set'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity ID')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Update Time')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Status')
 
     ;
$installer->getConnection()->createTable($table);



$table = $installer->getConnection()
    ->newTable($installer->getTable('stationen/set_entity_varchar'))
    ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Value Id')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type Id')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store ID')        
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Id')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, 512, array(
        ), 'Value')
    ->addIndex(
        $installer->getIdxName(
            'stationen_set_entity_varchar',
            array('entity_id', 'attribute_id', 'store_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('entity_id', 'attribute_id', 'store_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName('stationen_set_entity_varchar', array('attribute_id')),
        array('attribute_id'))
    ->addIndex($installer->getIdxName('stationen_set_entity_varchar', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('stationen_set_entity_varchar', array('entity_id')),
        array('entity_id'))
    ->addForeignKey(
        $installer->getFkName('stationen_set_entity_varchar', 'attribute_id', 'eav/attribute', 'attribute_id'),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName('stationen_set_entity_varchar', 'entity_id', 'stationen/set', 'entity_id'),
        'entity_id', $installer->getTable('stationen/set'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName('stationen_set_entity_varchar', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($table);

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('stationen_set_relation')};
CREATE TABLE {$this->getTable('stationen_set_relation')} (
  `stationen_set_relation_id` int(11) unsigned NOT NULL auto_increment,
  `stationskennung`  varchar(128) NOT NULL,
  `set_id` int(11) unsigned NOT NULL,
  FOREIGN KEY (`set_id`) REFERENCES {$this->getTable('stationen/set')} (entity_id) ON DELETE CASCADE,
  PRIMARY KEY (`stationen_set_relation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 
$installer->installEntities();