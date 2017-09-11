<?php
/**
 * 
 *  Hinzufügen von Massenaktionen in Grids für Infoletter
 *  @category Egovs
 *  @package  Egovs_Infoletter
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Infoletter_Model_Observer extends Mage_Core_Model_Abstract
{

		/**
		 * Hinzufügen der Infoletter zur Kundengrid Massenaktion
		 * @param Varien_Event_Observer $observer Observer
		 */
		public function onCustomerGridMassaction($observer)
		{
			$url =  Mage::getModel('core/url')->getUrl('adminhtml/infoletter_inject/massaction4customers');
		
			$issues = $this->_getQueueCollection();
		
			if(count($issues) > 0)
			{
				$mblock = $observer->getMassactionBlock();
				$mblock->addItem('infoletter_queue', array(
						'label'=> Mage::helper('infoletter')->__('Add to Infoletter'),
						'url'  => $url,
						'additional' => array(
								'visibility' => array(
										'name' => 'queue_id',
										'type' => 'select',
										'class' => 'required-entry',
										'label' => Mage::helper('infoletter')->__('Queue'),
										'values' => $issues
								)
						)
				));
			}
		}
		
		
		/**
		 * Hinzufügen der Infoletter zur Bestellungengrid Massenaktion
		 * @param Varien_Event_Observer $observer Observer
		 */
		public function onSalesOrderGridMassaction($observer)
		{
			$url =  Mage::getModel('core/url')->getUrl('adminhtml/infoletter_inject/massaction4orders');
		
			$issues = $this->_getQueueCollection();
			
			if(count($issues) > 0)
			{
		
				$mblock = $observer->getMassactionBlock();
				$mblock->addItem('infoletter_queue', array(
						'label'=> Mage::helper('infoletter')->__('Add to Infoletter'),
						'url'  => $url,
						'additional' => array(
								'visibility' => array(
										'name' => 'queue_id',
										'type' => 'select',
										'class' => 'required-entry',
										'label' => Mage::helper('infoletter')->__('Queue'),
										'values' => $issues
								)
						)
				));
			}
		}
		
		
		
		public function onSalesOrderItemGridMassaction($observer)
		{
			$url =  Mage::getModel('core/url')->getUrl('adminhtml/infoletter_inject/massaction4orderitems');
		
			$issues = $this->_getQueueCollection();
			
			if(count($issues) > 0)
			{
		
				$mblock = $observer->getMassactionBlock();
				$mblock->addItem('infoletter_queue', array(
						'label'=> Mage::helper('infoletter')->__('Add to Infoletter'),
						'url'  => $url,
						'additional' => array(
								'visibility' => array(
										'name' => 'queue_id',
										'type' => 'select',
										'class' => 'required-entry',
										'label' => Mage::helper('infoletter')->__('Queue'),
										'values' => $issues
								)
						)
				));
			}
		}
		
		
		private function _getQueueCollection()
		{
			$collection = Mage::getModel('infoletter/queue')->getCollection();
			$collection->getSelect()->where('status='.Egovs_Infoletter_Model_Status::STATUS_NEW);
			$issues = array();
			foreach($collection->getItems() as $item)
			{
				$issues[$item->getId()] = $item->getTitle();
			}
			
			return $issues ;
		}
		
}