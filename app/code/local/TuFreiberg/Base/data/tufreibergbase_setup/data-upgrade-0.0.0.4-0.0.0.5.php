<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

// Daten in der Website löschen
$cfgTable = $installer->getTable('core/config_data');
$installer->run("DELETE FROM `{$cfgTable}` WHERE `path` = 'payment_services/paymentbase/adminemail' AND `scope` = 'websites';");
$installer->run("DELETE FROM `{$cfgTable}` WHERE `path` = 'payment_services/paymentbase/service' AND `scope` = 'websites';");
$installer->run("DELETE FROM `{$cfgTable}` WHERE `path` = 'payment_services/paymentbase/client_certificate' AND `scope` = 'websites';");
$installer->run("DELETE FROM `{$cfgTable}` WHERE `path` = 'payment_services/paymentbase/ca_certificate' AND `scope` = 'websites';");

// Haupt-Config korrigieren
$this->setConfigData('payment_services/paymentbase/adminemail', 'epayment@testshop.org');
$this->setConfigData('payment_services/paymentbase/service', 'https://zvis.egov.sachsen.de/soap/servlet/rpcrouter');
$this->setConfigData('payment_services/paymentbase/client_certificate', '/lib/ePayment/client.sachsen.zvis.cert');
$this->setConfigData('payment_services/paymentbase/ca_certificate', '/lib/ePayment/ca.sachsen.chain.crt');

$installer->endSetup();
