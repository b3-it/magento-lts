<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

// alle Seiten-Layouts zurücksetzen
$_cmsTable = $installer->getTable('cms/page');
if ($installer->tableExists($_cmsTable)) {
    $installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'two_columns_right';");
    $installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'three_columns';");
}

// alle Kategorie-Layouts zurücksetzen
$_catTable = $installer->getTable('catalog_category_entity_varchar');
$installer->run("UPDATE `{$_catTable}` SET `value` = 'two_columns_left' WHERE `value` = 'three_columns';");
$installer->run("UPDATE `{$_catTable}` SET `value` = 'two_columns_left' WHERE `value` = 'two_columns_right';");

// Logo-Grafiken setzen
$installer->setConfigData('design/header/logo_src', 'images/logo_sachsen.png');
$installer->setConfigData('design/header/logo_src_small', 'images/logo_sachsen_smartphone.png');

// Theme-Einstellungen zurücksetzen
$installer->setConfigData('design/theme/locale', '');
$installer->setConfigData('design/theme/template', '');
$installer->setConfigData('design/theme/skin', '');
$installer->setConfigData('design/theme/layout', '');
$installer->setConfigData('design/theme/default', '');

// Default-Package setzen
$installer->setConfigData('design/package/name', 'leipzig');

// Kreditkarte per Girosolution
// https://trac.kawatest.de/ticket/2917
$installer->setConfigData('payment/egovs_girosolution_creditcard/active'     , '1');
$installer->setConfigData('payment/egovs_girosolution_creditcard/merchant_id', 'RiUPLAz1MsQ=');
$installer->setConfigData('payment/egovs_girosolution_creditcard/project_id' , 'QjKnnRPqoec=');
$installer->setConfigData('payment/egovs_girosolution_creditcard/project_pwd', '8GodwH8354OvSQY3fjk3/A==');
$installer->setConfigData('payment/egovs_girosolution_creditcard/title'      , 'Creditcard per Girosolution');

// Giropay per Girosolution
// https://trac.kawatest.de/ticket/2917
$installer->setConfigData('payment/egovs_girosolution_giropay/active'     , '1');
$installer->setConfigData('payment/egovs_girosolution_giropay/merchant_id', 'RiUPLAz1MsQ=');
$installer->setConfigData('payment/egovs_girosolution_giropay/project_id' , 'W2vurCc2P8A=');
$installer->setConfigData('payment/egovs_girosolution_giropay/project_pwd', '8GodwH8354OvSQY3fjk3/A==');
$installer->setConfigData('payment/egovs_girosolution_giropay/title'      , 'Giropay (German online banking accounts only)');

// eMail-Templates korrekt zuweisen
// https://trac.kawatest.de/ticket/2917
$installer->setConfigData('customer/create_account/email_template'             , '5' , 'default', 0);
$installer->setConfigData('customer/create_account/email_confirmation_template', '6' , 'default', 0);
$installer->setConfigData('customer/create_account/email_confirmed_template'   , '7' , 'default', 0);
$installer->setConfigData('customer/password/forgot_email_template'            , '40', 'default', 0);
$installer->setConfigData('customer/password/remind_email_template'            , '59', 'default', 0);

// eMail-Einstellungen anpassen
$email_logos = array(
    0 => array(
        'scope'       => 'default',
        'scope_id'    => '0',
        'default'     => 'sabre_logo_14_mail.png',
        'data'        => array(
            'logo'        => 'logo_email_sabre.png',
            'logo_alt'    => 'Logo sabre 2014',
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
$mailSetup->setEmailConfig($email_logos, implode(DS, array('leipzig', 'default', 'email', 'images')), $installer);
$mailSetup->setEmailTemplates($email_templates, implode(DS, array('leipzig', 'default', 'email', 'templates')), $installer);


$installer->endSetup();