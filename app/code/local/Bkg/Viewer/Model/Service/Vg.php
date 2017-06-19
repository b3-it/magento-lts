<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Service_Service
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_Viewer_Model_Service_Vg extends Mage_Core_Model_Abstract
{
	protected $_GEOShape;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/service_vg');
        $this->_GEOShape = new Bkg_Geometry_Multipolygon();
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
    
    protected function _afterLoad()
    {
    	if($this->getId()){
	    	$shape = $this->getResource()->loadGeoemetryAsText($this->getId());
	    	if($shape){
	    		$this->_GEOShape = $shape;
	    	}
    	}
    	return parent::_afterLoad();
    }
   
}
