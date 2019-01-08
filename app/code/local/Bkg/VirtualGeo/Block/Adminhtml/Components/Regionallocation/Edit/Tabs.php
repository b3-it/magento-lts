<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Regionallocation_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Regionallocation_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('componentsregionallocation_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkg_virtualGeo')->__('Components Regionallocation Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('bkg_virtualGeo')->__('Components Regionallocation Information'),
          'title'     => Mage::helper('bkg_virtualGeo')->__('Components Regionallocation Information'),
          'content'   => $this->getLayout()->createBlock('bkg_virtualGeo/adminhtml_components_regionallocation_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
