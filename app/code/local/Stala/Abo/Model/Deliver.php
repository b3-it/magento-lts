<?php

class Stala_Abo_Model_Deliver extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stalaabo/deliver');
    }
    
    
    //wird von der Produktverwaltung aufgerufen
    //damit wird das Produkt der Liste der auszuliefernden Artikel hinzugef�gt
    public function deliverProduct($product_id)
    {
    	$product_id = intval($product_id);
    	$product = Mage::getModel('catalog/product')->load($product_id);
    	$parent_id = intval($product->getAboParentProduct());
    	if(!$parent_id)
    	{
    		$msg = Mage::helper('stalaabo')->__("Is not a Abo Product");
    		Mage::throwException($msg);
    	}
    	
    	//if(!$product->isSaleable())
    	if($product->getStatus() != Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
    	{
    		$msg = Mage::helper('stalaabo')->__("Abo Product is not enabled!");
    		Mage::throwException($msg);
    	}
    	
        if(!$product->getAboProductReleaseDate())
    	{
    		$msg = Mage::helper('stalaabo')->__("Abo Product has no release Date!");
    		Mage::throwException($msg);
    	}
    	
    	
    	
    	$contracts = Mage::getModel('stalaabo/contract')->getCollection();
    	$exp = new Zend_Db_Expr('select abo_contract_id FROM '.$contracts->getTable('stalaabo/delivered').' WHERE product_id='.$product_id);
    	
    	$linkHash = '';
    	
    	if($product->getTypeId() == Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE)
    	{
    		$linkHash = strtr(base64_encode(microtime() . $product->getAboProductReleaseDate() . $product->getId()), '+/=', '-_,');
    	}
    	
    	$link = new Zend_Db_Expr("'".$linkHash. "' as link_hash");
    	$const = new  Zend_Db_Expr($product_id. ' as product_id');
    	
    	
    	$contracts->getSelect()
    		->reset(Zend_Db_Select::COLUMNS)
    		->columns(array('abo_contract_id','qty'))
    		->columns($const)
    		->columns($link)
    		->where('base_product_id='.$parent_id)
    		->where('status=1')
    		->where('from_date <= ?',$product->getAboProductReleaseDate())
    		->where('abo_contract_id not in ('.$exp.')')
    		->where('is_deleted=0');
                       
    	
    	$sql = new Zend_Db_Expr('INSERT INTO '.$contracts->getTable('stalaabo/delivered')."  (abo_contract_id,contract_qty,product_id,link_hash) ".$contracts->getSelect());
    	
    	//$s = $sql->__toString();
    	//die($sql->__toString());
		
    	$contracts->getConnection()->query($sql);
    	
    
    	
    }
    

    
}