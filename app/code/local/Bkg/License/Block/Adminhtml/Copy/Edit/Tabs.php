<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Copy_Entity_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('copyentity_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkg_license')->__('Copy Entity Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('bkg_license')->__('Copy Entity Information'),
          'title'     => Mage::helper('bkg_license')->__('Copy Entity Information'),
          'content'   => $this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
