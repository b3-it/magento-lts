<?php
/**
 * Sid ExportOrder
 * 
 * 
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Block_Adminhtml_Export_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Block_Adminhtml_Export_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('export_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('exportorder')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('exportorder')->__('Order Information'),
          'title'     => Mage::helper('exportorder')->__('Order Information'),
          'content'   => $this->getLayout()->createBlock('sid_exportorder/adminhtml_export_edit_tab_form')->toHtml(),
      ));
     
      
      $this->addTab('form_section1', array(
      		'label'     => Mage::helper('exportorder')->__('Export Information'),
      		'title'     => Mage::helper('exportorder')->__('Export Information'),
      		'content'   => $this->getLayout()->createBlock('sid_exportorder/adminhtml_export_edit_tab_export')->toHtml(),
      ));
      
      $this->addTab('form_section2', array(
      		'label'     => Mage::helper('exportorder')->__('Download Information'),
      		'title'     => Mage::helper('exportorder')->__('Download Information'),
      		'content'   => $this->getLayout()->createBlock('sid_exportorder/adminhtml_export_edit_tab_download')->toHtml(),
      ));
       
      return parent::_beforeToHtml();
  }
}