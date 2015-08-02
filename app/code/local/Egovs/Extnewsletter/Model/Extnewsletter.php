<?php

class Egovs_Extnewsletter_Model_Extnewsletter extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('extnewsletter/extnewsletter');
    }
    
    public function loadByIdAndProduct($subsciberId,$productId)
    {
    	$this->addData($this->getResource()->loadByIdAndProduct($subsciberId,$productId));
        return $this;
    }
    
    /*
     * Alle Produkte ermitteln f�r die ein Kunden abonniert ist
     */
    public function getSubscribedProductsForSubscriber($subscriberid)
    {
    	$collection = $this
		->getCollection()
		->addProductInfoToQuerry()
		->addSubscriberId($subscriberid)
		->addOnlyActiveProductsFilter();
		//die($collection->getSelect()->__toString());		
		return $collection->getItems();
    }
}