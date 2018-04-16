<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Service_Crs_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Block_Adminhtml_Usetype_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    protected $_ssw = null;
  public function __construct()
  {
      parent::__construct();
      $this->setId('servicecrs_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkgviewer')->__('Item Information'));
      $this->setTemplate('bkg/widget/tabs.phtml');

  }

  public function getStoreSwitcher()
  {
      if($this->_ssw == null) {
          $this->_ssw = $this->getLayout()->createBlock('adminhtml/store_switcher');
      }

      return $this->_ssw;
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('bkg_tollpolicy')->__('Type of Use'),
          'title'     => Mage::helper('bkg_tollpolicy')->__('Type of Use'),
          'content'   => $this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_usetype_edit_tab_form')->toHtml(),
      ));

      $this->addTab('form_section1', array(
          'label'     => Mage::helper('bkg_tollpolicy')->__('Type of Use Options'),
          'title'     => Mage::helper('bkg_tollpolicy')->__('Type of Use Options'),
          'content'   => $this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_usetype_edit_tab_options')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
