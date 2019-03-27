<?php
/**
 *
 * @category   	Gka Internalpayid
 * @package    	Gka_InternalPayId
 * @name       	Gka_InternalPayId_Block_Adminhtml_Epaybl_Client_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_InternalPayId_Block_Adminhtml_Epaybl_Client_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('epayblclient_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('internalpayid')->__('Specialized Procedure Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('internalpayid')->__('Specialized Procedure Information'),
          'title'     => Mage::helper('internalpayid')->__('Specialized Procedure Information'),
          'content'   => $this->getLayout()->createBlock('internalpayid/adminhtml_epaybl_client_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
