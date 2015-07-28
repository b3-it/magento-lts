<?php
/**
 *
 *  Edit Formular für pdf Template
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Block_Adminhtml_Template_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('template_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('pdftemplate')->__('PDF Template'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('pdftemplate')->__('Template Information'),
          'title'     => Mage::helper('pdftemplate')->__('General'),
          'content'   => $this->getLayout()->createBlock('pdftemplate/adminhtml_template_edit_tab_form')->toHtml(),
      ));
     
     $this->addTab('header_section', array(
          'label'     => Mage::helper('pdftemplate')->__('Header'),
          'title'     => Mage::helper('pdftemplate')->__('General'),
          'content'   => $this->getLayout()->createBlock('pdftemplate/adminhtml_template_edit_tab_header')->toHtml(),
      ));
      
     $this->addTab('marginal_section', array(
          'label'     => Mage::helper('pdftemplate')->__('Marginal'),
          'title'     => Mage::helper('pdftemplate')->__('General'),
          'content'   => $this->getLayout()->createBlock('pdftemplate/adminhtml_template_edit_tab_marginal')->toHtml(),
      ));
      
     $this->addTab('address_section', array(
          'label'     => Mage::helper('pdftemplate')->__('Address'),
          'title'     => Mage::helper('pdftemplate')->__('General'),
          'content'   => $this->getLayout()->createBlock('pdftemplate/adminhtml_template_edit_tab_address')->toHtml(),
      ));
      
     $this->addTab('body_section', array(
          'label'     => Mage::helper('pdftemplate')->__('Body'),
          'title'     => Mage::helper('pdftemplate')->__('General'),
          'content'   => $this->getLayout()->createBlock('pdftemplate/adminhtml_template_edit_tab_body')->toHtml(),
      ));
      
     $this->addTab('footer_section', array(
          'label'     => Mage::helper('pdftemplate')->__('Footer'),
          'title'     => Mage::helper('pdftemplate')->__('General'),
          'content'   => $this->getLayout()->createBlock('pdftemplate/adminhtml_template_edit_tab_footer')->toHtml(),
      ));
      
      return parent::_beforeToHtml();
  }
}