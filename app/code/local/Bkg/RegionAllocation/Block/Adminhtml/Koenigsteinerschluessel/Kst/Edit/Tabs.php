<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name       	Bkg_Regionallocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_RegionAllocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('koenigsteinerschluesselkst_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('regionallocation')->__('Koenigsteinerschluessel'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('regionallocation')->__('Details'),
          'title'     => Mage::helper('regionallocation')->__('Details'),
          'content'   => $this->getLayout()->createBlock('regionallocation/adminhtml_koenigsteinerschluessel_kst_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('form_section1', array(
      		'label'     => Mage::helper('regionallocation')->__('Region Information'),
      		'title'     => Mage::helper('regionallocation')->__('Region Information'),
      		'content'   => $this->getLayout()->createBlock('regionallocation/adminhtml_koenigsteinerschluessel_kst_edit_tab_kstvalue')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
