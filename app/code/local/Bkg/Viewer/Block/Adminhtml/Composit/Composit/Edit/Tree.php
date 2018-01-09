<?php
/**
 * Sid Cms
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Block_Adminhtml_Navi_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Composit_Composit_Edit_Tree extends Mage_Adminhtml_Block_Widget
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('navi_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkgviewer')->__('Navigation'));
      $this->setTemplate('bkg/viewer/composit/edit/tree.phtml');
  }
  
 
	

	public function getNodes()
	{
		$res = array();
		$composit = Mage::registry('compositcomposit_data');
		/** @var $collection Bkg_Viewer_Model_Resource_Composit_Layer_Collection */
		$collection = Mage::getModel('bkgviewer/composit_layer')->getCollection();
		$res = $collection->getNodesAsArray($composit->getId(),true);
		return $res;
	}
  
  
	public function getPages()
	{
		$collection = Mage::getModel('cms/page')->getCollection();
		$res = array();
		foreach ($collection as $item)
		{
			$res[$item->getPageId()] = $item->getTitle();
		}
		return $res;
	}
	
  
 
}