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
  protected function _prepareForm() {
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

      $fieldset = $form->addFieldset('componentsstructure_entity_form', array('legend' => Mage::helper('virtualgeo')->__('Components Structureentity information')));

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
          'label' => Mage::helper('virtualgeo')->__('Short Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name' => 'shortname',
          'value' => $dataModel->getShortname()
      ));

      $fieldset->addField('name', 'text', array(
          'label' => Mage::helper('virtualgeo')->__('Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name' => 'name',
          'value' => $dataModel->getName()
      ));

      $fieldset->addField('description', 'text', array(
          'label' => Mage::helper('virtualgeo')->__('Description'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name' => 'description',
          'value' => $dataModel->getDescription()
      ));

      $fieldset->addField('store', 'hidden', array(

          'name' => 'store',
          'value' => $dataModel->getStoreId()
      ));

      $categroys =  Mage::getModel('virtualgeo/components_structure_category')->getCollection()->toOptionHash();

      $fieldset->addField('category', 'select', array(
          'label'     => Mage::helper('virtualgeo')->__('Category'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'category_id',
          'options' => $categroys,
          'value'	=> $dataModel->getCategoryId()
      ));

      	$services = Mage::getModel('bkgviewer/service_service')->getCollection();

//       $layer = Mage::getModel('bkgviewer/service_layer');
//       if ($dataModel->getLayerId()) {
//         $layer->load($dataModel->getLayerId());
//       }
  	 
  	  $fieldset->addField('show_layer', 'checkbox', array(
  	  		'label'     => Mage::helper('virtualgeo')->__('Show Layer'),
  	  		'name'      => 'show_layer',
  	  		'checked'	=> boolval($dataModel->getShowLayer()),
  	  		'onchange'  => 'toogleLayer()',
  	  		'readonly' => $store_id != 0,
  	  		'disabled' => $store_id != 0,
  	  		'class'     =>  ($store_id != 0) ? 'readonly' : '',
  	  ));

//       $layers = array();
//       if($layer->getServiceId()) {
//           $collection = Mage::getModel('bkgviewer/service_layer')->getCollection();
//           $collection->getSelect()
//               ->where('service_id=?', $layer->getServiceId());


//           foreach($collection->getItems() as $item)
//           {
//               $layers[$item->getId()] = $item->getTitle();
//           }
//       }
      
      $fieldset->addField('service', 'select', array(
      		'label'     => Mage::helper('bkgviewer')->__('Service'),
      		'name'      => 'service_id',
      		'value'	=> '',
      		'options' => $services->getAsFormOptions(true),
      		//'onchange'  => 'reloadLayer()',
      		'readonly' => $store_id != 0,
      		'disabled' => $store_id != 0,
      		'class'     =>  ($store_id != 0) ? 'readonly' : '',
            'value'    => $dataModel->getServiceId(),
      
      ));
      
      
      
      $fieldset->addField('layer_naming_rule', 'text', array(
      		'label'     => Mage::helper('virtualgeo')->__('Layer Naming Rule'),
      		'name'      => 'layer_naming_rule',
      	
      		//'onchange'  => 'toogleLayer()',
//      	'readonly' => $store_id != 0,
//      	'disabled' => $store_id != 0,
      		'value' => $dataModel->getLayerNamingRule(),
      		'note'		=> "{{product_code}}_{{crs_code}}_{{structure_code}}"
      ));
      
      
      $fieldset->addField('show_map', 'checkbox', array(
      		'label'     => Mage::helper('virtualgeo')->__('Show Map'),
      		'name'      => 'show_map',
      		'checked'	=> boolval($dataModel->getShowMap()),
      		//'onchange'  => 'toogleLayer()',
      		'readonly' => $store_id != 0,
      		'disabled' => $store_id != 0,
      		'class'     =>  ($store_id != 0) ? 'readonly' : '',
      		'note'		=> "Show Map Configuration Within Product Configuration"
      ));
      
      
//       $fieldset->addField('layer_id', 'select', array(
//       		'label'     => Mage::helper('bkgviewer')->__('Layer'),
//       		'name'      => 'layer_id',
//       		'value'	=> $layer->getId(),
//       		'options' => $layers,
//       		'readonly' => $store_id != 0,
//       		'disabled' => $store_id != 0,
//       		'class'     =>  ($store_id != 0) ? 'readonly' : '',
      		
      
//       ));


      return parent::_prepareForm();

  }
}
