<?php

$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('egovs_paymentbase_localparams')} modify `customer_group_id` smallint(5) default -1;
");

$installer->endSetup();