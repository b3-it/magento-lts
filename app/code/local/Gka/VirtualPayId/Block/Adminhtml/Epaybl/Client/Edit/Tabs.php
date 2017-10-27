<?php
/**
 *
 * @category   	Gka Virtualpayid
 * @package    	Gka_VirtualPayId
 * @name       	Gka_VirtualPayId_Block_Adminhtml_Epaybl_Client_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_VirtualPayId_Block_Adminhtml_Epaybl_Client_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('epayblclient_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('virtualpayid')->__('Epaybl Client Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('virtualpayid')->__('Epaybl Client Information'),
          'title'     => Mage::helper('virtualpayid')->__('Epaybl Client Information'),
          'content'   => $this->getLayout()->createBlock('virtualpayid/adminhtml_epaybl_client_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
