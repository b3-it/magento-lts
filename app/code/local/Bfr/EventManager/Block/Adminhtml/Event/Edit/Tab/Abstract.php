<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Participant_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Abstract extends Mage_Adminhtml_Block_Widget_Grid
{
 
  private $selctions = null; 	
  
  protected function getEvent()
  {
  	return Mage::registry('event_data');
  }
  
  protected function getSelections()
  {
  	if($this->selctions == null)
  	{
  		
  		$collection = Mage::getModel('bundle/selection')->getCollection();
  		$collection->getSelect()
  			->where('parent_product_id='.$this->getEvent()->getProductId());		
  		
  		$this->selctions = array();
  		foreach($collection->getItems() as $item)
  		{
  			$this->selctions[] = Mage::getModel('catalog/product')->load($item->getProductId());
  		}
  	}
  		
  	return $this->selctions;
  }
  
  protected function getSoldProductsIds($parentOrderItemId)
  {
  		$res = array();
  		if($parentOrderItemId){
	  		$collection = Mage::getModel('sales/order_item')->getCollection();
	  		$collection->getSelect()->where('parent_item_id = '. $parentOrderItemId);
	  		
	  		
	  		foreach($collection->getItems() as $item)
	  		{
	  			$res[] = $item->getProductId();
	  		}
  		}
  		return $res;
  } 
  
 
}
