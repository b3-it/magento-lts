<?php
/**
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name       	Dwd_Ibewi_Block_Adminhtml_Kostentraeger_Attribute_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Kostentraeger_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('kostentraegerattribute_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('ibewi')->__('Cost Unit'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('ibewi')->__('Attribute Information'),
          'title'     => Mage::helper('ibewi')->__('Attribute Information'),
          'content'   => $this->getLayout()->createBlock('ibewi/adminhtml_kostentraeger_attribute_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
