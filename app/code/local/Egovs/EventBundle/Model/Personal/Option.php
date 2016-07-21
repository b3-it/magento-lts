<?php
/**
 * Egovs EventBundle
 *
 *
 * @category   	Egovs
 * @package    	Egovs_EventBundle
 * @name       	Egovs_EventBundle_Model_PersonalOption
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Model_Personal_Option extends Mage_Core_Model_Abstract
{
	private $store_id = 0;
	private $option_label = null;
	
	private $all_option_labels = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventbundle/personal_option');
    }
    
    
	public function getStoreId() 
	{
	  return $this->store_id;
	}
	
	public function setStoreId($value) 
	{
	  $this->store_id = $value;
	}
	
	private function getOptionLabel($fallback = false)
	{

		foreach($this->getAllOptionLabels() as $label)
		{
			if($label->getStoreId() == $this->getStoreId())
			{
				return $label;
			}
		}
		if($fallback)
		{
			foreach($this->getAllOptionLabels() as $label)
			{
				if($label->getStoreId() == 0)
				{
					return $label;
				}
			}
		}
		
		$label = Mage::getModel('eventbundle/personal_optionLabel');
		$label->setStoreId( $this->getStoreId());
		if($this->all_option_labels == null) $this->all_option_labels = array();
		$this->all_option_labels[] = $label;
		
		return $label;
		
	}
	
	public function getAllOptionLabels()
	{
		if($this->all_option_labels == null)
		{
			$collection = Mage::getModel('eventbundle/personal_optionLabel')->getCollection();
			$collection->getSelect()->where('option_id='.intval($this->getId()));
			$this->all_option_labels = $collection->getItems();
		}
	
		return $this->all_option_labels;
	}
	
	public function setAllOptionLabels($labels)
	{
		$this->all_option_labels = $labels;
		return $this;
	}
	
	public function getLabel($fallback = false)
	{
		return $this->getOptionLabel($fallback)->getLabel();
	}
	
	public function setLabel($label)
	{
		return $this->getOptionLabel()->setLabel($label);
	}
	
	protected function _afterSave()
	{		
		foreach($this->getAllOptionLabels() as $label)
		{
			$label->setOptionId($this->getId());
			$label->save();
		}
		
		return parent::_afterSave();
	}
	
	protected function _afterLoad()
	{
		$this->getAllOptionLabels();
	}
	
	public function toJson(array $arrAttributes = array())
	{
		$this->setData('label',$this->getLabel());
		return parent::toJson();
	}
	
	
	
}
