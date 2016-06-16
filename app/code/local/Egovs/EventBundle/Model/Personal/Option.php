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
	
	private function getOptionLabel()
	{
		if($this->option_label == null)
		{
			$this->option_label = Mage::getModel('eventbundle/personal_optionLabel')->loadByStoreOption($this->store_id,$this->getId());
		}
		
		return $this->option_label;
	}
	
	public function getLabel()
	{
		return $this->getOptionLabel()->getLabel();
	}
	
	public function setLabel($label)
	{
		return $this->getOptionLabel()->setLabel($label);
	}
	
	protected function _afterSave()
	{
		$label = $this->getOptionLabel();
		$label->setStoreId($this->getStoreId());
		$label->setOptionId($this->getId());
		$label->save();
		return parent::_afterSave();
	}
	
	public function toJson(array $arrAttributes = array())
	{
		$this->setData('label',$this->getLabel());
		return parent::toJson();
	}
	
}
