<?php
/**
 * Verwalten von Dokumenten im Webshop.
 *
 * @category	Egovs
 * @package		Egovs_Doc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Doc_Block_Adminhtml_Doc_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('doc_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('egovs_doc')->__('Document Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('egovs_doc')->__('Documentdetails'),
          'title'     => Mage::helper('egovs_doc')->__('Documentdetails'),
          'content'   => $this->getLayout()->createBlock('egovs_doc/adminhtml_doc_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}