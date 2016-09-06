<?php
/**
 * Sid_Cms Navi
 *
 *
 * @category   	Sid_Cms
 * @package    	Sid_Cms_Navi
 * @name       	Sid_Cms_Model_Resource_Node_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Model_Resource_Node_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('sidcms/node');
    }
    
    /**
     * die Knoten müssen enstprechend ihre Abhängigkeiten (ein)sortiert werden
     * @param array $naviId
     * @return Sid_Cms_Model_Resource_Node Dummy Root Node
     */
    private function _getNodeTree($naviId, $addCmsPage = false)
    {
    	$this->getSelect()->where('navi_id = '.intval($naviId));
    	if($addCmsPage){
    		$this->getSelect()->joinLeft(array('page'=>$this->getTable('cms/page')), 'main_table.page_id=page.page_id',array('title','is_active'));
    	}
    	//die($this->getSelect()->__toString());
    	$allItems = $this->getItems();
    	
    	$root = Mage::getModel('sidcms/node');
    	
    	$n = 0;
    	while((count($allItems) > 0) && ($n < 50))
    	{
    		$tmp = array();
    		foreach($allItems as $item){
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
