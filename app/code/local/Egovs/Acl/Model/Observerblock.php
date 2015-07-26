<?php
/**
 * 
 *  Observer um Buttons in Abhängigkeit der Berechtigungen zu entfernen
 *  @category Egovs
 *  @package  Egovs_Acl
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Acl_Model_Observerblock extends Mage_Catalog_Model_Product
{
	private $_config_node = null;
	
	/**
	 * config lesen aus global/egovsacl/block_buttons
	 * @return Mage_Core_Model_Config_Element
	 */
	private function getConfigNode()
	{
		if($this->_config_node == null)
		{
			$this->_config_node = Mage::getConfig()->getNode('global/egovsacl/block_buttons')->asArray();
		}
		return $this->_config_node;
	}
	
   private function getButtonPermissions($block)
   {
   		$node = $this->getConfigNode();
   		if($node === false){
   			return false;
   		}
   		
   		$block = get_class($block);
   		if(!isset($node[$block])){
   		//if(!array_key_exists($block,$node)){
   			return false;
   		}
   		
   		return $node[$block];
   }
   

   public function onBlockPrepareLayoutAfter($observer)
   {
   		/*@var $block Mage_Adminhtml_Block_Template */ 
   		$block = $observer->getBlock();
   		if(!$block){
   			return;
   		}
   		
   		$perm = $this->getButtonPermissions($block);
   		
   		if($perm === false){
   			return;
   		}
   		
   		$admin = Mage::getSingleton('admin/session');
   		
   		foreach ($perm as $button=>$path)
   		{
   			if(!$admin->isAllowed($path))
   			{
   				if(method_exists($block,'removeButton')){
   					$block->removeButton($button);
   				}else if(method_exists($block,'unsetChild')){
   					$block->unsetChild($button);
   				}
   			}
   		}
   		
   }
   
   
 
	
}
