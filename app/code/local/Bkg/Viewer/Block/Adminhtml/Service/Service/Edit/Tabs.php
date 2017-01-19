<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Service_Service_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Service_Service_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('serviceservice_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkgviewer')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('bkgviewer')->__('Service Information'),
          'title'     => Mage::helper('bkgviewer')->__('Service Information'),
          'content'   => $this->getLayout()->createBlock('bkgviewer/adminhtml_service_service_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('form_section2', array(
      		'label'     => Mage::helper('bkgviewer')->__('Layer Information'),
      		'title'     => Mage::helper('bkgviewer')->__('Layer Information'),
      		'content'   => $this->getLayout()->createBlock('bkgviewer/adminhtml_service_service_edit_tab_layer')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
