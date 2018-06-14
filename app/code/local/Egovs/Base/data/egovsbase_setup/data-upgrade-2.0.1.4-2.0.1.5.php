<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();


$cms_block = array(
                'title'      => 'Hinweis zur Cookie-Beschränkung',
                'identifier' => 'cookie_restriction_notice_block',
                'content'    => '<p>Diese Website benötigt Cookies, um alle Funktionen anbieten zu können.
Weitere Informationen darüber, welche Daten in den Cookies enthalten sind, finden Sie in unserem <a href="{{store direct_url="privacy-policy-cookie-restriction-mode"}}">Allgemeine Datenschutzerklärungen</a>.
Um Cookies von dieser Seite zu akzeptieren, klicken Sie bitte auf die Schaltfläche <b>Erlauben</b>.</p>',
                'is_active'     => 1,
                'stores'        => array(0)
            );

$block = Mage::getModel('cms/block');
$block->load($cms_block['identifier'], 'identifier');
if ( $block->getId() ) {
    $block->setTitle($cms_block['title'])
          ->setContent($cms_block['content'])
          ->save();
}
else {
    $block->setData($cms_block)
          ->save();
}

$installer->endSetup();
