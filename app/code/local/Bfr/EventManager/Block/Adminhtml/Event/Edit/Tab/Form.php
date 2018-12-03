<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('event_form', array('legend'=>Mage::helper('eventmanager')->__('Event details')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('eventmanager')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      	 
      ));

      
      $products = array();
      $products[] = Mage::helper('eventmanager')->__('-- Please Select --');
      $collection = Mage::helper('eventmanager')->getEventProducts();
      foreach($collection->getItems() as $item){
      		$products[$item->getId()] = $item->getName();
      }
   
      if(Mage::registry('event_data')->getEventId())
      {
      		$data = Mage::registry('event_data');
      		$data->setProduct($products[$data->getProductId()]);
      		//Mage::register('event_data', $data);
	      	$fieldset->addField('product', 'text', array(
	      			'label'     => Mage::helper('eventmanager')->__('Product'),
	      			'class'     => 'readonly',
	      			'readonly'  => true,
	      			'name'      => 'product',
	      			
	      	));
          $fieldset->addField('product_id', 'hidden', array(
              'name'      => 'product_id',
              //'values'    => $products
          ));
      }
      else
      {

	      $fieldset->addField('product_id', 'select', array(
	      		'label'     => Mage::helper('eventmanager')->__('Product'),
	      		'class'     => 'required-entry',
	      		'required'  => true,
	      		'name'      => 'product_id',
	      		'values'    => $products
	      ));
      }
      
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('event_from', 'date', array(
      		'label'     => Mage::helper('eventmanager')->__('Start Date'),
      		'name'      => 'event_from',
      		'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
      		'class'     => 'required-entry',
      		'required'  => true,
      		'format'       => $dateFormatIso,
      		'image'  => $this->getSkinUrl('images/grid-cal.gif'),
      ));
      

      $fieldset->addField('lang_code', 'select', array(
          'label'     => Mage::helper('eventmanager')->__('Language'),
          'name'      => 'lang_code',
          'values'    => Bfr_EventManager_Model_Event_Lang::getAllOptions(),
      ));


      $fieldset = $form->addFieldset('event_form1', array('legend'=>Mage::helper('eventmanager')->__('Participant Certificate')));
      $pdfs = Mage::getModel('pdftemplate/template')->toOptionArray('participation_certificate');

      $fieldset->addField('pdftemplate_id', 'select', array(
          'label'     => Mage::helper('eventmanager')->__('Pdf Template'),
          'name'      => 'pdftemplate_id',
          'values'    => $pdfs,
      ));

      $data =  Mage::registry('event_data');

      if(empty($data->getData('signature_original_filename'))){
          $fieldset->addField('signature_original_filename', 'imagefile', array(
              'label'     => Mage::helper('eventmanager')->__('Signature Image'),
              'name'      => 'signature_original_filename',

          ));
      }
      else{
          $fieldset->addField('signature_filename', 'hidden', array(
              'name' => 'signature_filename',
          ));

          $fieldset->addField('signature_original_filename', 'text', array(
              'label'     => Mage::helper('eventmanager')->__('File'),
              'class'     => 'readonly',
              'readonly'  => true,
              'name'      => 'signature_original_filename',
          ));

          $fieldset->addField('delete_signature', 'checkbox', array(
              'label'     => Mage::helper('eventmanager')->__('Delete File'),
              //'class'     => 'readonly',
              //'readonly'  => true,
              'name'      => 'delete_signature',
          ));
      }

      $fieldset->addField('signature_title', 'text', array(
          'label'     => Mage::helper('eventmanager')->__('Signature Title'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'signature_title',
      ));

      $fieldset->addField('event_place', 'text', array(
          'label'     => Mage::helper('eventmanager')->__('Event Place'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'event_place',
      ));

      $form->setValues($data);


      return parent::_prepareForm();
  }
}
