<?php
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getOrderId()
 *  @method setOrderId(int $value)
 *  @method string getOrderIncrementId()
 *  @method setOrderIncrementId(string $value)
 *  @method int getOrderItemId()
 *  @method setOrderItemId(int $value)
 *  @method  getCreatedAt()
 *  @method setCreatedAt( $value)
 *  @method  getUpdatedAt()
 *  @method setUpdatedAt( $value)
 *  @method string getProductName()
 *  @method setProductName(string $value)
 *  @method string getProductSku()
 *  @method setProductSku(string $value)
 *  @method string getBaseUrl()
 *  @method setBaseUrl(string $value)
 *  @method string getOracleAccountId()
 *  @method setOracleAccountId(string $value)
 *  @method int getStatus()
 *  @method setStatus(int $value)
 *  @method int getSyncStatus()
 *  @method setSyncStatus(int $value)
 *  @method int getCustomerId()
 *  @method setCustomerId(int $value)
 */
class Bkg_VirtualAccess_Model_Purchased extends Mage_Core_Model_Abstract
{
	
	

	protected $_customer = null;
	protected $_order = null;
	protected $_credentials = null;

	/**
	 * Initialize resource model
	 *
	 */
	protected function _construct()
	{
		$this->_init('virtualaccess/purchased');
		parent::_construct();
	}
	
	public function sync()
	{
		//zum testen:
		$this->_newAccount();
		
		
		
		
		
		
		if($this->getSyncStatus() == Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_PERMANENTERROR){
			return;
		}
		switch ($this->getStatus())
		{
			case Bkg_VirtualAccess_Model_Service_AccountStatus::ACCOUNTSTATUS_NEW:
				$this->_newAccount();
				break;
			
			case Bkg_VirtualAccess_Model_Service_AccountStatus::ACCOUNTSTATUS_STORNO:
				break;
		}
		
		return $this;
	}
	
	protected function _newAccount()
	{
		/** @var $service Bkg_VirtualAccess_Model_Service_Account */ 
		$service = Mage::getModel('virtualaccess/service_account');
		
		try {
			$data = array();
			$data['sku'] = $this->getProductSku();
			$data['product_code'] = $this->getProductCode();
			$data['customer'] = 
			
			$account_id = $service->create($this);
			$this->setOracleAccountId($account_id)
				->setSyncStatus(Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_SUCCESS)
				->setStatus(Bkg_VirtualAccess_Model_Service_AccountStatus::ACCOUNTSTATUS_ACTIVE)
				->save();
			$this->setLog(sprintf('getting new account_id: %s',$account_id));
			$this->_log('SUCSESS', sprintf('getting new account_id: %s',$account_id));
		}
		catch(Exception $e){
			$this->_log('ERROR', sprintf('Error: %s',$e->getMessage()));
			
			if($this->getSyncStatus() == Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_ERROR)
			{
				$this->setSyncStatus(Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_PERMANENTERROR)->save();
			}else{
				$this->setSyncStatus(Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_ERROR)->save();
			}
			
			
		}
		
	}

	/**
	 * 
	 * @return Mage_Customer_Model_Customer
	 */
	public function getCustomer()
	{
		if($this->_customer == null){
			$this->_customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
		}
		
		return $this->_customer;
	}
	
	/**
	 *
	 * @return Mage_Sales_Model_Order
	 */
	public function getOrder()
	{
		if($this->_order == null){
			$this->_order = Mage::getModel('sales/order')->load($this->getCustomerId());
		}
	
		return $this->_order;
	}
	
    public function getCredentials()
    {
        if($this->_credentials == null)
        {
            /** @var $service Bkg_VirtualAccess_Model_Service_Account */
            $service = Mage::getModel('virtualaccess/service_account');

            try
            {
                $this->_credentials = $service->getCredentials($this->getOracleAccountId());
            }
            catch(Exception $e) {
                Mage::logException($e);
                $this->_log('ERROR', sprintf('Error: %s', $e->getMessage()));
                $this->_credentials = array();
            }
        }

        return $this->_credentials;
    }

	protected function _log($status,$msg)
	{
		$log = Mage::getModel('virtualaccess/service_log');
		$log->setStatus($status)
			->setMessage($msg)
			->setPurchasedId($this->getId())
			->save();
	}
	
	
	
	
}