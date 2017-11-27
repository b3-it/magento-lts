<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Gka
 *  @package  Gka_Reports
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_Reports_Block_Adminhtml_Reports_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('reports_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('reports')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('reports')->__('Item Information'),
          'title'     => Mage::helper('reports')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('reports/adminhtml_reports_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}