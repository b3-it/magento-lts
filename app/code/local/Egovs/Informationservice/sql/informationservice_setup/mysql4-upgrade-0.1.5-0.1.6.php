<?php

$installer = $this;

$installer->startSetup();

$installer->updateAttribute('catalog_product', 'infoservice_is_master_product', 'is_configurable', false);

$installer->endSetup(); 
