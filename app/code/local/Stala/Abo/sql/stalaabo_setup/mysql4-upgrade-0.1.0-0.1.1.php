<?php

$installer = $this;

$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('extstock')} ADD Column is_abo int(3) unsigned default 0");
$installer->run("ALTER TABLE {$this->getTable('stala_abo_delivered')} ADD Column order_id int(11) unsigned default 0");
$installer->run("ALTER TABLE {$this->getTable('stala_abo_delivered')} ADD Column link_hash varchar(255) default ''");

$installer->updateAttribute('catalog_product', 'is_abo_base_product', 'frontend_input_renderer', 'stalaabo/adminhtml_product_edit_renderer_aboswitch');

$installer->run("ALTER TABLE {$this->getTable('stala_abo_contract')} ADD Column is_deleted smallint(6) default 0");
$installer->run("ALTER TABLE {$this->getTable('stala_abo_contract')} ADD Column delete_date datetime default NULL");

$installer->endSetup(); 