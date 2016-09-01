<?php

class Sid_Framecontract_Model_Import_Adapter_Xml extends Mage_ImportExport_Model_Import_Adapter_Abstract
{
    protected $_defaultValues = null;

    private $_MediaAttributeId = null;

    //zum vermeiden von dopplungen bei crossell
    private $_LastSku = "";

    
    protected $_xml = null;
    protected $_pos = 0;
    protected $_Mapping = array();
    
    
    public function setDefaultValues($values)
    {
    	$this->_defaultValues = $values;
    }

    /**
     * Object destructor.
     *
     * @return void
     */
    public function __destruct()
    {
        
    }

    /**
     * Method called as last step of object instance creation. Can be overrided in child classes.
     *
     * @return Mage_ImportExport_Model_Import_Adapter_Abstract
     */
    protected function _init()
    {
    	
    	$xmlstr = file_get_contents($this->_source);
    	$this->_xml = new SimpleXMLElement($xmlstr);
    	$this->rewind();
        
        return $this;
    }

    /**
     * Move forward to next element
     *
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->_currentRow = $this->getLine();//fgetcsv($this->_fileHandler, null, $this->_delimiter, $this->_enclosure);
        $this->_pos++;
        
        //$this->_currentKey = $this->_currentRow ? $this->_currentKey + 1 : null;
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        // rewind resource, reset column names, read first row as current
        $this->_pos = 0;
        $this->_colNames =  array_keys($this->_bmcCatMapping);
        $this->_currentRow = $this->getLine();//fgetcsv($this->_fileHandler, null, $this->_delimiter, $this->_enclosure);

       
        if ($this->_currentRow) {
            $this->_currentKey = 0;
        }
        $this->translateColNames();
    }

    /**
     * Seeks to a position.
     *
     * @param int $position The position to seek to.
     * @throws OutOfBoundsException
     * @return void
     */
    public function seek($position)
    {
        if ($position != $this->_currentKey) {
            if (0 == $position) {
                return $this->rewind();
            } elseif ($position > 0) {
                if ($position < $this->_currentKey) {
                    $this->rewind();
                }
                while ($this->_currentRow = $this->getLine()) {
                    if (++ $this->_currentKey == $position) {
                        return;
                    }
                }
            }
            throw new OutOfBoundsException(Mage::helper('importexport')->__('Invalid seek position'));
        }
    }

    private function getLine()
    {
    	
    	$line = $this->getProductAt($this->_pos);
    	$res = array();
    	if(($line != null))
    	{
	    	foreach($this->_Mapping as $key => $path)
	    	{
	    		$value = $this->xpath($line, $path);
	    		
	    		$res[] =  utf8_encode($value);
	    	}
    	}
    	return $res;
    }

   
    
    function xpath($xml,$path)
    {
    	$path = explode('/',$path);
    	$curr = array_shift($path);
    	$xml = $xml->{$curr};
    	if(count($path) == 0){
    		return $xml;
    	}
    	return $this->xpath($xml,implode('/',$path));
    	
    }
    
    
    
    public function translateColNames()
    {
    	return;
    	
    }

    public function current()
    {
        $res =  array_combine(
            $this->_colNames,
            count($this->_currentRow) != $this->_colQuantity
                    ? array_pad($this->_currentRow, $this->_colQuantity, '')
                    : $this->_currentRow
        );
        
        $res = array_merge($res,$this->_defaultValues);
		$res['sku'] = $res['los'].'/'.$res['supplier_aid'];
        

        $skuCols = array('sku','_links_crosssell_sku','_links_upsell_sku','_links_related_sku','_parent_sku');

        foreach($skuCols as $skuCol)
        {
        	if(isset($res[$skuCol])) {
        			if(strlen(trim($res[$skuCol])) > 0){
        				$res[$skuCol] = trim($this->_defaultValues['sku_prefix'].$res[$skuCol]);
        			}
        	}
        }


        if($res['sku'] == $this->_LastSku){
        	$res['sku'] ='';
        }
        else
        {
        	$this->_LastSku = $res['sku'];
        }

        if(isset($res['image']))
        {
        	if(!isset($res['image_label'])){
        		$res['image_label'] = $res['image'];
        	}
	        $res['small_image'] = $res['image'];
	        $res['small_image_label'] = $res['image_label'];
	        $res['thumbnail'] = $res['image'];
	        $res['thumbnail_label'] = $res['image_label'];
	        $res['_media_image'] = $res['image'];
	        $res['_media_lable'] = $res['image_label'];
	        $res['_media_position'] = 1;
	        $res['_media_is_disabled'] = 0;
	        $res['_media_attribute_id'] = $this->getMediaAttributeId();
        }





        return $res;
    }

    private function getMediaAttributeId()
    {
    	if($this->_MediaAttributeId == null)
    	{
    		 $eav = Mage::getResourceModel('eav/entity_attribute');
    		 $this->_MediaAttributeId = $eav->getIdByCode('catalog_product','media_gallery');
    	}
    	return $this->_MediaAttributeId;
    }
}
