<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

$emailUpdate = array(
    0 => array(
        'id'       => 45,
        'name'     => 'Credit memo update (template)',
        'template' => 'en' . DS . 'credit_memo_update.htm'
    ),
    1 => array(
        'id'       => 46,
        'name'     => 'New credit memo (template)',
        'template' => 'en' . DS . 'new_credit_memo.htm'
    ),
    2 => array(
        'id'       => 43,
        'name'     => 'New invoice (template)',
        'template' => 'en' . DS . 'new_invoice.htm'
    ),
    3 => array(
        'id'       => 40,
        'name'     => 'New password (template)',
        'template' => 'en' . DS . 'new_password.htm'
    ),
    4 => array(
        'id'       => 39,
        'name'     => 'New account confirmed (Template)',
        'template' => 'en' . DS . 'new_account_confirmed.htm'
    ),
    5 => array(
        'id'       => 38,
        'name'     => 'Account confirmation key (Template)',
        'template' => 'en' . DS . 'account_confirmation_key.htm'
    ),
    6 => array(
        'id'       => 37,
        'name'     => 'New account (Template)',
        'template' => 'en' . DS . 'new_account.htm'
    ),
    7 => array(
        'id'       => 17,
        'name'     => 'Neue Gutschrift (Template)',
        'template' => 'de' . DS . 'neue_gutschrift.htm'
    ),
    8 => array(
        'id'       => 14,
        'name'     => 'Neue Rechnung Gast (Template)',
        'template' => 'de' . DS . 'neue_rechnung_gast.htm'
    ),
    9 => array(
        'id'       => 13,
        'name'     => 'Neue Rechnung (Template)',
        'template' => 'de' . DS . 'neue_rechnung.htm'
    ),
    10 => array(
        'id'       => 10,
        'name'     => 'Neue Bestellung Gast (Template)',
        'template' => 'de' . DS . 'neue_bestellung_gast.htm'
    ),
    11 => array(
        'id'       => 8,
        'name'     => 'Neues Passwort (Template)',
        'template' => 'de' . DS . 'neues_passwort.htm'
    ),
    12 => array(
        'id'       => 7,
        'name'     => 'Neues Konto Bestätigung (Template)',
        'template' => 'de' . DS . 'neues_konto_bestaetigung.htm'
    ),
    13 => array(
        'id'       => 6,
        'name'     => 'Neues Konto Aktivierung  (Template)',
        'template' => 'de' . DS . 'neues_konto_aktivierung.htm'
    ),
    14 => array(
        'id'       => 5,
        'name'     => 'Neues Konto (Template)',
        'template' => 'de' . DS . 'neues_konto.htm'
    ),
    15 => array(
        'id'       => 41,
        'name'     => 'New order (template)',
        'template' => 'en' . DS . 'new_order.htm'
    ),
    16 => array(
        'id'       => 9,
        'name'     => 'Neue Bestellung (Template)',
        'template' => 'de' . DS . 'neue_bestellung.htm'
    ),
);

/* @var $mailSetup Egovs_Base_Helper_Emailsetup_Data */
$mailSetup = Mage::helper('egovsbase_emailsetup');
$mailSetup->updateEmailTemplates($emailUpdate, implode(DS, array('leipzig', 'default', 'email', 'templates')), $installer);

$installer->endSetup();

