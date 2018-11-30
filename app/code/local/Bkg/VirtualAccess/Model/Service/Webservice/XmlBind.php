<?php


class Bkg_VirtualAccess_Model_Service_Webservice_XmlBind 
{

    
    /**
     * Bind XML file to model
     * @param string $xml   XML source
     * @param object $model PHP Model to bind to
     * 
     * @return object PHP model
     */
    public function bindXml($xml, $model = null) {
        
        //print_r($xml."\n ".get_class($model));
    	if($model==null){
    		$model = $this;
    	}
        $this->dom = new \DOMDocument();
        $this->dom->loadXML($xml);
        
        $xpath = new \DOMXPath($this->dom);
        
        $childs = $xpath->query("child::*");
        
       
        $obj = $this->dom->documentElement;
        $attributes = $obj->attributes;
        if($attributes->length > 0 )
        {
        	foreach($attributes as $attribute)
        	{
        		$model->setAttribute($attribute->name,$attribute->nodeValue);
        	}
        }
        
        foreach ($childs as $child) {
            $ns = "";
            $name= $child->nodeName; 
            $name = str_replace('bmecat:', "", $name);
            $getclassName = "get".$this->getUcFirst($name);
            
            if (!method_exists($model, $getclassName)) {
            	throw new \RuntimeException("Model ".get_class($model)." does not have element ".$name);
            }
            $childModel = $model->$getclassName();
            
            $attributes = $child->attributes;
            if($attributes->length > 0 )
            {
            	foreach($attributes as $attribute)
            	{
            		$childModel->setAttribute($attribute->name,$attribute->nodeValue);
            	}
            }
            if ($this->hasChild($child)) {
            	
            	$doc = new \DOMDocument();
            	$doc->appendChild($doc->importNode($child, true));
            	$this->bindXml($doc->saveXml(), $childModel);
                
            } else if (isset($child->nodeValue) && strlen($child->nodeValue) > 0) {
            	$childModel->setValue($child->nodeValue);
            }
        }
        
        
        return $model;
    }
    

    private function hasChild($node) {
    	if ($node->hasChildNodes()) {
    		foreach ($node->childNodes as $c) {
    			if ($c->nodeType === XML_ELEMENT_NODE) {
    				return true;
    			}
    		}
    	}
    	return false;
    }
    
    function getUcFirst($node)
    {
    	$split = explode('_',$node);
    	foreach($split as $key => $value)
    	{
    		$split[$key] =  ucfirst (strtolower ($value));
    	}
    
    	return implode('',$split);
    }
    
}