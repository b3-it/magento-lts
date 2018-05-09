<?php

/* @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();


$table = 'virtualgeo/components_structure';

if ($installer->tableExists($installer->getTable($table.'_entity'))
        && !$installer->getConnection()->tableColumnExists($installer->getTable($table.'_entity'), 'layer_naming_rule'))
{
    $installer->run("ALTER TABLE {$installer->getTable($table.'_entity')}
      ADD layer_naming_rule varchar(255) default '{{product_code}}_{{crs_code}}_{{structure_code}}'
    ");
}

$installer->endSetup();