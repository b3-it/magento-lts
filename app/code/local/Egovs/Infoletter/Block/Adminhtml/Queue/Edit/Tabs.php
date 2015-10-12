<?php
/**
 * Egovs Infoletter
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Block_Adminhtml_Queue_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Block_Adminhtml_Queue_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('queue_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('infoletter')->__('Infomation Letter Details'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('infoletter')->__('Queue Information'),
          'title'     => Mage::helper('infoletter')->__('Queue Information'),
          'content'   => $this->getLayout()->createBlock('infoletter/adminhtml_queue_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('form_section_recipients', array(
      		'label'     => Mage::helper('infoletter')->__('Recipients Information'),
      		'title'     => Mage::helper('infoletter')->__('Recipients Information'),
      		'content'   => $this->getLayout()->createBlock('infoletter/adminhtml_queue_edit_tab_recipients')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}