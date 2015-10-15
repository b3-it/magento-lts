<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('pdftemplate_template')};
CREATE TABLE {$this->getTable('pdftemplate_template')} (
  `pdftemplate_template_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `type` smallint(6) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `position` smallint(6) NOT NULL default '0',
  `font` smallint(6) NOT NULL default '0',
  `fontsize` smallint(6) NOT NULL default '11',
  PRIMARY KEY (`pdftemplate_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('pdftemplate_section')};
CREATE TABLE {$this->getTable('pdftemplate_section')} (
  `pdftemplate_section_id` int(11) unsigned NOT NULL auto_increment,
  `pdftemplate_template_id` int(11) unsigned NOT NULL,
  `top` int NOT NULL default 0,
  `left` int NOT NULL default 0,
  `width` int NOT NULL default 0,
  `height` int NOT NULL default 0,
  `content` text NOT NULL default '',
  `sectiontype` smallint(6) NOT NULL default '0',
  `position` smallint(6) NOT NULL default '0',
  `occurrence` smallint(6) NOT NULL default 0,
  FOREIGN KEY (`pdftemplate_template_id`) REFERENCES {$this->getTable('pdftemplate_template')} (pdftemplate_template_id) ON DELETE CASCADE,
  PRIMARY KEY (`pdftemplate_section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");




$installer->run("
	ALTER TABLE {$this->getTable('customer_group')} 
	ADD invoice_template int(11) unsigned default 0,
	ADD shipping_template int(11) unsigned default 0,
	ADD creditmemo_template int(11) unsigned default 0 ;
");
	

$installer->endSetup(); 