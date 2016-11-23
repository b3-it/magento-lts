<?php

$installer = $this;

$installer->startSetup();
if ($installer->getAttribute('catalog_product', 'store_group')) {
	$installer->updateAttribute('catalog_product','store_group','frontend_input','select');
	$installer->updateAttribute('catalog_product','store_group','frontend_label','Isoliert in');
	$installer->updateAttribute('catalog_product','store_group','source_model','isolation/entity_attribute_source_storegroups');
	$installer->updateAttribute('catalog_product','store_group','is_required',false);
	$installer->updateAttribute('catalog_product','store_group','frontend_input_renderer','isolation/adminhtml_widget_storegroup');
}

$installer->endSetup(); 