<?php

class Bkg_VirtualGeo_Model_Service_Geometry extends Mage_Core_Model_Abstract 
{
    /**
     * 
     * @var Bkg_Geometry_Multipolygon $_GEOShape
     */
    protected $_GEOShape;
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/service_geometry');
    }
    
    
    public function getGEOShape()
    {
        return $this->_GEOShape;
    }
    
    public function setGEOShape($value)
    {
        $this->_GEOShape = $value;
        return $this;
    }
    
    protected function _beforeSave()
    {
        if($this->_GEOShape != null)
        {
            $this->setShape($this->_GEOShape->toSql());
        }
        
        return parent::_beforeSave();
    }
}

