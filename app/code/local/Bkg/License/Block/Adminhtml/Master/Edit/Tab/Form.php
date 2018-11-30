<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('entity_form', array('legend'=>Mage::helper('bkg_license')->__('Master License Information')));

      
      $model = Mage::registry('entity_data');
      
    $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      		'value' => $model->getData('name'),
      ));

      $fieldset->addField('title_fe', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Title (FE)'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title_fe',
          'value' => $model->getData('title_fe'),
      ));

      $fieldset->addField('ident', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Number of License'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'ident',
      		'value' => $model->getData('ident'),
      ));
   

     $fieldset->addField('type', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Type of License'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'type',
      		'values' => Bkg_License_Model_Type::getOptionArray(),
      		'value' => $model->getData('type'),
      ));
      
      $yesno = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
      
      $fieldset->addField('reuse', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Reuse'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'reuse',
      	  'values' => $yesno,
      		'value' => $model->getData('reuse'),
      ));

      
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('date_from', 'date', array(
      		'label'     => Mage::helper('bkg_license')->__('Start Date'),
      		'name'      => 'date_from',
      		'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
      		'class'     => 'required-entry',
      		'required'  => true,
      		'format'       => $dateFormatIso,
      		'image'  => $this->getSkinUrl('images/grid-cal.gif'),
      		'value' => $model->getData('date_from'),
      ));
      
      $fieldset->addField('date_to', 'date', array(
      		'label'     => Mage::helper('bkg_license')->__('End Date'),
      		'name'      => 'date_to',
      		'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'format'       => $dateFormatIso,
      		'image'  => $this->getSkinUrl('images/grid-cal.gif'),
      		'value' => $model->getData('date_to'),
      ));
      
     
      $fieldset->addField('active', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Active'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'active',
      	  'values' => $yesno,
      		'value' => $model->getData('active'),
      ));
      $fieldset->addField('consternation_check', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Check Consternation'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'consternation_check',
      		'values' => $yesno,
      		'value' => $model->getData('consternation_check'),
      ));

      $collection = Mage::getModel('pdftemplate/template')->getCollection();
      $collection->getSelect()->where("type='license_copy'");
      
      $pdfs = array();
      $pdfs[] = array('label'=>'','value'=>'');
      foreach($collection as $item)
      {
      	$name= "{$item->getTitle()}";
      	$pdfs[] = array('label'=>$name,'value'=>$item->getId());
      }
      
      
      $fieldset->addField('pdf_template', 'select', array(
      		'label'     => Mage::helper('bkg_license')->__('Pdf Template'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'pdf_template_id',
      		'values' => $pdfs,
      		'value' => $model->getData('pdf_template_id'),
      ));
      

      
      $fieldset->addField('period', 'select', array(
      		'label'     => Mage::helper('bkg_license')->__('Subscription'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'period_id',
      		'values' => Mage::getModel('b3it_subscription/entity_attribute_source_period')->getAllOptions(),
      		'value' => $model->getData('period_id'),
      ));

     

      return parent::_prepareForm();
  }
}
