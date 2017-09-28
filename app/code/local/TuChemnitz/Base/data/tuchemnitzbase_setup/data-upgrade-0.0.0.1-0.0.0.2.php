<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

// ScopeID für Ticketshop ermitteln
//$scopeId = Mage::getModel('core/store')->load('papercut', 'code')->getWebsiteId();

// eMail-Einstellungen anpassen
$email_logos = array(
    0 => array(
        'scope'       => 'default',
        'scope_id'    => '0',
        'default'     => 'logo_email_chemnitz_default.png',
        'data'        => array(
            'logo'        => 'logo_email_chemnitz.png',
            'logo_alt'    => 'Logo TU Chemnitz',
            'logo_width'  => '286',
            'logo_height' => '116',
        )
    ),
);

$email_templates = array(
    0 => array(
        'template' => 'header.htm',
        'name'     => 'eMail-Header',
        'topic'    => 'Email - Kopfzeile',
        'path'     => 'design/email/header'
    ),
    1 => array(
        'template' => 'support.htm',
        'name'     => 'eMail-Support',
        'topic'    => 'E-Mail - Support',
        'path'     => 'design/email/support'
    ),
    2 => array(
        'template' => 'footer.htm',
        'name'     => 'eMail-Footer',
        'topic'    => 'E-Mail - Fußzeile',
        'path'     => 'design/email/footer'
    ),
);

/* @var $mailSetup Egovs_Base_Helper_Emailsetup_Data */
$mailSetup = Mage::helper('egovsbase_emailsetup');

$mailSetup->setEmailConfig($email_logos, implode(DS, array('chemnitz', 'default', 'email', 'images')), $installer);
$mailSetup->setEmailTemplates($email_templates, implode(DS, array('chemnitz', 'default', 'email', 'templates')), $installer);

$installer->endSetup();