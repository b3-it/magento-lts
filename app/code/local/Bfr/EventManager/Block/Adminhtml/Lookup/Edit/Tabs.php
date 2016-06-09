<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Lookup_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Lookup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('lookup_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('eventmanager')->__('Lookup Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('eventmanager')->__('Lookup Information'),
          'title'     => Mage::helper('eventmanager')->__('Lookup Information'),
          'content'   => $this->getLayout()->createBlock('eventmanager/adminhtml_lookup_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}