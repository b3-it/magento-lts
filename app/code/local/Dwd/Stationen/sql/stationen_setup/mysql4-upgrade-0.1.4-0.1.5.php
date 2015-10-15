<?php

$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('stationen/set')} ADD `show_active_only` tinyint(1) NOT NULL default 1");


$entities = array('stationen_set' => array(
                'entity_model' => 'stationen/set',
                'table' => 'stationen/set', 
                'attributes' => array(
                    'show_active_only' => array(
                        'type' => 'static',
                        'label' => 'show active stations only',
                        'input' => 'int',
                        'required' => true,
                        'sort_order' => 60,
                        'position' => 60,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    ),  )));

$installer->installEntities($entities);
$installer->endSetup(); 