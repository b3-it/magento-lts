<?php
/**
 *  Persistenzklasse für ConfigCompare
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_ConfigCompare_Model_ConfigCompare extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('configcompare/configCompare');
    }
    
    public function import($importXML)
    {
    	$this->getResource()->deleteAll();
    	if($importXML)
    	{
    		foreach($importXML as $xmlItem)
    		{
    			$item = Mage::getModel('configcompare/configCompare');
    			$item->setType($xmlItem->getName());
    			$item->setValue($xmlItem->asXML());
    			$item->save();
    		}
    	}
    }
}