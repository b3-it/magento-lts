<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Composit_Layer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method string getTitle()
 *  @method setTitle(string $value)
 *  @method string getType()
 *  @method setType(string $value)
 *  @method int getParentId()
 *  @method setParentId(int $value)
 *  @method int getCompositId()
 *  @method setCompositId(int $value)
 *  @method int getPos()
 *  @method setPos(int $value)
 *  @method int getServiceLayerId()
 *  @method setServiceLayerId(int $value)
 */
class Bkg_Viewer_Model_Composit_Layer extends Mage_Core_Model_Abstract
{
	protected $_children = array();
	protected $_Service = null;
	protected $_ServiceLayer = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/composit_layer');
    }
    
   
    /**
     * Ermittelt denService zu diesem CompositLayer
     * @return Bkg_Viewer_Model_Service_Service
     */
    public function getService()
    {
    	if($this->_Service == null)
    	{
    		$this->_Service = Mage::getModel('bkgviewer/service_service')->load($this->getServiceLayer()->getServiceId());
    	}
    	return $this->_Service ;
    }
    
    /**
     * 
     * @return Bkg_Viewer_Model_Service_Layer
     */
    public function getServiceLayer()
    {
    	if($this->_ServiceLayer == null)
    	{
    		$this->_ServiceLayer = Mage::getModel('bkgviewer/service_layer')->load($this->getServiceLayerId());
    	}
    	return $this->_ServiceLayer ;
    }
    
    
    /**
     * Kind hinzufügen und sortieren
     * @param Bkg_Viewer_Model_Composit_Layer $node
     */
    public function addChild(Bkg_Viewer_Model_Composit_Layer $node)
    {
    	//sortieren
    	$tmp = array();
    
    
    	foreach ($this->_children as $item)
    	{
    		if($node)
    		{
    			if($item->getPos() < $node->getPos())
    			{
    				$tmp[] = $item;
    			}
    			else {
    				$tmp[] = $node;
    				$tmp[] = $item;
    				$node = null;
    			}
    		}else{
    			$tmp[] = $item;
    		}
    	}
    	if($node)
    	{
    		$tmp[] = $node;
    	}
    
    	$this->_children = $tmp;
    }
    
    
    /**
     * alle Kinder nach der Id durchsuchen
     * @param string $id
     * @param string $recursiv
     * @return Bkg_Viewer_Model_Composit_Layer|NULL
     */
    public function getChild($id, $recursiv = false)
    {
    	foreach ($this->_children as $item)
    	{
    		if($item->getId() == $id){
    			return $item;
    		}
    		if($recursiv){
    			$tmp = $item->getChild($id,true);
    			if($tmp){
    				return $tmp;
    			}
    		}
    	}
    
    	return null;
    }
    
    public function getChildrenArray($recursiv = false)
    {
    	$result = array();
    	foreach ($this->_children as $item)
    	{
    		$result[] = $item;
    		if($recursiv){
    			$tmp = $item->getChildrenArray(true);
    			$result = array_merge($result,$tmp);
    		}
    	}
    
    	return $result;
    }
    
    public function getChildren()
    {
    	return $this->_children;
    }
}
