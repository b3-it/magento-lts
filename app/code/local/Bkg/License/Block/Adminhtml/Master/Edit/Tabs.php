<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('entity_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkg_license')->__('Master License'));
  }

  protected function _beforeToHtml()
  {

      $this->addTab('form_section', array(
          'label'     => Mage::helper('bkg_license')->__('Master License Information'),
          'title'     => Mage::helper('bkg_license')->__('Master License Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_master_edit_tab_form')->toHtml(),
      ));

      $this->addTab('form_section1', array(
          'label'     => Mage::helper('bkg_license')->__('Agreement'),
          'title'     => Mage::helper('bkg_license')->__('Agreement Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_master_edit_tab_agreement')->toHtml(),
      ));

      $this->addTab('form_section2', array(
          'label'     => Mage::helper('bkg_license')->__('Text'),
          'title'     => Mage::helper('bkg_license')->__('Text Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_master_edit_tab_text')->toHtml(),
      ));

      $this->addTab('form_section3', array(
          'label'     => Mage::helper('bkg_license')->__('Type Of Use'),
          'title'     => Mage::helper('bkg_license')->__('Toll Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_master_edit_tab_toll')->toHtml(),
      ));

      $this->addTab('form_section4', array(
      		'label'     => Mage::helper('bkg_license')->__('Fee Discount'),
      		'title'     => Mage::helper('bkg_license')->__('Fee Discount'),
      		'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_master_edit_tab_fees')->toHtml(),
      ));
      

      $this->addTab('form_section5', array(
          'label'     => Mage::helper('bkg_license')->__('Customer Group'),
          'title'     => Mage::helper('bkg_license')->__('Customer Group Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_master_edit_tab_customergroup')->toHtml(),
      ));

      $this->addTab('form_section6', array(
          'label'     => Mage::helper('bkg_license')->__('Product'),
          'title'     => Mage::helper('bkg_license')->__('Product Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_master_edit_tab_product')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
