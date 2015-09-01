<?php

class Stala_Abo_Model_Create extends Mage_Core_Model_Abstract
{
 	protected $_items = array();

 	public function addItem($id)
 	{
 		$id = intval($id);
 		if(isset($this->_items[$id]))
 		{
 			$this->_items[$id]->setQty($this->_items[$id]->getQty() + 1);
 		}
 		else 
 		{
 			$obj = new Varien_Object();
 			$obj->setQty(1);
 			$obj->setId($id);
 			$this->_items[$id] = $obj;
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
 	
 	public function setItems($items = array())
 	{
 		$this->_items = $items;
 	}
 	
 	public function getItems()
 	{
 		$items = array();
 		if(count($this->_items)	>	0)
 		{
	 		$collection = Mage::getModel('catalog/product')->getCollection();
	 		$collection->addAttributeToSelect('name');
	 		
	 		$ids = implode(',',array_keys($this->_items));
	 		$collection->getSelect()->where('entity_id in ('.$ids.')');
	 		$items = $collection->getItems();
 		}
 		
 		
 		foreach ($items as $item)
 		{
 			$tmp = $item->getId();
 			if(isset($this->_items[$tmp]))
 			{
 				$tmp = $this->_items[$tmp];
 				$item->setQty($tmp->getQty());
 			}
 			else 
 			{
 				$item->setQty(1);
 			}
 		}
 		
 		$this->_items = $items;
 		
 		return $items;
 	}
 	
 	
		
}