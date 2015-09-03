<?php

class Dimdi_Import_Model_Product_Attributes
{
    private $_conn = null;
    private $_attributes = null;
    private $_downloads = array();
    private $_description = array();
    private $_categories = null;
    
 	public function load($conn, $products_id)
    {
    	$this->_conn = $conn;
    	$this->_attributes = $this->_conn->fetchAll("SELECT * FROM products_attributes as t1
				left join products_attributes_download as t2 on t1.products_attributes_id = t2.products_attributes_id where products_id = " . $products_id);
    	
    	foreach($this->_attributes as $row)
    	{
    		if($row['products_attributes_filename'])
    		{
    			$this->_downloads[] = $row['products_attributes_filename'];
    		}
    	}
    	
    	$res = $this->_conn->fetchAll("SELECT * FROM products_description where products_id = " . $products_id);
    	
    	foreach($res as $row)
    	{
    		$this->_description[$row['language_id']] = $row;
    	}
    	
    	$res = $this->_conn->fetchAll("SELECT * FROM products_to_categories where products_id = " . $products_id);
    	
    	if(count($res) > 0)
    	{
    		$this->_categories = array();
	    	foreach($res as $row)
	    	{
	    		$this->_categories[] = $row['categories_id'];
	    	}
    	}
    	
    }
    
    public function getDownloads()
    {
    	return $this->_downloads;
    }
    
    public function isDownload()
    {
    	return count($this->_downloads) > 0;
    }
    
    public function getName($langId)
    {
    	return strip_tags($this->_description[$langId]['products_name']);
    }
    
    public function getDescription($langId)
    {
    	if (!isset($this->_description[$langId])){
    		return "";
    	}
    	return strip_tags($this->_description[$langId]['products_description']);
    }
    
    public function getCategories()
    {
    	if ($this->_categories == null) return '';
    	$cat = implode(',',$this->_categories);
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	$attribute_id = $eav->getIdByCode('catalog_category', 'osc_category_id');
    	
    	$collection = Mage::getModel('catalog/category')->getCollection();
    	$collection->getSelect()->join(array('osc'=>'catalog_category_entity_varchar'),'e.entity_id = osc.entity_id',array('oscid'=>'value'))
    		->where("osc.value in (" .$cat.")")
    		->where("attribute_id = $attribute_id");
    		$tmp = $collection->getSelect()->__toString();
    		
    	$res = array();
     	foreach($collection->getItems() as $item)
    	{
    		$res[] = $item->getId();
    	}
    	if(count($res) == 0)
    	{
    		die($tmp);
    		return "";
    	} 
    	return implode(',',$res);
    }
  
}