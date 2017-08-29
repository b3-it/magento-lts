<?php
/**
 * 
 *  Abfangen der Bestellung und speichern der Anmeldedaten
 *  @category Egovs
 *  @package  Bfr_EventManager_Model_Observer
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Observer extends Varien_Object
{
	

	public function onCheckoutSubmitAllAfter($observer)
	{
		$order = $observer->getOrder();
		
		foreach($order->getAllItems() as $item)
		{
			$product= $item->getProduct();
			if($product->getTypeId() == Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE){
				Mage::getModel('eventmanager/participant')->importOrder($order,$item);
			}	
		}
		
	}


    
    public function getStoreId()
    {
          return Mage::app()->getStore()->getId();
    }
 
    /**
     * Bei nueanlegen eines Eventbundles automatisch ein neues Event erzeugen
     * @param Bfr_EventManager_Model_Observer $observer
     * @return Bfr_EventManager_Model_Observer
     */
    public function onEventbundleCreateAfter($observer)
    {
    	$product = $observer->getEvent()->getProduct();
    	if($product->getTypeId() != Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE)
    	{
    		return $this;
    	}
    
    	$collection = Mage::getModel('eventmanager/event')->getCollection();
    	$collection->getSelect()->where('product_id ='.$product->getId());
    	if(count($collection->getItems()) === 0)
    	{
    		$event =  Mage::getModel('eventmanager/event');
    		$event->setTitle($product->getName())
    			->setProductId($product->getId())
    			->setCreatedTime(now())
    			->setUpdateTime(now())
    			->save();
    	}
    }
    
    
    public function onAddressFormInitAfter($observer)
    {
    	$form = $observer->getForm();
    	$customerStoreId = $observer->getCustomerStoreId();
    	$fieldset = $form->getElement('address_fieldset');
    	$prefixElement = $form->getElement('academic_titel');
    	if ($prefixElement) {
    		//$prefixOptions = $this->helper('customer')->getNamePrefixOptions($customerStoreId);
    		$prefixOptions = Mage::helper('customer')->getAcademicTitleOptions($customerStoreId);
    		if (!empty($prefixOptions)) {
    			$fieldset->removeField($prefixElement->getId());
    			$prefixField = $fieldset->addField($prefixElement->getId(),
    					'select',
    					$prefixElement->getData(),
    					'^'
    			);
    			$prefixField->setValues($prefixOptions);
    		}
    	}
    	 
    }
}