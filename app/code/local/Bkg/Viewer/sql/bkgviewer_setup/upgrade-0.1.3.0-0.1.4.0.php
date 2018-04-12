<?php

/* @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$t = $installer->getTable('bkgviewer/composit_selectiontools');

if ($installer->tableExists($t) && !$installer->getConnection()->tableColumnExists($t, 'visual_pos')) {
    $installer->getConnection()->addColumn($t, 'visual_pos', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => false,
        'default'   => '0',
        'comment'   => ""
    ));
}

$installer->endSetup();