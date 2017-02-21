<?php
/**
 * B3it ConfigCompare
 *
 *
 * @category   	B3it
 * @package    	B3it_ConfigCompare
 * @name       	B3it_ConfigCompare_Block_Adminhtml__Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_ConfigCompare_Block_Adminhtml_Compare_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('_form', array('legend'=>Mage::helper('configcompare')->__('Item information')));


     
      return parent::_prepareForm();
  }
}
