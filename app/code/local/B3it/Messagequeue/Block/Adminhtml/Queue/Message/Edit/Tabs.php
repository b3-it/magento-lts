<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Block_Adminhtml_Queue_Message_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Block_Adminhtml_Queue_Message_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('queuemessage_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('b3it_mq')->__('Queue Message Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('b3it_mq')->__('Queue Message Information'),
          'title'     => Mage::helper('b3it_mq')->__('Queue Message Information'),
          'content'   => $this->getLayout()->createBlock('b3it_mq/adminhtml_queue_message_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
