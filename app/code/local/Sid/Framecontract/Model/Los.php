<?php

/**
 * die Lose zum Rahmenvertrag
 * @author h.koegel
 *
 */

/**
 *  @method int getLosId()
 *  @method setLosId(int $value)
 *  @method int getFramecontractContractId()
 *  @method setFramecontractContractId(int $value)
 *  @method string getTitle()
 *  @method setTitle(string $value)
 *  @method string getNote()
 *  @method setNote(string $value)
 *  @method int getStatus()
 *  @method setStatus(int $value)
 *  @method string getKey()
 *  @method setKey(string $value)
 *  @method int getLinkValidTo()
 *  @method setLinkValidTo(int $value)
 *  @method  getLinkValidToModified()
 *  @method setLinkValidToModified( $value)
 */
class Sid_Framecontract_Model_Los extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/los');
    }
    
   	protected function xx_beforeDelete()
    {
    	//files müssen explized gelscht werden damit das dateisystem gesaubert wird
    	$collection = Mage::getModel('framecontract/files')->getCollection();
      	$collection->getSelect()->where('framecontract_contract_id='. intval($this->getId()));
    	
      	foreach ($collection->getItems() as $item)
      	{
      		$item->delete();
      	}
      	
    	
    	return parent::_beforeDelete();
    }
    
    protected function _afterSave(){
    	$old = $this->getOrigData('status');
    	$neu = $this->getData('status');
    	
    	//alle Produkte deaktivieren falls los deaktivert
    	if($old != $neu){
    		$productIds = $this->getProductIds();
    		$this->alterProductStatus($productIds, $neu);
    	}
    }
    
    
    /**
     * ermitteln aller ProduktId's die mit diesem Los verbunden sind
     */
    public function getProductIds()
    {
    	return $this->getResource()->getProductIds($this);
    }
    
    
    /*
     * setzt den Status für Produkte mit den angegebenen Id's
     */
    public function alterProductStatus($productIds, $status)
    {
    	//status vom los auf produktstatus umschreiben - falls unterschiedlich
    	if ($status == Sid_Framecontract_Model_Status::STATUS_ENABLED){
    		$status = Mage_Catalog_Model_Product_Status::STATUS_ENABLED;
    	}
    	elseif ($status == Sid_Framecontract_Model_Status::STATUS_DISABLED){
    		$status = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
    	}
    	
    	//für alle Produkte setzen
    	if(count($productIds) > 0){
    		Mage::getSingleton('catalog/product_action')
    		->updateAttributes($productIds, array('status' => $status), 0);
    	}
    	
    }
    
    public function loadByProductId($productId)
    {
    	$this->_getResource()->loadByProductId($this,$productId);
    	$this->_afterLoad();
    	$this->setOrigData();
    	$this->_hasDataChanges = false;
    	return $this;
    	 
    }
    
    /**
     * für die verschiedenen select Boxen eine eindeutiges Label
     */
    public function getOptionsLabel()
    {
    	return sprintf('%s (Id: %s)',$this->getTitle(),$this->getId());
    }
    
    
    public function getFramecontract()
    {
    	return Mage::getModel('framecontract/contract')->load($this->getFramecontractContractId());
    }
}