<?php
/**
 * 
 *  Rahmenverträge für IT Warenhaus
 *  @category Egovs
 *  @package  Sid_Framecontract_Model_Contract
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 *  @method int getFramecontractContractId()
 *  @method setFramecontractContractId(int $value)
 *  @method string getTitle()
 *  @method setTitle(string $value)
 *  @method int getFramecontractVendorId()
 *  @method setFramecontractVendorId(int $value)
 *  @method string getOperator()
 *  @method setOperator(string $value)
 *  @method string getOrderEmail()
 *  @method setOrderEmail(string $value)
 *  @method string getFilename()
 *  @method setFilename(string $value)
 *  @method string getContent()
 *  @method setContent(string $value)
 *  @method int getStatus()
 *  @method setStatus(int $value)
 *  @method  getStartDate()
 *  @method setStartDate( $value)
 *  @method  getEndDate()
 *  @method setEndDate( $value)
 *  @method  getCreatedTime()
 *  @method setCreatedTime( $value)
 *  @method  getUpdateTime()
 *  @method setUpdateTime( $value)
 *  @method string getContractnumber()
 *  @method setContractnumber(string $value)
 *  @method int getStoreId()
 *  @method setStoreId(int $value)
*/
class Sid_Framecontract_Model_Contract extends Mage_Core_Model_Abstract
{
	

	/**
	 * Prefix of model events names
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'framecontract_contract';
	
	/**
	 * Parameter name in event
	 *
	 * In observe method you can use $observer->getEvent()->getObject() in this case
	 *
	 * @var string
	 */
	protected $_eventObject = 'object';
	
	private $_vendor = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/contract');
    }
    
   	protected function _beforeDelete()
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
    	if(($old != $neu) && ($neu == Sid_Framecontract_Model_Status::STATUS_DISABLED)){
    		$this->alterLosStatus($neu);
    	}
    }
    
    public function alterLosStatus($status)
    {
    	$collection = Mage::getModel('framecontract/los')->getCollection();
    	$collection->getSelect()->where('framecontract_contract_id = '. intval($this->getId()));
    	
    	foreach($collection->getItems() as $los)
    	{
    		if($los->getStatus() != $status){
    			$los->setStatus($status)
    				->save();
    		}
    	}
    }
    
    
    public function getVendor()
    {
    	if($this->_vendor == null)
    	{
    		$this->_vendor = Mage::getModel('framecontract/vendor')->load($this->getFramecontractVendorId());
    	}
    	
    	return $this->_vendor;
    }
    
    /**
     * ermitteln aller ProduktId's die mit diesem Los verbunden sind
     */
    public function getProductIds()
    {
    	return $this->getResource()->getProductIds($this);
    }
    
  

    
}