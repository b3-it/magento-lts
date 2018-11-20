<?php
/**
 * @var Bkg_VirtualGeo_Model_Resource_Setup $installer
 */
$installer = $this;

$installer->startSetup();

$destTable = $installer->getTable('virtualgeo/product_option_value');
$components = array(
    $installer->getTable('virtualgeo_components_content_product') => Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_CONTENT,
    $installer->getTable('virtualgeo_components_format_product') => Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_FORMAT,
    $installer->getTable('virtualgeo_components_georef_product') => Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_GEOREF,
    $installer->getTable('virtualgeo_components_resolution_product') => Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_RESOLUTION,
    $installer->getTable('virtualgeo_components_structure_product') => Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_STRUCTURE,
);

foreach ($components as $srcTableName => $componentType) {
    $installer->run("
        INSERT INTO $destTable
            (`entity_id`,
            `component_type`,
            `product_id`,
            `store_id`,
            `pos`,
            `is_default`,
            `is_visible_only_in_admin`)
        SELECT `entity_id`, $componentType, `product_id`, `store_id`, `pos`, `is_default`, `is_visible_only_in_admin`
        FROM $srcTableName as src
    ");
}

$destContentTable = $installer->getTable('virtualgeo/components_content_option_value');
$type =  Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_CONTENT;
$installer->run("
    INSERT INTO {$destContentTable}
        (`entity_id`,
        `parent_node_id`,
        `readonly`,
        `is_checked`)
    SELECT `src`.`id`, `parent_node_id`, `readonly`, `is_checked`
    FROM {$destTable} as src
    inner join {$installer->getTable('virtualgeo_components_content_product')} as old on old.entity_id = src.entity_id and component_type = {$type};
");

$installer->endSetup();