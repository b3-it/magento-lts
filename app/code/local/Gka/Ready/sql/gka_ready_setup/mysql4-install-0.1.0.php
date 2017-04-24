<?php

$installer = $this;

$installer->startSetup();

$installer->run("DELETE FROM {$this->getTable('checkout/agreement')}; ");

$installer->endSetup(); 