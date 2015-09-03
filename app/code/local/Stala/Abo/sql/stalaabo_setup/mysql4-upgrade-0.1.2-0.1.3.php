<?php

$installer = $this;

$installer->startSetup();
$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), 'stala_abo_shipping_address_id', 'int(11)');
$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), 'stala_abo_shipping_address_id', 'int(11)');

/*
$installer->addAttribute('quote_item', 'stala_abo_shipping_address_id', array('type'=>'int'));
$installer->addAttribute('order_item', 'stala_abo_shipping_address_id', array('type'=>'int'));
*/
$installer->endSetup(); 