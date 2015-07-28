<?php

$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('pdftemplate_blocks')} ADD tax_rule varchar(255) NOT NULL default 'all';");

$installer->endSetup(); 