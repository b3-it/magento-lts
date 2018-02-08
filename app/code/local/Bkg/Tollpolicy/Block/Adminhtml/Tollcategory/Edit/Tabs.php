<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Block_Adminhtml_Tollcategory_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Block_Adminhtml_Tollcategory_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('toll_category_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkg_tollpolicy')->__('Toll Category Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('bkg_tollpolicy')->__('Toll Category Information'),
          'title'     => Mage::helper('bkg_tollpolicy')->__('Toll Category Information'),
          'content'   => $this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_tollcategory_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
