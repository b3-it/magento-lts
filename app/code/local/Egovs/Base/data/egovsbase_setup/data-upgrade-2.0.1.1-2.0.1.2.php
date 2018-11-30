<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

// @var $checks  array  alle einzelnen Bestellbedingungen (keine Doppelten)
$checks = array();

// @var $remove  array  IDs aller Bedingungen, die entfernt werden sollen
$remove = array();

/**
 * @var Mage_Checkout_Model_Resource_Agreement_Collection $agreements
 */
$agreements = Mage::getModel('checkout/agreement')->getCollection();

if ( $agreements instanceof Mage_Checkout_Model_Resource_Agreement_Collection ) {
    foreach ($agreements AS $agreement) {
        $agreeName = $agreement->getName();
        
        if ( !array_key_exists($agreeName, $checks) ) {
            $checks[$agreeName] = array(
                'content'  => $agreement->getContent(),
                'checkbox' => $agreement->getCheckboxHtml()
            );
        }
        else {
            $check1 = $checks[$agreeName]['content'];
            $check2 = $checks[$agreeName]['checkbox'];
            if ( ($check1 == $agreement->getContent()) AND ($check2 == $agreement->getCheckboxHtml()) ) {
                // Das ist dann gleich
                $remove[] = $agreement->getAgreementId();
            }
        }
    }
}

if ( count($remove) ) {
    $tableName = $installer->getTable('checkout_agreement');
    $liste     = implode(', ', $remove);
    $this->run("DELETE FROM {$tableName} WHERE `agreement_id` IN ({$liste});");
}

$installer->endSetup();
