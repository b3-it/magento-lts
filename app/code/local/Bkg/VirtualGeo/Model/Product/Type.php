<?php
class Bkg_VirtualGeo_Model_Product_Type extends Mage_Bundle_Model_Product_Type
{
	

	/**
	 * Type ID
	 *
	 * Muss mit XML übereinstimmen!!
	 *
	 * @var string
	 */
	const TYPE_CODE = 'virtualgeo';
	
	protected $_RapRelationCollection = null;


  
    
    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode)
    {
    	$resultParent = parent::_prepareProduct($buyRequest, $product, $processMode);
    
    	if (is_string($result)) {
    		return $result;
    	}
    	
    	//TODO: aus $buyRequest lesen
    	$nutzung = 'ext'; 
    	
    	$price = 100;
    	
    	//alle verfügbaren Entgelte abholen
    	$fees = $sect = Mage::getConfig()->getNode('virtualgeo/fees/sections')->asArray();
    	
    	foreach($fees as $fee)
    	{
    			$raprel = $this->_getRapRelation($product, $fee['ident'], $nutzung);
    			$taxraprel = $this->_getRapRelation($product, $fee['ident'], $nutzung.'_tax');
    			
    			$rapId = $raprel ? $raprel->getRapId(): null;
    			$rapIdTax = $taxraprel ? $taxraprel->getRapId(): null;
    			
    			$raps = Mage::helper('regionallocation')->getRapProducts($rapId, $rapIdTax, $price, $fee['ident'], $nutzung);
    			
    			
    			foreach($raps as $rap)
    			{
			    	$_result = $rap->getTypeInstance(true)->prepareForCart($buyRequest, $rap);
			    	if (is_string($_result) && !is_array($_result)) {
			    		return $_result;
			    	}
			    	
			    	if (!isset($_result[0])) {
			    		return Mage::helper('checkout')->__('Cannot add item to the shopping cart.');
			    	}
			    	
			    	
			    	
			    	$resultParent[] = $_result[0]->setParentProductId($product->getId())
			    		->addCustomOption('fee',$rap->getFee())
			    		->addCustomOption('usage',$rap->getUsage())
			    		->addCustomOption('kst_id',$rap->getKst()->getId())
			    		->addCustomOption('kst_portions',serialize($rap->getPortions()))
			    		;
			    	;
    			}
    	}
    	
    	return $resultParent;
    }
    
    
    /**
     * Ein array aller Reginallocations für das Produkt
     * @param Mage_Catalog_Model_Product $product
     * 
     * @return array[fee][usage]
     */
    protected function _getRapRelationCollection($product, $usage)
    {
    	$expr = new Zend_Db_Expr("`usage` = '".$usage."' OR `usage` = '".$usage."_tax'");
    	if($this->_RapRelationCollection == null)
    	{
    		$collection = Mage::getModel('virtualgeo/components_regionallocation')->getCollection();
    		$collection->getSelect()
    		->order('fee')
    		->where($expr)
    		->where('parent_id = '.intval($product->getId()));
    		$this->_RapRelationCollection = array();
    		foreach($collection->getItems() as $item){
    			$this->_RapRelationCollection[$item->getFee()][$item->getUsage()] = $item;
    		}
    		
    	}
    
    	return $this->_RapRelationCollection;
    }
  
    
    protected function _getRapRelation($product, $fee, $usage)
    {
    	$items = $this->_getRapRelationCollection($product, $usage);
    	
    	if(isset($items[$fee])){
    		if(isset($items[$fee][$usage])){
    			return $items[$fee][$usage];
    		}
    	}
    	
    	return null;
    }
    
    
    
    
    /**
     * Check if product can be configured
     *
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     */
    public function canConfigure($product = null)
    {
    	return $product instanceof Mage_Catalog_Model_Product
    	&& $product->isAvailable();
    }
    
   

    
    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
    	return Mage::getSingleton('checkout/cart');
    }
   
   

}
