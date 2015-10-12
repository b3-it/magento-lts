<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->dropForeignKey($this->getTable('informationservice_request'),'informationservice_request_ibfk_1');
$installer->run("ALTER TABLE {$this->getTable('informationservice_request')} MODIFY COLUMN `customer_id` INT(11) UNSIGNED DEFAULT NULL;");
$installer->getConnection()->addConstraint('informationservice_request_ibfk_1',$this->getTable('informationservice_request'),'customer_id',
							$this->getTable('customer/entity'), 'entity_id','SET NULL');

$installer->getConnection()->dropForeignKey($this->getTable('informationservice_request'),'informationservice_request_ibfk_2');
$installer->run("ALTER TABLE {$this->getTable('informationservice_request')} MODIFY COLUMN `address_id` INT(11) UNSIGNED DEFAULT NULL;");
$installer->getConnection()->addConstraint('informationservice_request_ibfk_2',$this->getTable('informationservice_request'),'address_id',
							$this->getTable('customer/address_entity'), 'entity_id','SET NULL');

$installer->getConnection()->dropForeignKey($this->getTable('informationservice_request'),'informationservice_request_ibfk_3');
$installer->run("ALTER TABLE {$this->getTable('informationservice_request')} MODIFY COLUMN `category_id` INT(11) UNSIGNED DEFAULT NULL;");
$installer->getConnection()->addConstraint('informationservice_request_ibfk_3',$this->getTable('informationservice_request'),'category_id',
							$this->getTable('catalog/category'), 'entity_id','SET NULL');

$installer->endSetup(); 
