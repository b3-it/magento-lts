<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

$pdf_logos = array(
    0 => array(
        'scope'       => 'default',
        'scope_id'    => '0',
        'destination' => 'tuc_logo_rechnung.png',
        'source'      => 'tuc_logo_rechnung.png',
    ),
    1 => array(
        'scope'       => 'stores',
        'scope_id'    => '1',
        'destination' => 'tuc_logo_invoice.png',
        'source'      => 'tuc_logo_invoice.png',
    ),
    2 => array(
        'scope'       => 'stores',
        'scope_id'    => '3',
        'destination' => 'tuc_logo_rechnung.png',
        'source'      => 'tuc_logo_rechnung.png',
    ),
    3 => array(
        'scope'       => 'stores',
        'scope_id'    => '4',
        'destination' => 'tuc_logo_invoice.png',
        'source'      => 'tuc_logo_invoice.png',
    ),
);

/* @var $pdfSetup Egovs_Base_Helper_Pdfsetup_Data */
$pdfSetup = Mage::helper('egovsbase_pdfsetup');

$pdfSetup->setPdfConfig($pdf_logos, implode(DS, array('chemnitz', 'default', 'pdf', 'images')), $installer);

$installer->endSetup();