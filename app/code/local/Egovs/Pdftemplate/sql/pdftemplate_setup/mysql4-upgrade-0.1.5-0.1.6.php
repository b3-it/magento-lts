<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('pdftemplate_customergroup_store')};
CREATE TABLE {$this->getTable('pdftemplate_customergroup_store')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `invoice_template_id` int(11) unsigned NULL default 0,
  `shipping_template_id` int(11) unsigned NULL default 0,
  `creditmemo_template_id` int(11) unsigned NULL default 0,
  `customer_group_id` smallint(5) unsigned  default 0,
  `store_id` smallint(5) unsigned NOT NULL default 0,
   FOREIGN KEY (`customer_group_id`) REFERENCES {$this->getTable('customer_group')} (customer_group_id) ON DELETE CASCADE,
   FOREIGN KEY (`invoice_template_id`) REFERENCES {$this->getTable('pdftemplate_template')} (pdftemplate_template_id) ON DELETE CASCADE,
   FOREIGN KEY (`shipping_template_id`) REFERENCES {$this->getTable('pdftemplate_template')} (pdftemplate_template_id) ON DELETE CASCADE,
   FOREIGN KEY (`creditmemo_template_id`) REFERENCES {$this->getTable('pdftemplate_template')} (pdftemplate_template_id) ON DELETE CASCADE,
   FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')} (store_id) ON DELETE CASCADE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->run("
		INSERT INTO {$this->getTable('pdftemplate_customergroup_store')} (`invoice_template_id`, `shipping_template_id`, `creditmemo_template_id`,`customer_group_id`,`store_id`) 
SELECT invoice_template, shipping_template, creditmemo_template, customer_group_id, 0 FROM {$this->getTable('customer_group')};");



$installer->endSetup(); 