<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Resource_Composit_Layer_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Model_Resource_Composit_Layer_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/composit_layer');
    }
    
    /**
     * die Knoten müssen enstprechend ihre Abhängigkeiten (ein)sortiert werden
     * @param array $naviId
     * @return Bkg_Viewer_Model_Resource_Composit_Layer Dummy Root Node
     */
    private function _getNodeTree($compositId, $addServiceLayer = false)
    {
    	$this->getSelect()->where('composit_id = '.intval($compositId));
    	if($addServiceLayer){
    		$this->getSelect()->joinLeft(array('layer'=>$this->getTable('bkgviewer/service_layer')), 'main_table.service_layer_id=layer.id',array('layer_name'=>'title'));
    	}
    	//die($this->getSelect()->__toString());
    	$allItems = $this->getItems();
    	 
    	$root = Mage::getModel('bkgviewer/composit_layer');
    	 
    	$n = 0;
    	while((count($allItems) > 0) && ($n < 50))
    	{
    		$tmp = array();
    		foreach($allItems as $item){
    			$item->setIsChecked(boolval($item->getIsChecked()));
    			$item->setPermanent(boolval($item->getPermanent()));
    			if($item->getParentId() == null)
    			{
    				$root->addChild($item);
    			}else
    			{
    				$node = $root->getChild($item->getParentId(),true);
    				if($node){
    					$node->addChild($item);
    				}else{
    					$tmp[] = $item;
    				}
    			}
    		}
    		$allItems = $tmp;
    		$n++;
    	}
    	 
    	return $root;
    	 
    }
    
    public function getNodesAsArray($naviId, $addCmsPage = false)
    {
    	$root = $this->_getNodeTree($naviId,$addCmsPage);
    	return $root->getChildrenArray(true);
    }
    
    public function getNodesTree($naviId, $addCmsPage = false)
    {
    	$root = $this->_getNodeTree($naviId,$addCmsPage);
    	return $root;
    }
    
}
