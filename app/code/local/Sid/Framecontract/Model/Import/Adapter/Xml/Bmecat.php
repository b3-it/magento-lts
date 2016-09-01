<?php

class Sid_Framecontract_Model_Import_Adapter_Bmecat extends Sid_Framecontract_Model_Import_Adapter_Xml
{
   
	protected $_productCollection = null;

    protected $_Mapping = array(
    		'short_description' => 'ARTICLE_DETAILS/DESCRIPTION_SHORT',
    		'description' => 'ARTICLE_DETAILS/DESCRIPTION_LONG',
    		'name' => 'MANUFACTURER_NAME',
     		'supplier_aid' => 'SUPPLIER_AID',
    		'sku' => 'dummy',
    		'qty' => 'STOCK',
    		'price' => 'ARTICLE_PRICE_DETAILS/ARTICLE_PRICE/PRICE_AMOUNT',
    		'image' => 'MIME_INFO/MIME/MIME_SOURCE',
    		'framecontract_qty' => 'STOCK',
    		'weight' => 'ARTICLE_FEATURES/FEATURE/FNAME',
    		'ean' => 'EAN'
    		
    );
   
    
    private function getProductAt($index)
    {
    	if($this->_productCollection == null)
    	{
    		$this->_productCollection = $this->_xml->xpath('T_NEW_CATALOG/ARTICLE');
    	}
    	
    	return $this->_productCollection[$index];
    	 
    }
    
    protected function _init()
    {
    	 
    	$xmlstr = file_get_contents($this->_source);
    	$xml = str_replace('xmlns="http://www.bmecat.org/bmecat/1.2/bmecat_new_catalog"', '', $xml);
    	$this->_xml =  new SimpleXMLElement($xmlstr);
    	$this->rewind();
    
    	return $this;
    }

}
