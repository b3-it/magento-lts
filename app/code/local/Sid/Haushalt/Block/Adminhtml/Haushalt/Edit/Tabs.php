<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Block_Adminhtml_Haushalt_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('haushalt_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('haushalt')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('haushalt')->__('Item Information'),
          'title'     => Mage::helper('haushalt')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('haushalt/adminhtml_haushalt_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}