<?php


class B3it_XmlBind_Bmecat2005_XmlBind {

    
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
        
        $refl  = new \ReflectionClass(get_class($model));
        $xpath = new \DOMXPath($this->dom);
        
        $query = "child::*";
        $childs = $xpath->query($query);
        
        foreach ($childs as $child) {
            $ns = "";
            $name= $child->nodeName;
          	
            $attributes = $child->attributes;
            if($attributes->length > 0 )
            {
            	foreach($attributes as $attribute)
            	{
            		$model->setAttribute($attribute->name,$attribute->nodeValue);
            	}
            }
            
            
            $getclassName = "get".$this->getUcFirst($name);
            
            if (!method_exists($model, $getclassName)) {
            	throw new \RuntimeException("Model ".get_class($model)." does not have element ".$name);
            }
            $childModel = $model->$getclassName();
            if ($this->hasChild($child)) {
            	
            	$doc = new \DOMDocument();
            	$doc->appendChild($doc->importNode($child, true));
            	$this->bindXml($doc->saveXml(), $childModel);
                
            } else if (!empty($child->nodeValue)) {
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