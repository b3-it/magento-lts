<?php
/**
 * Änderungen um Haupt-/Nebenkunden unterstützen zu können
 * 
 */

/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('`sales_flat_quote_item`')} CHANGE `stala_freecopies` `stala_freecopies` TEXT NULL DEFAULT NULL;
ALTER TABLE {$this->getTable('`sales_flat_order_item`')} CHANGE `stala_freecopies` `stala_freecopies` TEXT NULL DEFAULT NULL;

");

$installer->endSetup(); 