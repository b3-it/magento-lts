<?php
/**
 * Installer
 *
 * @category        Egovs
 * @package			Egovs_Ready
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
/** @var $installer Egovs_Ready_Model_Setup */
$installer = $this;
$installer->startSetup();

$agreements = array();
$blocks = array();
$pages = array();

// AGREEMENTS
$agreements[] = array(
		'name' => 'AGB',
		'content' => "<a href='{{store url='agb'}}' target=\"_blank\">lesen Sie hier unsere AGB's</a>",
		'checkbox_text' => 'Ich habe die Allgemeinen Geschäftsbedingungen gelesen und stimme diesen ausdrücklich zu.'
);

$agreements[] = array(
		'name' => 'Widerrufsbelehrung',
		'content' => "<a href='{{store url='widerruf'}}' target=\"_blank\">lesen Sie hier unsere Widerrufsbedingungen</a>",
		'checkbox_text' => 'Ich habe die Widerrufsbelehrung gelesen.'
);

foreach ($agreements as $agreement) {
	$installer->createAgreement($agreement);
}

$installer->endSetup();