<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Account_Edit_Tabs
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Account_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('account_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('dwd_icd')->__('ICD Account'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('dwd_icd')->__('Details'),
          'title'     => Mage::helper('dwd_icd')->__('Details'),
          'content'   => $this->getLayout()->createBlock('dwd_icd/adminhtml_account_edit_tab_form')->toHtml(),
      ));
      
      $debug = (bool) Mage::getStoreConfigFlag('dwd_icd/debug/is_debug');
      if($debug)
      {
      	
      	$this->addTab('form_section1', array(
      			'label'     => Mage::helper('dwd_icd')->__('Debug'),
      			'title'     => Mage::helper('dwd_icd')->__('Debug'),
      			'content'   => $this->getLayout()->createBlock('dwd_icd/adminhtml_account_edit_tab_log')->toHtml(),
      	));
      	
      	
      	$this->addTab('form_section2', array(
      			'label'     => Mage::helper('dwd_icd')->__('Groups'),
      			'title'     => Mage::helper('dwd_icd')->__('Groups'),
      			'content'   => $this->getLayout()->createBlock('dwd_icd/adminhtml_account_edit_tab_groups')->toHtml(),
      	));
      	
      	$this->addTab('form_section3', array(
      			'label'     => Mage::helper('dwd_icd')->__('Attributes'),
      			'title'     => Mage::helper('dwd_icd')->__('Attributes'),
      			'content'   => $this->getLayout()->createBlock('dwd_icd/adminhtml_account_edit_tab_attributes')->toHtml(),
      	));
      	
      	
      	
      }
     
      return parent::_beforeToHtml();
  }
}