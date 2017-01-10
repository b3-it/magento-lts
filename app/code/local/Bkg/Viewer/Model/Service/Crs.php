<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Service_Crs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
 /**
*  @method int getId()
*  @method setId(int $value)
*  @method string getName()
*  @method setName(string $value)
*  @method int getLayerId()
*  @method setLayerId(int $value)
*/
class Bkg_Viewer_Model_Service_Crs extends Mage_Core_Model_Abstract
{
	protected $_Min;// = new Bkg_Geometry_Point();
	protected $_Max;// = new Bkg_Geometry_Point();
	
    public function _construct()
    {
        parent::_construct();
        $this->_Min = new Bkg_Geometry_Point();
        $this->_Max = new Bkg_Geometry_Point();
        
        $this->_init('bkgviewer/service_crs');
    }
    
    public function getMinx()
    {
    	return $this->_Min->getX();
    }
    public function setMinx($value)
    {
    	$this->_Min->setX($value);
    	return $this;
    }
    public function getMaxx()
    {
    	return $this->_Max->getX();
    }
    public function setMaxx($value)
    {
    	$this->_Max->setX($value);
    	return $this;
    }
    public function getMiny()
    {
    	return $this->_Min->getY();
    }
    public function setMiny($value)
    {
    	$this->_Min->setY($value);
    	return $this;
    }
    public function getMaxy()
    {
    	return $this->_Max->gety();
    }
    public function setMaxy($value)
    {
    	$this->_Max->setY($value);
    	return $this;
    }
    
    
    protected function _beforeSave()
    {
    	$this->setData('min',$this->_Min->toSql());
    	$this->setData('max',$this->_Max->toSql());
    	return parent::_beforeSave();
    }
    
}
