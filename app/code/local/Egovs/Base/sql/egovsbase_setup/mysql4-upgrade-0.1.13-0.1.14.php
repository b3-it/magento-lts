<?php

$installer = $this;

/* @var $installer Mage_Customer_Model_Entity_Setup */
$installer->startSetup();



$installer->run("ALTER TABLE `{$installer->getTable('customer_group')}`  MODIFY `customer_group_code` varchar(255) default ''");



$installer->endSetup();
