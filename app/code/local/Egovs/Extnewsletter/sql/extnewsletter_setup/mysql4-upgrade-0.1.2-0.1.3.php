<?php

$installer = $this;

$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('newsletter_subscriber')} ADD `last_confirmation_request` DATETIME ");
$installer->endSetup(); 