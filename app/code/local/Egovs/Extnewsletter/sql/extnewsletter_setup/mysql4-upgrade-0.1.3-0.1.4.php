<?php

$installer = $this;

$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('extnewsletter_issue')} ADD `remove_subscriber_after_send` int default 0 ");

$installer->endSetup(); 