<?php

class Sid_Framecontract_Model_Import_Adapter_Xml_Bmecat extends Sid_Framecontract_Model_Import_Adapter_Xml
{
   
	protected $_productCollection = null;

    protected $_Mapping = array(
    		'short_description' => 'ARTICLE_DETAILS/DESCRIPTION_SHORT',
    		'description' => 'ARTICLE_DETAILS/DESCRIPTION_LONG',
    		'name' => 'ARTICLE_DETAILS/MANUFACTURER_NAME',
     		'supplier_aid' => 'SUPPLIER_AID',
    		'sku' => 'SUPPLIER_AID',
    		'qty' => 'ARTICLE_DETAILS/STOCK',
    		'framecontract_qty' => 'ARTICLE_DETAILS/STOCK',
    		'price' => 'ARTICLE_PRICE_DETAILS/ARTICLE_PRICE/PRICE_AMOUNT',
    		'imagelist' => 'MIME_INFO',
    		'weight' => 'ARTICLE_FEATURES/FEATURE/FNAME',
    		'ean' => 'EAN'
    		
    );
   
    protected $_Mime = array(
    		'type' => 'MIME_TYPE',
    		'source' => 'MIME_SOURCE',
    		'label' => 'MIME_DESCR',
    		'purpose' => 'MIME_PURPOSE',
    		'allowed' => array('image/jpeg','image/jpg','image/png','jpg','png'),
    );
    
    protected $_Purpose = array(
    		'detail' => 'image',
    		'thumbnail' => 'thumbnail',
    		'normal' => 'small'
    );
    
    
    protected function getProductAt($index)
    {
    	if($this->_productCollection == null)
    	{
    		$tmp = $this->xpath($this->_xml,'T_NEW_CATALOG');
    		$this->_productCollection = $tmp->children();//$this->_xml->xpath('T_NEW_CATALOG/ARTICLE');
    	}
    	
    	return $this->_productCollection[$index];
    	 
    }
    
    protected function _init()
    {
    	 
    	$xmlstr = file_get_contents($this->_source);
    	$xml = str_replace('xmlns="http://www.bmecat.org/bmecat/1.2/bmecat_new_catalog"', '', $xmlstr);
    	$this->_xml =  new SimpleXMLElement($xmlstr);
    	$this->rewind();
    
    	return $this;
    }

}
