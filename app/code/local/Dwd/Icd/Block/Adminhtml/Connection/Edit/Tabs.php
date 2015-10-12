<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Connection_Edit_Tabs
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Connection_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('connection_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('dwd_icd')->__('ICD Connection'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('dwd_icd')->__('Details'),
          'title'     => Mage::helper('dwd_icd')->__('Details'),
          'content'   => $this->getLayout()->createBlock('dwd_icd/adminhtml_connection_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}