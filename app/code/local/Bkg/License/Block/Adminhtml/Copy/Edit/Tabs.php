<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('entity_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkg_license')->__('Copy License'));
  }

  protected function _beforeToHtml()
  {

      $id = Mage::registry('entity_data')->getId();
      $this->addTab('form_section', array(
          'label'     => Mage::helper('bkg_license')->__('Copy License Information'),
          'title'     => Mage::helper('bkg_license')->__('Copy License Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_form')->toHtml(),
      ));
      if($id) {
          $this->addTab('form_section1a', array(
              'label' => Mage::helper('bkg_license')->__('Address'),
              'title' => Mage::helper('bkg_license')->__('Address Information'),
              'content' => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_address')->toHtml(),
          ));
          
         // if(Mage::registry('entity_data')->getIsOrgunit())
          {
	          $this->addTab('form_section1b', array(
	          		'label' => Mage::helper('bkg_license')->__('Authorized Customer'),
	          		'title' => Mage::helper('bkg_license')->__('Authorized Customer'),
	          		'content' => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_authorizedcustomer')->toHtml(),
	          ));
          }
      }
      $this->addTab('form_section1c', array(
          'label'     => Mage::helper('bkg_license')->__('Agreement'),
          'title'     => Mage::helper('bkg_license')->__('Agreement Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_agreement')->toHtml(),
      ));

      $this->addTab('form_section2', array(
          'label'     => Mage::helper('bkg_license')->__('Template'),
          'title'     => Mage::helper('bkg_license')->__('Template Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_template')->toHtml(),
      ));

      $this->addTab('form_section2a', array(
      		'label'     => Mage::helper('bkg_license')->__('Text'),
      		'title'     => Mage::helper('bkg_license')->__('Text Information'),
      		'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_text')->toHtml(),
      ));

      $this->addTab('form_section3', array(
          'label'     => Mage::helper('bkg_license')->__('Type Of Use'),
          'title'     => Mage::helper('bkg_license')->__('Toll Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_toll')->toHtml(),
      ));

      $this->addTab('form_section4', array(
      		'label'     => Mage::helper('bkg_license')->__('Fee Discount'),
      		'title'     => Mage::helper('bkg_license')->__('Fee Discount'),
      		'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_fees')->toHtml(),
      ));


      $this->addTab('form_section5', array(
          'label'     => Mage::helper('bkg_license')->__('Customer Group'),
          'title'     => Mage::helper('bkg_license')->__('Customer Group Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_customergroup')->toHtml(),
      ));

      $this->addTab('form_section6', array(
          'label'     => Mage::helper('bkg_license')->__('Product'),
          'title'     => Mage::helper('bkg_license')->__('Product Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_product')->toHtml(),
      ));

      $this->addTab('form_section8', array(
      		'label'     => Mage::helper('bkg_license')->__('Subscription'),
      		'title'     => Mage::helper('bkg_license')->__('Subscription Information'),
      		'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_subscription')->toHtml(),
      ));

      if($id)
      {
          $content = $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_file');
          $content->setId($this->getHtmlId() . '_file')->setElement($this);

          $this->addTab('form_section7', array(
	          'label'     => Mage::helper('bkg_license')->__('File'),
	          'title'     => Mage::helper('bkg_license')->__('File'),
              'content'   => $content->toHtml(), // $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_file')->toHtml(),
	      ));
      }
      return parent::_beforeToHtml();
  }
}
