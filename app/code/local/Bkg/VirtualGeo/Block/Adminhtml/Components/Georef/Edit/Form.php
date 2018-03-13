<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Georefentity_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Georef_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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

  	$this->setForm($form);
  	$form->setUseContainer(true);
  	$fieldset = $form->addFieldset('componentsgeoref_entity_form', array('legend'=>Mage::helper('virtualgeo')->__('Components Georefentity information')));

  	$dataModel = Mage::registry('componentsgeoref_entity_data');

  	$fieldset->addField('code', 'text', array(
  			'label'     => Mage::helper('virtualgeo')->__('Code'),
  			'class'     => 'required-entry',
  			'required'  => true,
  			'name'      => 'code',
  			'value'	=> $dataModel->getCode()
  	));

  	
  	
  	$store_id = intval($this->getRequest()->getParam('store', 0));
  	
  
  	
  	
  	$field =$fieldset->addField('epsg_code', 'text', array(
  			'label'     => Mage::helper('virtualgeo')->__('EPSG Code'),
  			'class'     => 'required-entry',
  			'required'  => true,
  			'name'      => 'epsg_code',
  			'value'	=> $dataModel->getEpsgCode()
  	));
  	
  	if($store_id != 0)
  	{
  		$field->setReadonly('readonly');
  		$field->setDisabled('disabled');
  	}
  	
  	$fieldset->addField('proj4', 'text', array(
  	    'label'     => Mage::helper('virtualgeo')->__('Proj4'),
  	    //'class'     => 'required-entry',
  	    //'required'  => true,
  	    'name'      => 'proj4',
  	    'value'	=> $dataModel->getProj4()
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
  			//'label'     => Mage::helper('virtualgeo')->__('Name'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'store',
  			'value'	=> $dataModel->getStoreId()
  	));


  	return parent::_prepareForm();
  }
}
