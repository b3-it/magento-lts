<?php

class Slpb_Verteiler_Model_Order_Create extends Mage_Core_Model_Abstract
{
 	protected $_items = array();

 	public function addItem($id)
 	{
 		$id = intval($id);
 		if(isset($this->_items[$id]))
 		{
 			$this->_items[$id] = $this->_items[$id] + 1;
 		}
 		else 
 		{
 			$this->_items[$id] = 1;
 		}
 	}
 	
 	
 	public function changeItem($id,$qty)
 	{
 		$id = intval($id);
 		if(isset($this->_items[$id]))
 		{
 			$this->_items[$id] = $qty;
 		}
 		else 
 		{
 			$this->_items[$id] = 1;
 		}
 		if($this->_items[$id] == 0)
 		{
 			$this->removeItem($id);
 		}
 	}
 	
 	public function removeItem($id)
 	{
		$id = intval($id);
		$tmp = array();
		foreach ($this->_items as $key => $value)
		{
			if($key != $id)
			{
				$tmp[$key] = $value;
			}
		}
		$this->_items = $tmp;
 	}
 	
 	public function getItems()
 	{
 		$items = array();
 		if(count($this->_items)	>	0)
 		{
	 		$collection = Mage::getModel('catalog/product')->getCollection();
	 		$collection->addAttributeToSelect('name');
	 		
	 		$ids = implode(',',array_keys($this->_items));
	 		$collection->getSelect()->where('entity_id in ('.$ids.')',$ids);
	 		$items = $collection->getItems();
 		}
 		
 		
 		foreach ($items as $item)
 		{
 			$item->setQty($this->_items[$item->getId()]);
 		}
 		
 		
 		
 		return $items;
 	}
 	
 	
		
}