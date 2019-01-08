<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_Adminhtml_Unit_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_Adminhtml_Unit_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('unit_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkg_orgunit')->__('Organisation'));
  }

  protected function _beforeToHtml()
  {

      $this->addTab('form_section', array(
          'label'     => Mage::helper('bkg_orgunit')->__('Organisation Information'),
          'title'     => Mage::helper('bkg_orgunit')->__('Organisation Information'),
          'content'   => $this->getLayout()->createBlock('bkg_orgunit/adminhtml_unit_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('form_section2', array(
      		'label'     => Mage::helper('bkg_orgunit')->__('Addresses'),
      		'title'     => Mage::helper('bkg_orgunit')->__('Addresses'),
      		'content'   => $this->getLayout()->createBlock('bkg_orgunit/adminhtml_unit_edit_tab_addresses')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
