<?php

/* @var $installer Mage_Eav_Model_Entity_Setup*/
$installer = $this;
$installer->startSetup();

$attribute_default_billig = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('customer','default_billing');
$attribute_base_address =  Mage::getResourceModel('eav/entity_attribute')->getIdByCode('customer','base_address');

//sicherheitshalber base_address_attribute löschen
$sql = 'delete from customer_entity_int where attribute_id ='. $attribute_base_address;
$installer->run($sql);

//neues base_addres_atribute anlegen
$sql = 'insert into customer_entity_int (`entity_type_id`,`attribute_id`,`entity_id`,`value`) select `entity_type_id`,'.$attribute_base_address.', `entity_id`,`value` from customer_entity_int t1 where t1.attribute_id = '.$attribute_default_billig;
$installer->run($sql);

$attribute_address_taxvat = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('customer_address','taxvat');
$attribute_customer_taxvat =  Mage::getResourceModel('eav/entity_attribute')->getIdByCode('customer','taxvat');
$type = Mage::getModel('eav/entity_type')->loadByCode('customer_address');

//sicherheitshalber attribute_address_taxvat löschen
$sql = 'delete from customer_address_entity_varchar where attribute_id ='. $attribute_address_taxvat;
$installer->run($sql);




$sql = "insert into customer_address_entity_varchar (`entity_type_id`,`attribute_id`,`entity_id`,`value`) ";
$sql .= " select ".$type->getEntityTypeId().",".$attribute_address_taxvat.", t1.value as adr_id, t2.value as taxvat from customer_entity_int as t1 ";
$sql .= "join customer_entity_varchar as t2 on t1.entity_id = t2.entity_id and t2.attribute_id = ".$attribute_customer_taxvat." and t2.value is not null ";
$sql .= "where t1.attribute_id = " .$attribute_base_address;
$installer->run($sql);

$installer->getConnection()->delete($this->getTable('customer/form_attribute'), 'attribute_id = '.$attribute_customer_taxvat);


$installer->endSetup();