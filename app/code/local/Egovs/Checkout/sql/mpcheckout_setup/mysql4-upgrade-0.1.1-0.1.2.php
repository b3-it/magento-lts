<?php

$installer = $this;

$installer->startSetup();

$installer->updateAttribute('catalog_product', 'infotext_block_checkbox', 'is_configurable', false);
$installer->updateAttribute('catalog_product', 'infotext_block', 'is_configurable', false);

$installer->endSetup(); 
