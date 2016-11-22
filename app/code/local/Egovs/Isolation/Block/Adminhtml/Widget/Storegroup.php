<?php
class Egovs_Isolation_Block_Adminhtml_Widget_Storegroup extends Varien_Data_Form_Element_Select
{
	private $_contracts = null;
	
 public function getElementHtml()
    {
        $this->addClass('select');
        $html = '<select  disabled="disabled" id="'.$this->getHtmlId().'" name="'.$this->getName().'" '.$this->serialize($this->getHtmlAttributes()).'>'."\n";

        $value = $this->getValue();
        if (!is_array($value)) {
            $value = array($value);
        }

        if ($values = $this->getValues()) {
            foreach ($values as $key => $option) {
                if (!is_array($option)) {
                    $html.= $this->_optionToHtml(array(
                        'value' => $key,
                        'label' => $option),
                        $value
                    );
                }
                elseif (is_array($option['value'])) {
                    $html.='<optgroup label="'.$option['label'].'">'."\n";
                    foreach ($option['value'] as $groupItem) {
                        $html.= $this->_optionToHtml($groupItem, $value);
                    }
                    $html.='</optgroup>'."\n";
                }
                else {
                    $html.= $this->_optionToHtml($option, $value);
                }
            }
        }

        $html.= '</select>'."\n";
        $html.= $this->getAfterElementHtml();
        return $html;
    }
	
	
	private function getFrameContractId($losId)
	{
		foreach($this->getFrameContract() as $id => $contract)
		{
			foreach($contract['lose']['items'] as $los)
			{
				if($los['los_id'] == $losId){
					return $id;
				}
			}
		}
		
		return 0;
	}
	
	
	private function getFrameContract()
	{
		if($this->_contracts == null)
		{
			$this->_contracts = array();
			$collection = Mage::getModel('framecontract/contract')->getCollection();
			$collection->getSelect()->order('main_table.title');
			foreach($collection->getItems() as $item)
			{
				$lose = Mage::getModel('framecontract/los')->getCollection();
				$lose->getSelect()->where("main_table.framecontract_contract_id =".$item->getId())->order('main_table.title');
				$this->_contracts[$item->getId()] = array('label'=>$item->getTitle(), 'lose'=>$lose->toArray());
			}
		}
		return $this->_contracts;
	}
	
	private function getLose()
	{
		if($this->_contracts == null)
		{
			$this->_contracts = array();
			$collection = Mage::getModel('framecontract/contract')->getCollection();
			$collection->getSelect()->order('main_table.title');
			foreach($collection->getItems() as $item)
			{
				$lose = Mage::getModel('framecontract/los')->getCollection();
				$lose->getSelect()->where("main_table.framecontract_contract_id =".$item->getId())->order('title');
				$this->_contracts[$item->getId()] = array('label'=>$item->getTitle(), 'lose'=>$lose->toArray());
			}
		}
		return $this->_contracts;
	}
	
	public function getReadonly()
	{
		if($this->isUsed()){
			return true;
		}
		if ($this->hasData('readonly_disabled')) {
			return $this->_getData('readonly_disabled');
		}
	
		return $this->_getData('readonly');
	}
	
	public function isUsed()
	{
		return false;
	}
	
 	public function getAfterElementHtml()
    {
        $html = parent::getAfterElementHtml();
        if($this->getReadonly()){
        	return $html." <script>
        				$('".$this->getHtmlId()."').disable();
        				$('".$this->getHtmlId()."_0').disable();
        				</script>";
        }
        return $html;
    }
}