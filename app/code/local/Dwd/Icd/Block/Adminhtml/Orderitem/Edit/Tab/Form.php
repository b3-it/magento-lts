<?php
/**
 * Dwd Icd Form
 *
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Orderitem_Edit_Tab_Form
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Orderitem_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Wandelt die Zeitfelder in die lokale Zeitzone um
	 * 
	 * Die Felder start_time und end_time werden in die lokale Zeitzone umgewandelt
	 * 
	 * @return Mage_Adminhtml_Block_Widget_Form
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Form::_initFormValues()
	 */
	protected function _initFormValues() {
		$convertToLocaleTime = array('start_time', 'end_time');
		
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
	
	/**
	 * Formelemente erstellen
	 * 
	 * @return Mage_Adminhtml_Block_Widget_Form
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Form::_prepareForm()
	 */
	protected function _prepareForm() {
		 
		$debug = (bool) Mage::getStoreConfigFlag('dwd_icd/debug/is_debug');
		
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('orderitem_form', array('legend'=>Mage::helper('dwd_icd')->__('Item information')));
		
		
		if ($debug) {
			
			$fieldset->addField('semaphor', 'text', array(
					'label'     => Mage::helper('dwd_icd')->__('Semaphor'),
					'class'     => 'required-entry',
					'required'  => true,
					'name'      => 'semaphor',
					'note'		=> '0 or 1'
			));
			
			
			$fieldset->addField('order_item_id', 'text', array(
					'label'     => Mage::helper('dwd_icd')->__('Order Item Id'),
					'class'     => 'required-entry',
					'required'  => true,
			
					'name'      => 'order_item_id',
			));
			
			$fieldset->addField('order_id', 'text', array(
					'label'     => Mage::helper('dwd_icd')->__('Order Id'),
					'class'     => 'required-entry',
					'required'  => true,
			
					'name'      => 'order_id',
			));
			
			$fieldset->addField('product_id', 'text', array(
					'label'     => Mage::helper('dwd_icd')->__('Product Id'),
					'class'     => 'required-entry',
					'required'  => true,
			
					'name'      => 'product_id',
			));
		} 
		
		
		$stationen = Mage::getModel('stationen/stationen')->getCollection()->getOptionAssoArray();
		$stationen = array_merge(array(array('value'=>'0','label' => "keine Station")),$stationen);
		$fieldset->addField('station_id', 'select', array(
				'label'     => Mage::helper('dwd_icd')->__('Station Id'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'station_id',
				'values'    => $stationen,
				'note'	=>  Mage::helper('dwd_icd')->__("To change station set Status to: 'New Station' and Synchronization to: 'Pending'")
		));
		
		if ($debug) {
			$fieldset->addField('account_id', 'text', array(
					'label'     => Mage::helper('dwd_icd')->__('Account Id'),
					'class'     => 'required-entry',
					'required'  => true,
					'name'      => 'account_id',
			));
		
		
			$app = (Mage::getSingleton('dwd_icd/source_attribute_applications')->getAllOptions());
			$fieldset->addField('application', 'select', array(
					'label'     => Mage::helper('dwd_icd')->__('Application'),
					'class'     => 'required-entry',
					'required'  => true,
					'name'      => 'application',
					'values'	=> $app
			));
		}
		else 
		{
			$app = (Mage::getSingleton('dwd_icd/source_attribute_applications')->getAllOptions());
			$fieldset->addField('application', 'select', array(
					'label'     => Mage::helper('dwd_icd')->__('Application'),
					'disabled' => true,
					'readonly'  => true,
					'name'      => 'application',
					'values'	=> $app
			));
		}
		$fieldset->addField('application_url', 'text', array(
				'label'     => Mage::helper('dwd_icd')->__('Application URL'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'application_url',
		));

		$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
		$fieldset->addField('start_time', 'date', array(
				'label'     => Mage::helper('dwd_icd')->__('Start Time'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'readonly'	=> true,
				'disabled' => true,
				'name'      => 'start_time',
				//'time'		=>true,
				'format'    => $dateFormatIso,
				//'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
				'style'		=> 'width: 12em',
				//'image'  => $this->getSkinUrl('images/grid-cal.gif'),
		));

		$fieldset->addField('end_time', 'date', array(
				'label'     => Mage::helper('dwd_icd')->__('End Time'),
				'class'     => 'required-entry',
				//'required'  => true,
				'readonly'	=>true,
				'disabled' => true,
				'name'      => 'end_time',
				'format'    => $dateFormatIso,
	      		//'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
				'style'		=> 'width: 12em',
				//'time'		=>true,
				//'image'  => $this->getSkinUrl('images/grid-cal.gif'),
		));

		$data = Mage::registry('orderitem_data');
		if($data->getSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
		{
			$fieldset->addField('status', 'select', array(
				'label'     => Mage::helper('dwd_icd')->__('Status'),
				'name'      => 'status',
				'values'    =>  Dwd_Icd_Model_OrderStatus::getOptionArray(),
				
			));
		}else{
			$fieldset->addField('status', 'select', array(
					'label'     => Mage::helper('dwd_icd')->__('Status'),
					'name'      => 'status',
					'values'    =>  Dwd_Icd_Model_OrderStatus::getOptionArray(),
					'readonly'	=>true,
					'disabled' => true,
					));
		}


		$fieldset->addField('sync_status', 'select', array(
				'label'     => Mage::helper('dwd_icd')->__('Synchronization'),
				'name'      => 'sync_status',
				'values'    => Dwd_Icd_Model_Syncstatus::getOptionArray()
		));
		 
		$fieldset->addField('error', 'text', array(
				'label'     => Mage::helper('dwd_icd')->__('Message'),
				'class'     => 'read-only',
				'name'      => 'error',
		));
		 
		 
		 
		if ( Mage::getSingleton('adminhtml/session')->getIcdData() ) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getIcdData());
			Mage::getSingleton('adminhtml/session')->setIcdData(null);
		} elseif ( Mage::registry('orderitem_data') ) {
			$form->setValues(Mage::registry('orderitem_data')->getData());
		}
		return parent::_prepareForm();
	}
}