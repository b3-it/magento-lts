<?php
class Stala_Product_Model_Nature extends Varien_Object
{
	const PRODUCTNATURE_PRINT = 1;
	const PRODUCTNATURE_PDF = 2;
	const PRODUCTNATURE_EXCEL = 3;
	
	public function getAllOptions()
	{
		$res = array();
		$res[] = array('value'=>Stala_Product_Model_Nature::PRODUCTNATURE_PRINT,'label'=>'Print');
		$res[] = array('value'=>Stala_Product_Model_Nature::PRODUCTNATURE_PDF,'label'=>'Pdf');
		$res[] = array('value'=>Stala_Product_Model_Nature::PRODUCTNATURE_EXCEL,'label'=>'Excel');
		
		return $res;
	}
	
	static public function getOptionArray()
	{
		$options = array();
		
		$att = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product','artikel_art');
		
		if (!$att)
			return $options;
		
		$att = $att->getSource();		
		 
		foreach($att->getAllOptions(false) as $item)
		{
			$options[$item['value']]=$item['label'];
		}
	
		return $options;
	}

}