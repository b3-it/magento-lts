<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('framecontract_vendor')};
CREATE TABLE {$this->getTable('framecontract_vendor')} (
  `framecontract_vendor_id` int(11) unsigned NOT NULL auto_increment,
  `company` varchar(255) NOT NULL default '',
  `operator` varchar(255) NOT NULL default '',
  `order_email` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `street` varchar(255) NOT NULL default '',
  `city` varchar(125) NOT NULL default '',
  `plz` varchar(10) NOT NULL default '',
  `fax` varchar(100) NOT NULL default '',
  `tel` varchar(100) NOT NULL default '',
  `country` varchar(125) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`framecontract_vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- DROP TABLE IF EXISTS {$this->getTable('framecontract_contract')};
CREATE TABLE {$this->getTable('framecontract_contract')} (
  `framecontract_contract_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `framecontract_vendor_id` int(11) unsigned NOT NULL,
  `operator` varchar(255) NOT NULL default '',
  `order_email` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `start_date` datetime NULL,
  `end_date` datetime NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
    FOREIGN KEY (`framecontract_vendor_id`) REFERENCES {$this->getTable('framecontract_vendor')} (framecontract_vendor_id) ON DELETE CASCADE,
  PRIMARY KEY (`framecontract_contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- DROP TABLE IF EXISTS {$this->getTable('framecontract_files')};
	CREATE TABLE {$this->getTable('framecontract_files')} (
  `framecontract_files_id` int(11) unsigned NOT NULL auto_increment,
  `framecontract_contract_id` int(11) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL default '',
  `filename_original` varchar(255) NOT NULL default '',
  `type` smallint(6) NOT NULL default '0',
  FOREIGN KEY (`framecontract_contract_id`) REFERENCES {$this->getTable('framecontract_contract')} (framecontract_contract_id) ON DELETE CASCADE,
  PRIMARY KEY (`framecontract_files_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('framecontract_transmit')};
	CREATE TABLE {$this->getTable('framecontract_transmit')} (
  `framecontract_transmit_id` int(11) unsigned NOT NULL auto_increment,
  `framecontract_contract_id` int(11) unsigned NOT NULL,
  `owner` varchar(255) NOT NULL default '',
  `recipient` varchar(255) NOT NULL default '',
  `transmit_date` TIMESTAMP default NOW(),
  FOREIGN KEY (`framecontract_contract_id`) REFERENCES {$this->getTable('framecontract_contract')} (framecontract_contract_id) ON DELETE CASCADE,
  PRIMARY KEY (`framecontract_transmit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");


$installer->addAttribute('catalog_product', 'framecontract', array(
    'label'        => 'Frame Contract',
	'input' => 'select',
	'type' => 'int',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
	'source' => 'framecontract/source_attribute_contracts',
    'default' => '0',
));

$installer->endSetup(); 