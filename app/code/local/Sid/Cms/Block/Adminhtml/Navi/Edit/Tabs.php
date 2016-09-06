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
class Sid_Cms_Block_Adminhtml_Navi_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('navi_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sidcms')->__('Navigation'));
      $this->setTemplate('sid/navigation/tabs.phtml');
  }
  
 
	

	public function getNodes()
	{
		$navi = Mage::registry('navi_data');
		$collection = Mage::getModel('sidcms/node')->getCollection();
		$res = $collection->getNodesAsArray($navi->getId(),true);
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
	
  
  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sidcms')->__('Base Settings'),
          'title'     => Mage::helper('sidcms')->__('Base Settings'),
          'content'   => $this->getLayout()->createBlock('sidcms/adminhtml_navi_edit_tab_form')->toHtml(),
      ));
      
      return parent::_beforeToHtml();
  }
}