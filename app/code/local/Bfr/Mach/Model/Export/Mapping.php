<?php
/**
 * Bfr Mach
 *
 *
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Model_Export_Abstract
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Model_Export_Mapping extends Bfr_Mach_Model_Export_Abstract
{
	protected $_ExportType = Bfr_Mach_Model_ExportType::TYPE_ZUORDNUNG;
	
	private $_cols = array('IRQUELLSYSTEM','IRLAUF','IRBELEG','IRPOSITION','KOSTENRECHNUNG','ABRECHNUNGSOBJEKT','BETRAG','FWBETRAG');
	
    public function getData4Order(array $orderIds = array(), $Lauf)
    {
    	parent::getData4Order($orderIds, $Lauf);
    	$collection = Mage::getModel('sales/order_item')->getCollection();
    	
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	
    	$collection->getSelect()
    		->join(array('order'=>$collection->getTable('sales/order')),'order.entity_id = main_table.order_id',array('increment_id'))
    		->joinleft(array('product_haushaltstelle'=>'catalog_product_entity_varchar'), 'product_haushaltstelle.entity_id=main_table.product_id AND product_haushaltstelle.attribute_id='.$eav->getIdByCode('catalog_product', 'haushaltsstelle'))
    		->joinLeft(array('haushaltstelle'=>$collection->getTable('paymentbase/haushaltsparameter')),'product_haushaltstelle.value = haushaltstelle.paymentbase_haushaltsparameter_id', array('haushaltstelle'=>'value'))
    		->where('parent_item_id IS NULL')
    		->where('order_id IN( '. implode(',',$orderIds).')' )
    		->order('order_id');
    	
    	
    	$result = array();
    	$result[] = implode($this->getDelimiter(), $this->_cols);
    	
    	//Zähler
    	$IRBeleg = 0;
    	$lastOrderId = 0;
    	$IRPos = 0;
    	
    	$attributes = array();
    	$attributes['KoRe_1 KST'] = 'KoRe_1_KST';
    	$attributes['KoRe_2 KTR'] = 'KoRe_2_KTR';
    	$attributes['KoRe_4'] = 'KoRe_4';
    	
    	
    	foreach($collection as $orderItem){
    		
    		if($lastOrderId != $orderItem->getOrderId())
    		{
    			$IRBeleg++;
    			$IRPos = 0;
    		}
    		$lastOrderId = $orderItem->getOrderId();
    		
    		$IRPos++;
    		
    		$product = Mage::getModel('catalog/product')->load($orderItem->getProductId());
    		
    		foreach($attributes as $key => $value)
    		{
	    		$line = array();
	    		$line[] = $this->getConfigValue('head/irquellsystem',null, null); //Irquellsystem
				$line[] = $this->_Lauf; //Irlauf
				$line[] = $IRBeleg; //Irbeleg
				$line[] = $IRPos; //Irposition
				$line[] = $key; //Kostenrechnung
				$line[] = $product->getData($value); //Abrechnungsobjekt
				$line[] = $this->_formatPrice($orderItem->getBasePrice(), $this->getConfigValue('pos/decimal_separator')); ; //Betrag
				$line[] = $this->_formatPrice($orderItem->getPrice(), $this->getConfigValue('pos/decimal_separator')); ; //Fwbetrag
	    		
	    		
	    		
	    		$result[] = implode($this->getDelimiter(), $line);
    		}
    	}
    	
    	return implode("\n",$result);
    }
    
    
   
    
}
