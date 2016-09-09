<?php
/**
 * 
 *  Anzeige der noch nicht gebuchten Optionen im Benutrzerkontext 
 *  @category Egovs
 *  @package  Egovs_EventBundle
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Block_Navbar extends Mage_Core_Block_Template
{
 
	private $_Navigation = null;
	private $_RootNode = null;

	/**
	 * Kunden aus der Session ermitteln
	 */
	protected function getCustomer()
	{
		if ($this->_Customer === null) {
			$this->_Customer = Mage::getSingleton('customer/session')->getCustomer();
		}
		return $this->_Customer;
	}
	
	public function isAvialable()
	{
		if($this->getNavigation()){
			$children = $this->_getRootNode()->getChildren();
			if(count($children) > 0){
				return true;
			}
		}
		
		return false;
	}

	public function getNavigation()
	{
		if($this->_Navigation == null){
			$store_id = Mage::app()->getStore()->getId();
			$this->_Navigation = Mage::getModel('sidcms/navi')->load($store_id, 'store_id');
		}
		return $this->_Navigation;
	}
	
	public function getTitle()
	{
		$navi = $this->getNavigation();
		if($navi){
			return $navi->getTitle();
		}
		
		return false;
	}
	
	
	private function _getRootNode()
	{
		if($this->_RootNode == null){
			$navi = $this->getNavigation();
			
			$collection = Mage::getModel('sidcms/node')->getCollection();
			$this->_RootNode = $collection->getNodesTree($navi->getId(),true);
		}
		
		return $this->_RootNode;
	}
	
	public function getPagesHtml()
	{
		
		return $this->getNodeHtml($this->_getRootNode());
	}
	
	public function getNodeHtml($node, $level = 0)
	{
		$level++;
		$html = array();
		if($node->getType() == 'default'){
			$html[] = '<a href="javascript:void(0);" class="egov-arrow-main-open">'. $node->getLabel().'</a>';
		}elseif($node->getType() == 'page'){
			if($node->getIsActive() == Mage_Cms_Model_Page::STATUS_ENABLED){
				$html[] = '<a href="'.Mage::helper('cms/page')->getPageUrl($node->getPageId()).'" class="">';
				$html[] = $node->getLabel();
				$html[] = "</a>";
			}
		}
		
		if(count($node->getChildren()) > 0)
		{
			$html[] = '<ul>';
			foreach($node->getChildren() as $child)
			{
				$html[] = '<li class="level'.$level.'">';
				$html[] = $this->getNodeHtml($child, $level);
				$html[] = "</li>";
			}
			$html[] = "</ul>";
		}
		
		return implode("\n",$html);
	}
	
	
	
}
