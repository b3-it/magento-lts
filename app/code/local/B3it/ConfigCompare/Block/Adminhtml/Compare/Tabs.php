<?php
/**
 * B3it ConfigCompare
 * 
 * 
 * @category   	B3it
 * @package    	B3it_ConfigCompare
 * @name       	B3it_ConfigCompare_Block_Adminhtml__Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_ConfigCompare_Block_Adminhtml_Compare_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('_tabs');
        $this->setDestElementId('edit_form');
        // $this->setTitle(Mage::helper('configcompare')->__('Item Information'));
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see Mage_Adminhtml_Block_Widget_Tabs::_beforeToHtml()
     */
  protected function _beforeToHtml()
  {
  	
      $this->addTab('form_section', array(
          'label'     => Mage::helper('configcompare')->__('Core Config Data'),
          'title'     => Mage::helper('configcompare')->__('Core Config Data'),
          'content'   => $this->getLayout()->createBlock('configcompare/adminhtml_compare_tab_coredata')->toHtml(),
      ));
      
       $this->addTab('form_section2', array(
       		'label'     => Mage::helper('configcompare')->__('Cms Pages'),
       		'title'     => Mage::helper('configcompare')->__('Cms Pages'),
       		'content'   => $this->getLayout()->createBlock('configcompare/adminhtml_compare_tab_cmspages')->toHtml(),
       ));
      
      $this->addTab('form_section3', array(
      		'label'     => Mage::helper('configcompare')->__('Cms Blocks'),
      		'title'     => Mage::helper('configcompare')->__('Cms Blocks'),
      		'content'   => $this->getLayout()->createBlock('configcompare/adminhtml_compare_tab_cmsblocks')->toHtml(),
      ));
     
      $this->addTab('form_section4', array(
      		'label'     => Mage::helper('configcompare')->__('Pdf Sections'),
      		'title'     => Mage::helper('configcompare')->__('Pdf Sections'),
      		'content'   => $this->getLayout()->createBlock('configcompare/adminhtml_compare_tab_pdfsections')->toHtml(),
      ));
       
      $this->addTab('form_section5', array(
      		'label'     => Mage::helper('configcompare')->__('Pdf Blocks'),
      		'title'     => Mage::helper('configcompare')->__('Pdf Blocks'),
      		'content'   => $this->getLayout()->createBlock('configcompare/adminhtml_compare_tab_pdfblocks')->toHtml(),
      ));
      
      $this->addTab('form_section6', array(
      		'label'     => Mage::helper('configcompare')->__('E-Mail Templates'),
      		'title'     => Mage::helper('configcompare')->__('E-Mail Templates'),
      		'content'   => $this->getLayout()->createBlock('configcompare/adminhtml_compare_tab_emailtemplates')->toHtml(),
      ));
       
      $this->addTab('form_section7', array(
      		'label'     => Mage::helper('configcompare')->__('Tax Calculation'),
      		'title'     => Mage::helper('configcompare')->__('Tax Calculation'),
      		'content'   => $this->getLayout()->createBlock('configcompare/adminhtml_compare_tab_taxcalculation')->toHtml(),
      ));
       
      return parent::_beforeToHtml();
  }
}