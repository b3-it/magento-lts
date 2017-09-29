<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

$emailUpdate = array(
    0 => array(
        'id'       => 62,
        'name'     => 'Neue Bestellung / PaperCutDE (Template)',
        'template' => 'de' . DS . 'neue_bestellung_paper_cut.htm'
    ),
    1 => array(
        'id'       => 68,
        'name'     => 'Neue Bestellung / PaperCutEN (Template)',
        'template' => 'en' . DS . 'new_order_paper_cut.htm'
    ),
    2 => array(
        'id'       => 63,
        'name'     => 'Bestellung Aktualsierung / PaperCutDE (Template)',
        'template' => 'de' . DS . 'bestellung_aktualisierung_paper_cut.htm'
    ),
    3 => array(
        'id'       => 69,
        'name'     => 'Bestellung Aktualsierung / PaperCutEN (Template)',
        'template' => 'en' . DS . 'order_update_paper_cut.htm'
    ),
    4 => array(
        'id'       => 64,
        'name'     => 'Neue Rechnung / PaperCutDE (Template)',
        'template' => 'de' . DS . 'neue_rechnung_paper_cut.htm'
    ),
    5 => array(
        'id'       => 70,
        'name'     => 'Neue Rechnung / PaperCutEN (Template)',
        'template' => 'en' . DS . 'new_invoice_paper_cut.htm'
    ),
    6 => array(
        'id'       => 65,
        'name'     => 'Rechnung Aktualisierung / PaperCutDE (Template)',
        'template' => 'de' . DS . 'rechnung_aktualisierung_paper_cut.htm'
    ),
    7 => array(
        'id'       => 71,
        'name'     => 'Rechnung Aktualisierung / PaperCutEN (Template)',
        'template' => 'en' . DS . 'invoice_update_paper_cut.htm'
    ),
    8 => array(
        'id'       => 23,
        'name'     => 'Neue Gutschrift (Template)',
        'template' => 'de' . DS . 'neue_gutschrift.htm'
    ),
    9 => array(
        'id'       => 24,
        'name'     => 'Neue Gutschrift Gast (Template)',
        'template' => 'de' . DS . 'neue_gutschrift_gast.htm'
    ),
    10 => array(
        'id'       => 25,
        'name'     => 'Gutschrift Aktualisierung(Template)',
        'template' => 'de' . DS . 'gutschrift_aktualisierung.htm'
    ),
    11 => array(
        'id'       => 26,
        'name'     => 'Gutschrift Aktualisierung Gast(Template)',
        'template' => 'de' . DS . 'gutschrift_aktualisierung_gast.htm'
    ),
    12 => array(
        'id'       => 50,
        'name'     => 'New Credit Memo (EN)',
        'template' => 'en' . DS . 'new_credit_memo.htm'
    ),
    13 => array(
        'id'       => 56,
        'name'     => 'Credit Memo Update (EN)',
        'template' => 'en' . DS . 'new_credit_memo_update.htm'
    ),
    14 => array(
        'id'       => 73,
        'name'     => 'New Invoice - Ticketshop',
        'template' => 'en' . DS . 'new_invoice_ticketshop.htm'
    ),
);

/* @var $mailSetup Egovs_Base_Helper_Emailsetup_Data */
$mailSetup = Mage::helper('egovsbase_emailsetup');
$mailSetup->updateEmailTemplates($emailUpdate, implode(DS, array('chemnitz', 'default', 'email', 'templates')), $installer);

$installer->endSetup();