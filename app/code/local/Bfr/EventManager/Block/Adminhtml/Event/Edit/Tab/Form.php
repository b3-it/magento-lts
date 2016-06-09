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
      		$data->setProduct($products[$data->getEventId()]);
      		//Mage::register('event_data', $data);
	      	$fieldset->addField('product', 'text', array(
	      			'label'     => Mage::helper('eventmanager')->__('Product'),
	      			'class'     => 'readonly',
	      			'readonly'  => true,
	      			'name'      => 'product',
	      			
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
      		'label'     => Mage::helper('eventmanager')->__('From'),
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



      if ( Mage::getSingleton('adminhtml/session')->getEventManagerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEventManagerData());
          Mage::getSingleton('adminhtml/session')->setEventManagerData(null);
      } elseif ( Mage::registry('event_data') ) {
          $form->setValues(Mage::registry('event_data')->getData());
      }
      return parent::_prepareForm();
  }
}
