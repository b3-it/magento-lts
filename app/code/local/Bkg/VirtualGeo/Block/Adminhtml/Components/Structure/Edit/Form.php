<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Structureentity_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Structure_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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

      $dataModel = Mage::registry('componentsstructure_entity_data');

      $fieldset = $form->addFieldset('componentsstructure_entity_form', array('legend'=>Mage::helper('virtualgeo')->__('Components Structureentity information')));

      $store_id = $this->getRequest()->getParam('store',0);
      
      $fieldset->addField('code', 'text', array(
          'label'     => Mage::helper('virtualgeo')->__('Code'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'readonly' => $store_id != 0,
          'disabled' => $store_id != 0,
      	  'class'     =>  ($store_id != 0) ? 'readonly' : '',
          'name'      => 'code',
      	  'value'	=> $dataModel->getCode()
      ));

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
 
  			'name'      => 'store',
  			'value'	=> $dataModel->getStoreId()
  	));

  	  $services = Mage::getModel('bkgviewer/service_service')->getCollection();
      
  	  $fieldset->addField('showLayer', 'checkbox', array(
  	  		'label'     => Mage::helper('virtualgeo')->__('Show Layer'),
  	  		'name'      => 'Show Layer',
  	  		'checked'	=> false,
  	  		'onchange'  => 'toogleLayer()',
  	  		'readonly' => $store_id != 0,
  	  		'disabled' => $store_id != 0,
  	  		'class'     =>  ($store_id != 0) ? 'readonly' : '',
  	  ));
      
      $fieldset->addField('service', 'select', array(
      		'label'     => Mage::helper('bkgviewer')->__('Service'),
      		'name'      => 'service',
      		'value'	=> '',
      		'options' => $services->getAsFormOptions(true),
      		'onchange'  => 'reloadLayer()',
      		'readonly' => $store_id != 0,
      		'disabled' => $store_id != 0,
      		'class'     =>  ($store_id != 0) ? 'readonly' : '',
      
      ));
      
      
      $fieldset->addField('service_layer', 'select', array(
      		'label'     => Mage::helper('bkgviewer')->__('Layer'),
      		'name'      => 'service_layer',
      		'value'	=> '',
      		'readonly' => $store_id != 0,
      		'disabled' => $store_id != 0,
      		'class'     =>  ($store_id != 0) ? 'readonly' : '',
      		
      
      ));


      return parent::_prepareForm();

  }
}
