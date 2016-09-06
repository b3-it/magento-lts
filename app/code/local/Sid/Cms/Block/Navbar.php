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
	
	

	public function getNavigation()
	{
		if($this->_Navigation == null){
			$store_id = Mage::app()->getStore()->getId();
			$this->_Navigation = Mage::getModel('sidcms/navi')->load($store_id, 'store_id');
		}
		return $this->_Navigation;
	}
	
	public function getPagesHtml()
	{
		
		$navi = $this->getNavigation();
		
		$collection = Mage::getModel('sidcms/node')->getCollection();
		$root = $collection->getNodesTree($navi->getId(),true);
		return $this->getNodeHtml($root);
	}
	
	public function getNodeHtml($node)
	{
		$html = array();
		if($node->getType() == 'default'){
			$html[] = $node->getLabel();
		}elseif($node->getType() == 'page'){
			if($node->getIsActive() == Mage_Cms_Model_Page::STATUS_ENABLED){
				$html[] = '<a href="'.Mage::helper('cms/page')->getPageUrl($node->getPageId()).'">';
				$html[] = $node->getLabel();
				$html[] = "</a>";
			}
		}
		if(count($node->getChildren()) > 0)
		{
			$html[] = "<ol>";
			foreach($node->getChildren() as $child)
			{
				$html[] = "<li>";
				$html[] = $this->getNodeHtml($child);
				$html[] = "</li>";
			}
			$html[] = "</ol>";
		}
		
		return implode("\n",$html);
	}
	
	
	
}
