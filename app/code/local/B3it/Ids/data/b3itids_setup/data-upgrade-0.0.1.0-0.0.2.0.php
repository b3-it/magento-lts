<?php
/**
  *
  * @category   	Bkg
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

/** @var $this Bkg_VirtualGeo_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();


    $object = Mage::getModel('b3it_ids/dos_url');
    $object
        ->setUrl('/customer/account/createpost/')
        ->setDelay(5)
        ->save();
    $object = Mage::getModel('b3it_ids/dos_url');
    $object
        ->setUrl('/customer/account/loginPost/')
        ->setDelay(5)
        ->save();




$installer->endSetup();