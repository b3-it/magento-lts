<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Block_Adminhtml_Abo_Edit_Tabs
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Block_Adminhtml_Abo_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('abo_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('dwd_abo')->__('Abo Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('dwd_abo')->__('Abo Information'),
          'title'     => Mage::helper('dwd_abo')->__('Abo Information'),
          'content'   => $this->getLayout()->createBlock('dwd_abo/adminhtml_abo_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}