<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Block_Adminhtml_Abo_Edit_Tab_Form
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Block_Adminhtml_Abo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	
	
	protected function _initFormValues() {
		$convertToLocaleTime = array('start_date', 'stop_date','cancelation_period_end');
	
		//In lokale Zeit umwandeln
		foreach ($convertToLocaleTime as $element) {
			$timeElement = $this->getForm()->getElement($element);
			if (!is_null($timeElement) && $timeElement instanceof Varien_Data_Form_Element_Date) {
				/* @var $value Zend_Date */
				$value = $timeElement->getValueInstance();
				if (!($value instanceof Zend_Date)) {
					continue;
				}
				$timeElement->setValue(
						Mage::app()->getLocale()->date(
								$value->getTimestamp(),
								null,
								null,
								true
						)
				);
			}
		}
	
		return $this;
	}
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abo_form', array('legend'=>Mage::helper('dwd_abo')->__('Abo information')));
     
      $fieldset->addField('abo_id', 'text', array(
          'label'     => Mage::helper('dwd_abo')->__('Id'),
          'class'     => 'readonly',
          'readonly'  => true,
          'name'      => 'abo_id',
      ));
      
      $fieldset->addField('email', 'text', array(
      		'label'     => Mage::helper('dwd_abo')->__('Login Name'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'email',
      ));
      
      $fieldset->addField('sku', 'text', array(
      		'label'     => Mage::helper('dwd_abo')->__('Sku'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'sku',
      ));
      
      
      $fieldset->addField('name', 'text', array(
      		'label'     => Mage::helper('dwd_abo')->__('Product'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'name',
      ));
      
      
      $fieldset->addField('stationskennung', 'text', array(
      		'label'     => Mage::helper('dwd_abo')->__('Station'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'stationskennung',
      ));
      
     

      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('start_date', 'date', array(
      		'label'     => Mage::helper('dwd_abo')->__('Start Date'),
      		'name'      => 'start_date',
      		'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'format'       => $dateFormatIso
      ));
      
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('stop_date', 'date', array(
      		'label'     => Mage::helper('dwd_abo')->__('End Date'),
      		
      		'name'      => 'stop_date',
      		'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'format'       => $dateFormatIso
      ));
      
      $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('cancelation_period_end', 'date', array(
      		'label'     => Mage::helper('dwd_abo')->__('Cancelation Periode End'),
      		'required'  => true,
      		'name'      => 'cancelation_period_end',
      		'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
      		'image'  => $this->getSkinUrl('images/grid-cal.gif'),
      		'format'       => $dateFormatIso,
      		'time' => 	true,
      ));
      
      $fieldset->addField('status', 'select', array(
      		'label'     => Mage::helper('dwd_abo')->__('Status'),
      		'name'      => 'status',
      		'values'    => Dwd_Abo_Model_Status::getOptionArray()
      ));
      
      $fieldset->addField('sendcancelmail', 'checkbox', array(
      		'label'     => Mage::helper('dwd_abo')->__('Send cancel notification to customer'),
      		'name'      => 'sendcancelmail',
      		'values'    => '0',
      		'note'		=> Mage::helper('dwd_abo')->__('Only on State canceled'),
      ));
      
      $fieldset->addField('renewal_status', 'select', array(
      		'label'     => Mage::helper('dwd_icd')->__('Renewal Status'),
      		'name'      => 'renewal_status',
      		'values'    => Dwd_Abo_Model_Renewalstatus::getOptionArray()
      ));
      
      
      
  
      
      if ( Mage::getSingleton('adminhtml/session')->getAboData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAboData());
          Mage::getSingleton('adminhtml/session')->setAboData(null);
      } elseif ( Mage::registry('abo_data') ) {
          $form->setValues(Mage::registry('abo_data')->getData());
      }
      return parent::_prepareForm();
  }
}