<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category B3it
 *  @package  B3it_Pendelliste
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_Pendelliste_Block_Adminhtml_Pendelliste_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('pendelliste_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('pendelliste')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('pendelliste')->__('Item Information'),
          'title'     => Mage::helper('pendelliste')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('pendelliste/adminhtml_pendelliste_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}