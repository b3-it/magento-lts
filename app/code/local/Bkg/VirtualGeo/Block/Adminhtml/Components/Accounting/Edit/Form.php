<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Accountingentity_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Accounting_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);

      $dataModel = Mage::registry('componentsaccounting_entity_data');

      $fieldset = $form->addFieldset('componentsaccounting_entity_form', array('legend'=>Mage::helper('virtualgeo')->__('Components Accountingentity inaccountingion')));

        $store_id = intval($this->getRequest()->getParam('store', 0));

      $field = $fieldset->addField('code', 'text', array(
          'label' => Mage::helper('virtualgeo')->__('Code'),
          //'class'     => 'required-entry',
          //'required'  => true,
          //'readonly' => false,// boolval($store_id != 0),
          //'disabled' => false,//boolval($store_id != 0),
          'class' => ($store_id != 0) ? 'readonly' : '',
          'name' => 'code',
          'value' => $dataModel->getCode()
      ));
      
      if($store_id != 0)
      {
      	$field->setReadonly('readonly');
      	$field->setDisabled('disabled');
      }

  	$fieldset->addField('shortname', 'text', array(
  			'label'     => Mage::helper('virtualgeo')->__('Short Name'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'shortname',
  			'value'	=> $dataModel->getShortname()
  	));

  	$fieldset->addField('name', 'text', array(
  			'label'     => Mage::helper('virtualgeo')->__('Name'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'name',
  			'value'	=> $dataModel->getName()
  	));

  	$fieldset->addField('description', 'text', array(
  			'label'     => Mage::helper('virtualgeo')->__('Description'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'description',
  			'value'	=> $dataModel->getDescription()
  	));

  	$fieldset->addField('store', 'hidden', array(
  			//'label'     => Mage::helper('virtualgeo')->__('Name'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'store',
  			'value'	=> $dataModel->getStoreId()
  	));

      $fieldset->addField('type', 'select', array(
          'label'     => Mage::helper('virtualgeo')->__('Type'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'type',
          'values' => Bkg_VirtualGeo_Model_Components_Accounting_Type::getOptionArray(),
          'value'	=> $dataModel->getType()
      ));



      return parent::_prepareForm();

  }
}
