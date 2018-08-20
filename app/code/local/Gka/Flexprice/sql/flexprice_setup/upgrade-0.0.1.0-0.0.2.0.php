<?php
/**
 * Created by PhpStorm.
 * User: h.koegel
 * Date: 20.08.2018
 * Time: 15:03
 */

$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'can_change_qty', array(
    'label' => 'Kann die Menge eingegeben werden',
    'input' => 'select',
    'type' => 'int',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'is_user_defined' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '0',
    //'option' => $option,
    'group' => 'General',
    'source' => 'eav/entity_attribute_source_boolean',
    'apply_to' => Gka_Flexprice_Model_Product_Type::TYPE_CODE,
));

$installer->endSetup();