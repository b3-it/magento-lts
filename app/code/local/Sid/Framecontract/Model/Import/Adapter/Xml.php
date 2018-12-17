<?php

class Sid_Framecontract_Model_Import_Adapter_Xml extends Mage_ImportExport_Model_Import_Adapter_Abstract
{
    protected $_defaultValues = null;

    private $_MediaAttributeId = null;

    //zum vermeiden von dopplungen bei crossell
    private $_LastSku = "";

    
    protected $_xml = null;
    
    //xpath von xml zu array
    protected $_Mapping = array();
    
    //mapping der xml struktur zu Bildern
    protected $_Mime = array();
    
    //zweck laut xml Definition 
    protected $_Purpose = array();
    
    
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
    	//$this->rewind();
        
        return $this;
    }

    /**
     * Move forward to next element
     *
     * @return void Any returned value is ignored.
     */
    public function next()
    {
    	//$this->_pos++;
    	$this->_currentKey += 1;
        $this->_currentRow = $this->getLine();//fgetcsv($this->_fileHandler, null, $this->_delimiter, $this->_enclosure);
      
        
        $this->_currentKey = $this->_currentRow ? $this->_currentKey : null;
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        // rewind resource, reset column names, read first row as current
        $this->_colNames =  array_keys($this->_Mapping);
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
    	$pos = $this->_currentKey ? $this->_currentKey : 0;
    	$line = $this->getProductAt($pos);
    	$res = null;
    	if($line != null)
    	{
    		$res = array();
	    	foreach($this->_Mapping as $key => $path)
	    	{
	    		$value = $this->xpath($line, $path);
	    		$res[] =  $value;
	    		
	    	}
    	}
    	
    	return $res;
    }

   
    
    function xpath($xml,$path)
    {
    	$path = explode('/',$path);
    	$curr = array_shift($path);
    	$xml = $xml->{$curr};
    	$name = $xml->getName();
    	if(empty($name)){
    		return null;
    	}
    	if(count($path) == 0){
    		$children = $xml->children();
    		if(count($children) == 0){
    			return utf8_encode($xml);
    		}else{
    			return $xml;
    		}
    		
    	}
    	return $this->xpath($xml,implode('/',$path));
    	
    }
    
    
    
    public function translateColNames()
    {
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
        $los = $res['framecontract_los'];
		
		$res['framecontract_los'] = Mage::getModel('framecontract/los')->load($res['framecontract_los'])->getOptionsLabel();

		if(!isset($res['qty'])){
			$res['qty'] = 0;
			$res['framecontract_qty'] = 0;
		}
		if(!isset($res['weight'])){
			$res['weight'] = 0;
		}
		
        $skuCols = array('sku','_links_crosssell_sku','_links_upsell_sku','_links_related_sku','_parent_sku');

        foreach($skuCols as $skuCol)
        {
        	if(isset($res[$skuCol])) {
        			if(strlen(trim($res[$skuCol])) > 0){
        				$res[$skuCol] = trim($this->_defaultValues['sku_prefix'].$los.'/'.$res[$skuCol]);
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

        $res = $this->_addImage($res);

        return $res;
    }

    
    
    /*
     *  protected $_Mime = array(
    		'type' => 'MIME_TYPE',
    		'source' => 'MIME_SOUCE',
    		'label' => 'MIME_DESCR',
    		'purpose' => 'MIME_PURPOSE',
    		'allowed' => array('image/jpeg','image/png','jpg','png'),
    		
    		 protected $_Purpose = array(
    		'detail' => 'image',
    		'thumbnail' => 'thumbnail',
    		'normal' => 'small_image'
    );
    );
     */
    
    protected function _addImage($row)
    {
    	
    	if(isset($row['imagelist']))
    	{
    		foreach($row['imagelist']->children() as $image)
    		{
    			$file = $this->xpath($image, $this->_Mime['source']).'' ;
    			//type
    			$type = $this->xpath($image, $this->_Mime['type']).'' ;
    			if(!$type){
    				$type = pathinfo($file)['extension'];
    			}
    			
    			if(array_search($type,  $this->_Mime['allowed']) === false){
    				continue;
    			}
    			
    			$purpose = null;
    			if(isset($this->_Purpose[$this->xpath($image, $this->_Mime['purpose'])])){
    				$purpose =  $this->_Purpose[$this->xpath($image, $this->_Mime['purpose'])];
    			}
    			if(!$purpose){
    				$purpose = 'image';
    			}
    			
    			$row[$purpose] = $file;
    			$row[$purpose.'_label'] = $this->xpath($image, $this->_Mime['label'].'');
    			
	    		if(!isset($row[$purpose.'_label'])){
	    			$row[$purpose.'_label'] = $row[$purpose];
	    		}
    		}
    		
    		$default = null;
    		if(isset($row['image'])){
    			$default = 'image';
    		}elseif(isset($row['thumbnail'])){
    			$default = 'thumbnail';
    		}elseif(isset($row['small_image'])){
    			$default = 'small_image';
    		}
    		
    		if($default)
    		{
    			if(!isset($row['image'])){
    				$row['image'] = $row[$default];
    				$row['image_label'] = $row[$default.'_label'];
    			}
    			if(!isset($row['thumbnail'])){
    				$row['thumbnail'] = $row[$default];
    				$row['thumbnail_label'] = $row[$default.'_label'];
    			}
    			if(!isset($row['small_image'])){
    				$row['small_image'] = $row[$default];
    				$row['small_image_label'] = $row[$default.'_label'];
    			}
    			
    			/*
	    		$row['_media_image'] = $row['image'];
	    		$row['_media_lable'] = $row['image_label'];
	    		$row['_media_position'] = 1;
	    		$row['_media_is_disabled'] = 0;
	    		$row['_media_attribute_id'] = $this->getMediaAttributeId();
	    		*/
    		}
    		unset($row['imagelist']);
    	}
    	
    	return $row;
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
