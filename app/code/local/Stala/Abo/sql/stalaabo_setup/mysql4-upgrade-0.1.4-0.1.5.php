<?php

$installer = $this;

$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('stala_abo_delivered')} ADD Column abo_quote_item_id int(11)");


$installer->endSetup(); 