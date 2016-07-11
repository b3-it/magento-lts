<?php
class Sid_Framecontract_Block_Adminhtml_Widget_Los extends Varien_Data_Form_Element_Select
{
	private $_contracts = null;
	
	public function getElementHtml()
	{
		
		$html  = '<script type="text/javascript">
        			var contracts = '.json_encode($this->getFrameContract()).'
        			function changeContract(contract)
        			{	
        				var lose = contracts[contract][\'lose\'].items;
        				$(\''.$this->getHtmlId().'\').empty();
        				for (var i = 0, len = lose.length; i < len; ++i) {
   	 						$(\''.$this->getHtmlId().'\').options[i] = new Option(lose[i].title, lose[i].los_id);
						};
        				//alert(contract);
        			}
        		</script>';
		$html .='<select onchange="changeContract(this.value)" id="'.$this->getHtmlId().'_0" >';
		foreach($this->getFrameContract() as $key => $value)
		{
			$html .= '<option value="'.$key.'">'.$value['label'].'</option>';
		}
		$html .='</select>' ;
		$html .= parent::getElementHtml();
		
		$tmp = '<script type="text/javascript">';
		$tmp .= 'changeContract('.$this->getFrameContractId($this->getValue()).');';
		$tmp .= '$A($(\''.$this->getHtmlId().'_0\').options).each(function(option){if (option.value=='.$this->getFrameContractId($this->getValue()).') option.selected = true; });';
		$tmp .= '$A($(\''.$this->getHtmlId().'\').options).each(function(option){if (option.value=='.$this->getValue().') option.selected = true; });';
		$tmp .= '</script>';
		return $html.$tmp;
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
			$collection->getSelect()->order('title');
			foreach($collection->getItems() as $item)
			{
				$lose = Mage::getModel('framecontract/los')->getCollection();
				$lose->getSelect()->where("framecontract_contract_id =".$item->getId())->order('title');
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
			$collection->getSelect()->order('title');
			foreach($collection->getItems() as $item)
			{
				$lose = Mage::getModel('framecontract/los')->getCollection();
				$lose->getSelect()->where("framecontract_contract_id =".$item->getId())->order('title');
				$this->_contracts[$item->getId()] = array('label'=>$item->getTitle(), 'lose'=>$lose->toArray());
			}
		}
		return $this->_contracts;
	}
	
 	public function xgetAfterElementHtml()
    {
        $html = parent::getAfterElementHtml();
        return $html." xxxxxxxxxxxxxxxx <script>
        				$('".$this->getHtmlId()."').disable();
        				</script>";
    }
}