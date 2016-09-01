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
  
  protected function _prepareLayout()
  {
  	$addUrl = $this->getUrl("*/*/add", array(
  			'_current'=>true,
  			'id'=>null,
  			'_query' => false
  	));
  
  	$this->setChild('add_sub_button',
  			$this->getLayout()->createBlock('adminhtml/widget_button')
  			->setData(array(
  					'label'     => Mage::helper('catalog')->__('Add Subcategory'),
  					'onclick'   => "addNew('".$addUrl."', false)",
  					'class'     => 'add',
  					'id'        => 'add_subcategory_button',
  					//'style'     => $this->canAddSubCategory() ? '' : 'display: none;'
  			))
  	);
  }

	public function getNodes()
	{
		$collection = Mage::getModel('sidcms/navi')->getCollection();
	}
  
  
  
  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sidcms')->__('Base Settings'),
          'title'     => Mage::helper('sidcms')->__('Base Settings'),
          'content'   => $this->getLayout()->createBlock('sidcms/adminhtml_navi_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('child_section', array(
      		'label'     => Mage::helper('sidcms')->__('Child Settings'),
      		'title'     => Mage::helper('sidcms')->__('Child Settings'),
      		'content'   => $this->getLayout()->createBlock('sidcms/adminhtml_navi_edit_tab_child')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}