<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Sid
 *  @package  Sid_ExportOrder
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_ExportOrder_Block_Adminhtml_Format_Plain_Form extends Mage_Adminhtml_Block_Widget_Form
{
	private $_fields = array();
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
     
      $form->addField('line_separator', 'text', array(
          'label'     => Mage::helper('exportorder')->__('Line Separator'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'format[line_separator]',
      ));
      
      $form->addField('item_separator', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Item Separator'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'format[item_separator]',
      ));

      $data = Mage::registry('format')->getData();
      
      $form->setValues($data);
      return parent::_prepareForm();
  }
}