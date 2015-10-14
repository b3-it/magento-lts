<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Dwd
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Dwd_Abomigration_Block_Adminhtml_Abomigration_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('abomigration_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('abomigration')->__('Migration Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('abomigration')->__('Migration Details'),
          'title'     => Mage::helper('abomigration')->__('Migration Details'),
          'content'   => $this->getLayout()->createBlock('abomigration/adminhtml_abomigration_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}