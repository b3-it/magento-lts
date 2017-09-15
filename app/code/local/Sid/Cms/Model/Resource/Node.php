<?php
/**
 * Sid_Cms Navi
 *
 *
 * @category   	Sid_Cms
 * @package    	Sid_Cms_Navi
 * @name       	Sid_Cms_Model_Resource_Node
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Model_Resource_Node extends Mage_Core_Model_Resource_Db_Abstract
{
    
	private $_children = array();
	
	public function _construct()
    {
        // Note that the navi_node_id refers to the key field in your database table.
        $this->_init('sidcms/navigation_node', 'id');
    }
    
    public function toJson()
    {
    	return Mage::helper('core')->jsonEncode($this);
    }
    
    
    /**
     * Kind hinzufügen und sortieren
     * @param Sid_Cms_Model_Resource_Node $node
     */
    public function addChild(Sid_Cms_Model_Resource_Node $node)
    {
    	//sortieren
    	$tmp = array();
    	
    	
    	foreach ($this->_children as $item)
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
    	}
    	if($node)
    	{
    		$tmp[] = $node;
    	}
    	
    	$this->_children = $tmp;
    }
    
    
    /**
     * alle Kinder nach der Id durchsuchen
     * @param int $id
     * @param string $recursiv
     * @return Sid_Cms_Model_Resource_Node[]|NULL[]
     */
    public function getChild($id, $recursiv = false)
    {
    	foreach ($this->_children as $item)
    	{
    		if($item->getId() == $id){
    			return $item;
    		}
    		if($recursiv){
    			$tmp = $item->getCild($id,true);
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
    
}
