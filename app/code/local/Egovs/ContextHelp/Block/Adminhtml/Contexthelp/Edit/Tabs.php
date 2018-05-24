<?php
/**
 *
 * @category   	Egovs ContextHelp
 * @package    	Egovs_ContextHelp
 * @name       	Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('contexthelp_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('contexthelp')->__('Contexthelp Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('contexthelp')->__('Contexthelp Information'),
          'title'     => Mage::helper('contexthelp')->__('Contexthelp Information'),
          'content'   => $this->getLayout()->createBlock('contexthelp/adminhtml_contexthelp_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
