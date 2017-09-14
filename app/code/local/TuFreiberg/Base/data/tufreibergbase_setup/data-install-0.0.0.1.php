<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$cfgTable   = $installer->getTable('core/config_data');
$emailTable = $installer->getTable('core/email_template');

$localPath = 'email' . DS . 'images';
$skinPath  = Mage::getBaseDir('skin') . DS . 'frontend' . DS . 'freiberg' . DS . 'default';
$mediaPath = Mage::getBaseDir('media');

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
        'scope'       => 'website',
        'scope_id'    => '3',
        'default'     => 'email_iep_default.png',
        'data'        => array(
            'logo'        => 'kategorie_2016.png',
            'logo_alt'    => 'Logo tubaf allgemein',
            'logo_width'  => '920',
            'logo_height' => '190',
        )
    ),
    2 => array(
        'scope'       => 'website',
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

foreach($email_logos AS $key => $entry) {
    foreach($entry['data'] AS $path => $value) {
        $path = 'design/email/' . $path;
        $logo_to = $logo_from = '';
        
        if ( $path == 'design/email/logo' ) {
            if ( $entry['scope'] == 'default' ) {
                $value = $entry['scope'] . '/' . $value;
            }
            else {
                $value = $entry['scope'] . '/' . $entry['scope_id'] . '/' . $value;
            }
            
            // Pfade zur LOGO-Dateien
            $logo_to   = $mediaPath . DS . $localPath . DS . $value;
            $logo_from = $skinPath . DS . 'images' . DS . 'email_default' . DS . $entry['default'];
        }

        $id = $this->getConnection()->fetchOne("SELECT `config_id` FROM `{$cfgTable}` WHERE `path` = '{$path}' AND " .
                                               "`scope` = '{$entry['scope']}' AND `scope_id` = '{$entry['scope_id']}';");
        
        if (!$id) {
            // Eintrag nicht vorhanden => Anlegen
            $installer->run("INSERT INTO `{$cfgTable}` (`scope`, `scope_id`, `path`, `value`)" .
                            "VALUES ('{$entry['scope']}', '{$entry['scope_id']}', '{$path}', '{$value}');");
        }
        else {
            // Eintrag vorhanden => Update
            $installer->run("UPDATE `{$cfgTable}` SET `value` = '{$value}' WHERE `config_id` = '{$id}'");
        }
        
        // Wenn es die LOGO-Datei ist, ....
        if ( strlen($logo_to) ) {
            // Ziel-Pfad ist nicht da => anlegen
            if ( !is_dir(dirname($logo_to)) ) {
                mkdir(dirname($logo_to), 0750, TRUE);
            }

            // Die Datei existiert nicht => kopieren
            if ( !is_file($logo_to) ) {
                copy($logo_from, $logo_to);
            }
        }   
    }
}


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

foreach($email_templates AS $key => $entry) {
    $id = $this->getConnection()->fetchOne("SELECT `template_id` FROM `{$emailTable}` WHERE `template_code` = '{$entry['name']}'");
    
    if (!$id) {
        $content  = file_get_contents($skinPath . DS . 'email' . DS . 'templates' . DS . $entry['template']);
        $template = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
        
        $installer->run("INSERT INTO `{$emailTable}` (`template_code`, `template_text`, `template_type`, `template_subject`) " .
                        "VALUES ('{$entry['name']}', '{$template}', '2', '{$entry['topic']}');");
        
        $id = $this->getConnection()->fetchOne("SELECT `template_id` FROM `{$emailTable}` WHERE `template_code` = '{$entry['name']}'");
        $installer->setConfigData($entry['path'], $id);
    }
}


$installer->endSetup();