<?php
/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$installer->run("UPDATE {$this->getTable('admin_user')} SET allow_all_customergroups = 1 WHERE user_id = 1");


$installer->endSetup(); 