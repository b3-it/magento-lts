<?php
/**
 * 
 *  Setup/Helper zum Einfügen der Daten der Komponenten
 *  @category Egovs
 *  @package  Bkg_VirtualGeo_Model_Resource_Setup
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
 class Bkg_VirtualGeo_Model_Resource_Setup extends Mage_Catalog_Model_Resource_Setup 
 {

 	public function addStoreView()
 	{
 		$collection = Mage::getModel('core/store')->getCollection();
 		if(count($collection->getItems()) < 2)
 		{
 			$store = Mage::getModel('core/store');
 			$store->setGroupId('1')
 			->setName('English')
 			->setCode('engl')
 			->setWebsiteId(1)
 			->save();
 		}
 		
 	}
 	
 	public function getRowValue($row, $idx)
 	{
 		if(isset($row[$idx])){
 			return $row[$idx];
 		}
 		
 		return "";
 	}
 	

 	public function addCategory($label)
    {
        $cat = Mage::getModel('virtualgeo/components_content_category');
        $cat->setLabel($label)->save();
        return $cat;
    }

 } 