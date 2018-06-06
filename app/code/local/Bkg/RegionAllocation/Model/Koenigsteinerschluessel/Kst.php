<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name       	Bkg_Regionallocation_Model_Koenigsteinerschluessel_Kst
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method string getName()
 *  @method setName(string $value)
 *  @method int getActive()
 *  @method setActive(int $value)
 *  @method  getActiveFrom()
 *  @method setActiveFrom( $value)
 *  @method  getActiveTo()
 *  @method setActiveTo( $value)
 */
class Bkg_RegionAllocation_Model_Koenigsteinerschluessel_Kst extends Mage_Core_Model_Abstract
{
	
	protected $_Portions = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('regionallocation/koenigsteinerschluessel_kst');
    }
    
    /***
     * die Anteile der Länder
     * @param int $tax see Bkg_RegionAllocation_Model_Product_Type_Regionallocation_Tax
     * @return Bkg_Regionallocation_Model_Koenigsteinerschluessel_Kstvalue[]
     */
    public function getPortions()
    {
    	if($this->_Portions == null)
    	{
	    	//falls der Königsteinerschluessel noch nicht gesetzt wurde
	    	if($this->getId() == null)
	    	{
	    		$this->loadCurrent();
	    	}
	    	$collection = Mage::getModel('regionallocation/koenigsteinerschluessel_kstvalue')->getCollection();
	    	
// 	    	if($tax == Bkg_RegionAllocation_Model_Product_Type_Regionallocation_Tax::WITH_TAX)
// 	    	{
// 	    		$collection->getSelect()
// 	    			->where('has_tax = 1');
// 	    		$this->_TaxMode = Bkg_RegionAllocation_Model_Product_Type_Regionallocation_Tax::WITH_TAX;
// 	    	}elseif($tax == Bkg_RegionAllocation_Model_Product_Type_Regionallocation_Tax::WITHOUT_TAX)
// 	    	{
// 	    		$collection->getSelect()
// 	    			->where('has_tax = 0');
// 	    		$this->_TaxMode = Bkg_RegionAllocation_Model_Product_Type_Regionallocation_Tax::WITHOUT_TAX;
// 	    	}
// 	    	$collection->getSelect()->where('kst_id =' . intval($this->getId()));
	    	$this->_Portions = $collection->getItems();
    	}
    	return $this->_Portions;
    	
    }
    
    /***
     * die Beiträge der Länder am Preis
     * @param float $price NettoPreis
     * @param int $tax see Bkg_RegionAllocation_Model_Product_Type_Regionallocation_Tax
     * @return array
     */
    public function getPortions4Price($price, $tax)
    {
    	$portions = $this->getPortions($tax);
    	
    	$res = array();
    	
    	foreach($portions as $portion)
    	{
    		$res[$portion->getRegion()] = $price * $portion->getPortion();
    	}
    	 
    	return $res;
    }
    	
    
    public function loadCurrent()
    {
    	$collection = Mage::getModel('regionallocation/koenigsteinerschluessel_kst')->getCollection();
    	$collection->getSelect()->where('active = 1');
    	foreach($collection->getItems() as $item){
    		$data = $item->getData();
    		$this->setData($data);
    	}
    	
    	return $this;
    }
}
