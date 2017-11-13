<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_Adminhtml_Kassenbuch_Cashbox_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Cashbox_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('kassenbuchcashbox_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('gka_barkasse')->__('Barkasse Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('gka_barkasse')->__('Details'),
          'title'     => Mage::helper('gka_barkasse')->__('Details'),
          'content'   => $this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuch_cashbox_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
