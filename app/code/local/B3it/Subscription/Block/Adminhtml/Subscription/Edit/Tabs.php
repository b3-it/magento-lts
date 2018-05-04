<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Block_Adminhtml_Subscription_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Block_Adminhtml_Subscription_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('subscription_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('b3it_subscription')->__('Subscription Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('b3it_subscription')->__('Subscription Information'),
          'title'     => Mage::helper('b3it_subscription')->__('Subscription Information'),
          'content'   => $this->getLayout()->createBlock('b3it_subscription/adminhtml_subscription_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}