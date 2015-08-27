<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();


$text = '<p>Die Zugangsdaten f&uuml;r die von Ihnen erworbenen Produkte k&ouml;nnen Sie jederzeit in Ihrem Kundenkonto unter <a href="{{config path="web/secure/base_url"}}dwd_icd/index/view"> Meine Zug&auml;nge</a> &auml;ndern.</p>';

$model = Mage::getModel('cms/block');
$blockData['stores'] = array('0');
$blockData['is_active'] = '1';
$blockData['content'] = $text;
$blockData['title'] = 'ICD Verkaufs Email';
$blockData['identifier'] = 'icd_sales_order_email';

$block = $model->load($blockData['identifier']);
$model->setData($blockData)->save();





$installer->endSetup();