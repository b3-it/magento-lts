<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$email_logos = array(
    0 => array(
        'scope'       => 'default',
        'scope_id'    => '0',
        'default'     => 'email_logo_default.png',
        'data'        => array(
            'logo'        => 'logo_email_allgemein.png',
            'logo_alt'    => 'Logo tubaf allgemein',
            'logo_width'  => '920',
            'logo_height' => '104',
        )
    ),
    1 => array(
        'scope'       => 'websites',
        'scope_id'    => '3',
        'default'     => 'email_iep_default.png',
        'data'        => array(
            'logo'        => 'iep_kategorie_2016.png',
            'logo_alt'    => 'Logo tubaf allgemein',
            'logo_width'  => '920',
            'logo_height' => '190',
        )
    ),
    2 => array(
        'scope'       => 'websites',
        'scope_id'    => '4',
        'default'     => 'email_ibs_default.png',
        'data'        => array(
            'logo'        => 'ibs_kategorie_2016.png',
            'logo_alt'    => 'Logo IBS 2016',
            'logo_width'  => '920',
            'logo_height' => '164',
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
        'template' => 'footer.htm',
        'name'     => 'eMail-Footer',
        'topic'    => 'E-Mail - Fußzeile',
        'path'     => 'design/email/support'
    ),
);



/* @var $mailSetup Egovs_Base_Helper_Emailsetup_Data */
$mailSetup = Mage::helper('egovsbase_emailsetup');
$mailSetup->setEmailConfig($email_logos, implode(DS, array('freiberg', 'default', 'email', 'images')), $installer);
$mailSetup->setEmailTemplates($email_templates, implode(DS, array('freiberg', 'default', 'email', 'templates')), $installer);


$installer->endSetup();