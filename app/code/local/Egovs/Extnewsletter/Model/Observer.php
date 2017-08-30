<?php

class Egovs_Extnewsletter_Model_Observer extends Mage_Core_Model_Abstract 
{
    
	
	public function onCheckoutSaveOrderAfter($observer)
	{
		$order = $observer->getOrder();
		if(!$order) return $this;
		
		$products = array();
		if(Mage::getStoreConfigFlag('newsletter/subscription/auto_subscribe_newsletter'))
		{
			$products[] = 0;
		}
		if(Mage::getStoreConfig('newsletter/subscription/auto_subscribe_for_product'))
		{
			foreach($order->getAllItems() as $item)
			{
				if($item->getProduct()->getExtnewsletter())
				{
					$products[] = $item->getProduct()->getId();
				}
			}	
		}	
		$email = $order->getCustomer()->getData('email');
		Mage::getModel('extnewsletter/subscriber')->subscribeWithOptions($email,$products);
	}
	
	
	
	private function _deletePrevious($queueid)
	{
		$resource = Mage::getSingleton('core/resource');
		$conn= $resource->getConnection('core_write');
		$extTable = $resource->getTableName('extnewsletter_queue_product');
		
		$sql = "DELETE FROM " .$extTable ." WHERE queue_id=".$queueid;
		$result = $conn->query($sql);
		
	}
	
	/**
	 * Hinzufügen der Themennewsletter zur Bestellungengrid Massenaktion
	 * @param Egovs_Extnewsletter_Model_Observer $observer
	 */
	public function onSalesOrderGridMassaction($observer)
	{
		$url =  Mage::getModel('core/url')->getUrl('adminhtml/extnewsletter_issue/massaction4orders');
		
		$issues = array();
		$collection = Mage::getModel('extnewsletter/issue')->getCollection();
		foreach($collection->getItems() as $item)
		{
			$issues[$item->getId()] = $item->getTitle();
		}
		
		$mblock = $observer->getMassactionBlock();
		$mblock->addItem('newsletter_issue', array(
				'label'=> Mage::helper('sales')->__('Subscribe to Newsletter Issue'),
				'url'  => $url,
				'additional' => array(
						'visibility' => array(
								'name' => 'issue_id',
								'type' => 'select',
								'class' => 'required-entry',
								'label' => Mage::helper('extnewsletter')->__('Issue'),
								'values' => $issues
						)
				)
		));
	}
	
	
	
	/**
	 * Hinzufügen der Themennewsletter zur Kundengrid Massenaktion
	 * @param Egovs_Extnewsletter_Model_Observer $observer
	 */
	public function onCustomerGridMassaction($observer)
	{
		$url =  Mage::getModel('core/url')->getUrl('adminhtml/extnewsletter_issue/massaction4customers');
		
		$issues = array();
		$collection = Mage::getModel('extnewsletter/issue')->getCollection();
		foreach($collection->getItems() as $item)
		{
			$issues[$item->getId()] = $item->getTitle();
		}
		
		$mblock = $observer->getMassactionBlock();
		$mblock->addItem('newsletter_issue', array(
				'label'=> Mage::helper('sales')->__('Subscribe to Newsletter Issue'),
				'url'  => $url,
				'additional' => array(
						'visibility' => array(
								'name' => 'issue_id',
								'type' => 'select',
								'class' => 'required-entry',
								'label' => Mage::helper('extnewsletter')->__('Issue'),
								'values' => $issues
						)
				)
		));
	}
	
}