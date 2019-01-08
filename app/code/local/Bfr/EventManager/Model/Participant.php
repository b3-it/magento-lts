<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Participant
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Participant extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventmanager/participant');
    }
    
    
    
    protected function _afterSave()
    {
    	$this->_saveAttribute('industry',Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY);
    	$this->_saveAttribute('lobby',Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY);
    	
    	return parent::_afterSave();
    }
    
    protected function _afterLoad()
    {
    	$this->getResource()->loadAttribute($this, 'industry',Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY);
    	$this->getResource()->loadAttribute($this, 'lobby',Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY);
    	
    	return parent::_afterLoad();
    }
    
    public function copy()
    {
    	$result = Mage::getModel('eventmanager/participant');
    	$result->setData($this->getData());
    	$result->unsetData('participant_id');
    	$result->unsetData('order_id');
    	$result->unsetData('order_item_id');
    	$result->unsetData('created_time');
    	$result->unsetData('update_time');
    	$result->unsetData('status');
    	$result->setIndustry($this->getIndustry());
    	$result->setLobby($this->getLobby());
    	return $result;
    }
    
    protected function _saveAttribute($field, $key)
    {
    	$orig = $this->getResource()->getAttributeValues($this->getId(), $key);
    	$data =  $this->getData($field);
    	
    	if(!is_array($orig)){
    		$orig = array();
    	}
    	
    	if(!is_array($data)){
    		$data = array();
    	}
    	
    	$delete= array_diff($orig,$data);
    	$insert= array_diff($data,$orig);
    	
    	$this->getResource()->deleteAttribute($this->getId(), $delete);
    	$this->getResource()->saveAttribute($this->getId(),$insert);
    	
    	return $this;
    	
    }
    
    /**
     * Daten aus der Bestellung in die Veranstaltundsdatenbank übernehmen
     * @param Mage_Sales_Model_Order $order
     * @param Mage_Sales_Model_Order_Item $orderItem
     * @return Bfr_EventManager_Model_Participant
     */
    public function importOrder($order,$orderItem)
    {
    	$customer = $order->getCustomer();
    	$customer = Mage::getModel('customer/customer')->load($customer->getId());
    
    	$address = Mage::getModel('customer/address')->load($order->getBillingAddress()->getCustomerAddressId());
    	if(!$address){
    		$address = $order->getBillingAddress();
    	}
    	$productOptions = ($orderItem->getProductOptions());
    	$personalOptions = array();
    	if(isset($productOptions['info_buyRequest']['personal_options'])){
    		$personalOptions = $productOptions['info_buyRequest']['personal_options'];
    	}
    	if(!is_array($personalOptions)){
    		$personalOptions = array();
    	}
    	$productId = $orderItem->getProduct()->getId();
    	$event = Mage::getModel('eventmanager/event')->load($productId,'product_id');
    	if(!$event->getId()){
    		return $this;
    	}
    	
    	//zuerst die "Personl" Options aus den Produkt
    	$collection = Mage::getModel('eventbundle/personal_option')->getCollection(); 
    	$collection->getSelect()
    		->where('product_id='.intval($productId));
    	
    	//letztlich sind im mapping alle angelegteten optionen ausgefüllt
    	$mapping = array();
    	foreach($collection->getItems() as $option)
    	{
    		if(isset($personalOptions[$option->getId()]) && (strlen(trim($personalOptions[$option->getId()])) > 0))
    		{
    			$mapping[$option->getName()] = $personalOptions[$option->getId()];
    		}else {
    			//falls die optionen angelegt aber nicht ausgefüllt wurden wird das kundenkonto benutzt 
    			$mapping[$option->getName()] = $customer->getData($option->getName());
    		}
    	}
    	
    	
    	
    	$this->setOrderId($order->getId());
    	$this->setOrderItemId($orderItem->getId());
    	$this->setEventId($event->getId());
    	$this->setCreatedTime(now())->setUpdateTime(now());
    	$fields = array('prefix'=>'getPrefix','academic_titel'=>'getAcademicTitel','position'=>'getPosition',
    			'firstname'=>'getFirstname','lastname'=>'getLastname','company'=>'getCompany','company2'=>'getCompany2',
    			'company3'=>'getCompany3','street'=>'getStreetFull','city'=>'getCity','postcode'=>'getPostcode','email'=>'getEmail',
    			'country'=>'getCountry','phone'=>'getPhone');
    	foreach($fields as $field => $func){
    		//$func = $v.'()';	
    		$customersData = $customer->$func();
    		if(isset($mapping[$field])){
    			$this->setData($field,$mapping[$field]);
    		}elseif (!empty($customersData)) {
    			//falls in mapping nicht vorhanden wird das Kundenkonto benutzt
    			$this->setData($field,$customersData);
    		}else{
    			//falls in mapping nicht vorhanden wird die Adressen benutzt
    			$this->setData($field,$address->$func());
    		}
    	}
    	//übersetzten
    	
    	$translate = Mage::getModel('eventmanager/translate');
    	
    	$translate->translateData($this,$fields, $event->getLangCode());
    	
    	$this->save();
   	
    	
    }
    
    public static function changeStatus($itemIds,$newStatus)
    {
    	$res = Mage::getResourceModel('eventmanager/participant');
    	$res->changeStatus($itemIds,$newStatus);
    	
    	
    }
}
