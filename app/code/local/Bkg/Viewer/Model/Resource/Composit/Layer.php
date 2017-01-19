<?php
 /**
  *
  * @category   	Bkg Viewer
  * @package    	Bkg_Viewer
  * @name       	Bkg_Viewer_Model_Resource_Composit_Layer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Viewer_Model_Resource_Composit_Layer extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('bkgviewer/composit_layer', 'id');
    }
    
//     /**
//      * Kind hinzufügen und sortieren
//      * @param Sid_Cms_Model_Resource_Node $node
//      */
//     public function addChild(Bkg_Viewer_Model_Resource_Composit_Layer $node)
//     {
//     	//sortieren
//     	$tmp = array();
    	 
    	 
//     	foreach ($this->_children as $item)
//     	{
//     		if($item->getPos() < $node->getPos())
//     		{
//     			$tmp[] = $item;
//     		}
//     		else {
//     			$tmp[] = $node;
//     			$tmp[] = $item;
//     			$node = null;
//     		}
//     	}
//     	if($node)
//     	{
//     		$tmp[] = $node;
//     	}
    	 
//     	$this->_children = $tmp;
//     }
    
    
//     /**
//      * alle Kinder nach der Id durchsuchen
//      * @param unknown $id
//      * @param string $recursiv
//      * @return Bkg_Viewer_Model_Resource_Composit_Layer[]|unknown[]|NULL[]|unknown|NULL
//      */
//     public function getChild($id, $recursiv = false)
//     {
//     	foreach ($this->_children as $item)
//     	{
//     		if($item->getId() == $id){
//     			return $item;
//     		}
//     		if($recursiv){
//     			$tmp = $item->getCild($id,true);
//     			if($tmp){
//     				return $tmp;
//     			}
//     		}
//     	}
    	 
//     	return null;
//     }
    
//     public function getChildrenArray($recursiv = false)
//     {
//     	$result = array();
//     	foreach ($this->_children as $item)
//     	{
//     		$result[] = $item;
//     		if($recursiv){
//     			$tmp = $item->getChildrenArray(true);
//     			$result = array_merge($result,$tmp);
//     		}
//     	}
    	 
//     	return $result;
//     }
}
