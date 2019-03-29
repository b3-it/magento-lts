<?php


/** @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$eavStr = 'customer';

$worthLevelModel = [
    3 => "egovs_creditworth/attribute_source_worth3",
    4 => "egovs_creditworth/attribute_source_worth4"
];

$attrs = [
    'credit_worth_creditcard' => ['label' => 'Creditworthiness (Credit card)', 'worth' => 3],
    'credit_worth_debit' => ['label' => 'Creditworthiness (Debit)', 'worth' => 4],
    'credit_worth_giro' => ['label' => 'Creditworthiness (Giro)', 'worth' => 4],
];

foreach ($attrs as $key => $data) {
    if (!$installer->getAttribute($eavStr, $key)) {
        $installer->addAttribute($eavStr, $key, array(
            'label' => $data['label'],
            'type' => 'int',
            'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'input' => 'select',
            //'position' => 200,
            'source'    => $worthLevelModel[$data['worth']],
        ));

        $attrId = $installer->getAttributeId($eavStr, $key);
        $this->getConnection()->insert($this->getTable('customer/form_attribute'), array(
            'form_code'     => 'adminhtml_customer',
            'attribute_id'  => $attrId
        ));
    }
}

$installer->endSetup();