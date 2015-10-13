<?php
/**
 * Egovs GermanTax
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_GermanTax
 * @name       	Egovs_GermanTax_Helper_Data
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Helper_Setup extends Mage_Tax_Helper_Data
{
	/*
	 * erzeugen  eines TaxClass arrays
	 * @var data array($key=>array(classname, classtype);
	 */
	public function getTaxClassesArray($data)
	{
		$res = array();
		
		foreach($data as $value)
		{
			/*@var $class Mage_Tax_Model_Class */
			$class = Mage::getModel('tax/class');
			$class->setClassName($value[1]);
			$class->setClassType($value[2]);
			$class->save();
			$res[$value[0]] = $class;
			
		}
		
		return $res;
	}
	
	/*
	 * erzeugen  eines TaxRule arrays
	* @var data array($key=>array();
		 */
	public function getTaxRulesArray($data)
	{
		$res = array();
	
		foreach($data as $value)
		{
			/*@var $class Mage_Tax_Model_Calculation_Rule */
			$class = Mage::getModel('tax/calculation_rule');
			$class->setCode($value[1]);
			$class->setPriority($value[2]);
			$class->setPosition($value[3]);
			$class->setTaxkey($value[4]);
			$class->setValidTaxvat($value[5]);
			
			$class->setData('tax_customer_class',array());
			//$class->setData('tax_product_class');
			//$class->setData('tax_rate');
			
			
			$class->save();
			$res[$value[0]] = $class;
				
		}
	
		return $res;
	}
	
	
	/*
	 * erzeugen  eines TaxRate arrays
	* @var data array($key=>array();
			*/
	public function getTaxRateArray($data)
	{
		$res = array();
	
		foreach($data as $value)
		{
			/*@var $class Mage_Tax_Model_Calculation_Rate */
			$class = Mage::getModel('tax/calculation_rate');
			$class->setTaxCountryId($value[1]);
			$class->setTaxRegionId($value[2]);
			$class->setCode($value[3]);
			$class->setRate($value[4]);
			$class->save();
			$res[$value[0]] = $class;
	
		}
	
		return $res;
	}
	
	
	
	public function setTaxCalculation($tax_rule,$tax_rate,$tax_class, $data)
	{
		
	
		foreach($data as $value)
		{
			/*@var $class Mage_Tax_Model_Calculation */
			$class = Mage::getModel('tax/calculation');
			$class->setTaxCalculationRateId($tax_rate[$value[0]]->getTaxCalculationRateId());
			$class->setTaxCalculationRuleId($tax_rule[$value[1]]->getTaxCalculationRuleId());
			$class->setCustomerTaxClassId($tax_class[$value[2]]->getClassId());
			$class->setProductTaxClassId($tax_class[$value[3]]->getClassId());
			$class->save();
			
	
		}
	
		
	}
	
	
	public function insertPdfBlocks($tax_rule,$data)
	{
		foreach($data as $value)
		{
			/*@var $class Egovs_Pdftemplate_Model_Blocks */
			$class = Mage::getModel('pdftemplate/blocks');
			
			$class->setTitle($value[0]); 
			$class->setIdent($value[1]);
			$class->setContent($value[2]);
			$class->setPayment($value[3]);
			$class->setCustomerGroup($value[4]);
			$class->setShipping($value[5]);
			$class->setStatus($value[7]);
			$tax = $value[8];
			if($tax != 'all')
			{
				if(isset($tax_rule[$tax]))
				{
				 	$tax = $tax_rule[$tax]->getTaxCalculationRuleId();
				}
				else 
				{
					$tax = 'all';
				}
			}
			$class->setTaxRule($tax);
			$class->setCreatedTime(date('Y-m-d'));
			$class->setUpdateTime(date('Y-m-d'));
			$class->save();
				
		
		}
		
	}
	
	
}