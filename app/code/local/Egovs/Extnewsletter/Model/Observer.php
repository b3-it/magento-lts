<?php

class Egovs_Extnewsletter_Model_Observer extends Mage_Core_Model_Abstract 
{
    
	public function onMPCheckoutSave($observer)
	{
		$products = $observer->getData('products');
		$email = $observer->getData('email');
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
	 * Hinzufügen der Temennewsletter zur Bestellungengrid Massenaktion
	 * @param unknown $observer
	 */
	public function onSalesOrderGridMassaction($observer)
	{
		$url =  Mage::getModel('core/url')->getUrl('extnewsletter/adminhtml_issue/massaction4orders');
		
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
	 * Hinzufügen der Temennewsletter zur Kundengrid Massenaktion
	 * @param unknown $observer
	 */
	public function onCustomerGridMassaction($observer)
	{
		$url =  Mage::getModel('core/url')->getUrl('extnewsletter/adminhtml_issue/massaction4customers');
		
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