<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sident.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Test_Search_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
  	$master_id = 0;
  	if(Mage::registry('license_master') != null)
  	{
  		$master_id = Mage::registry('license_master')->getId();
  	}
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/copy', array('id' => $master_id)),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      
      $fieldset = $form->addFieldset('entity_form', array('legend'=>Mage::helper('bkg_license')->__('Selected Master License')));
      
     
      if(Mage::registry('license_master') != null)
      {
      		$master = Mage::registry('license_master');
      
      		$fieldset->addField('master_id', 'text', array(
      				'label'     => Mage::helper('bkg_license')->__('ID'),
      				//'class'     => 'required-entry',
      				//'required'  => true,
      				'ident'      => 'master_id',
      				'value' => $master->getId()
      		));
	      $fieldset->addField('master_name', 'text', array(
	      		'label'     => Mage::helper('bkg_license')->__('Name'),
	      		//'class'     => 'required-entry',
	      		//'required'  => true,
	      		'name'      => 'master_name',
	      		'value' => $master->getName()
	      ));
	      
	     
	      
	      $fieldset->addField('master_ident', 'text', array(
	      		'label'     => Mage::helper('bkg_license')->__('Number of License'),
	      		//'class'     => 'required-entry',
	      		//'required'  => true,
	      		'ident'      => 'master_ident',
	      		'value' => $master->getIdent()
	      ));
      }
      $fieldset = $form->addFieldset('entity_form1', array('legend'=>Mage::helper('bkg_license')->__('New License')));
      
      $collection = Mage::getModel('customer/customer')->getCollection();
      $values = array();
      
      foreach($collection as $item)
      {
      	$values[] = array('label'=>$item->getEmail(),'value'=>$item->getId());
      }
      
      
      $fieldset->addField('customer', 'select', array(
      		'label'     => Mage::helper('bkg_license')->__('Customer'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'customer',
      		'values' => $values
      ));
      
      if(Mage::registry('license_masters') != null)
      {
      	$fieldset = $form->addFieldset('entity_form2', array('legend'=>Mage::helper('bkg_license')->__('Template Licenses')));
      	$fieldset->addType('table','Egovs_Base_Block_Adminhtml_Widget_Form_Table');
      	 
      	$columns = array();
      	$columns['id'] = $this->__('Id');
      	$columns['ident'] = $this->__('License Number');
      	$columns['name'] = $this->__('Name');
      
      	 
      	 
      	$fieldset->addField('masters', 'table', array(
      			'label'     => Mage::helper('bkg_orgunit')->__('Templates'),
      			//'class'     => 'required-entry',
      			//'required'  => true,
      			'name'      => 'masters',
      			'value' => Mage::registry('license_masters'),
      			'columns' => $columns
      	));
      }
      
      if(Mage::registry('license_copies') != null)
      {
	      $fieldset = $form->addFieldset('entity_form3', array('legend'=>Mage::helper('bkg_license')->__('Copy Licenses')));
	      $fieldset->addType('table','Egovs_Base_Block_Adminhtml_Widget_Form_Table');
	      
	      $columns = array();
	      $columns['id'] = $this->__('Id');
	      $columns['ident'] = $this->__('License Number');
	      $columns['name'] = $this->__('Name');
	     
	      
	      
	      $fieldset->addField('copies', 'table', array(
	      		'label'     => Mage::helper('bkg_orgunit')->__('Copies'),
	      		//'class'     => 'required-entry',
	      		//'required'  => true,
	      		'name'      => 'copies',
	      		'value' => Mage::registry('license_copies'),
	      		'columns' => $columns
	      ));
      }
      
      if(Mage::registry('license_copy') != null)
      {
      	$fieldset = $form->addFieldset('entity_form4', array('legend'=>Mage::helper('bkg_license')->__('Created License')));
      	
      	$copy = Mage::registry('license_copy');
      
      	$fieldset->addField('copy_id', 'text', array(
      			'label'     => Mage::helper('bkg_license')->__('ID'),
      			//'class'     => 'required-entry',
      			//'required'  => true,
      			'ident'      => 'copy_id',
      			'value' => $copy->getId()
      	));
      	$fieldset->addField('copy_name', 'text', array(
      			'label'     => Mage::helper('bkg_license')->__('Name'),
      			//'class'     => 'required-entry',
      			//'required'  => true,
      			'name'      => 'copy_name',
      			'value' => $copy->getName()
      	));
      	 
      
      	 
      	$fieldset->addField('copy_ident', 'text', array(
      			'label'     => Mage::helper('bkg_license')->__('Number of License'),
      			//'class'     => 'required-entry',
      			//'required'  => true,
      			'name'      => 'copy_ident',
      			'value' => $copy->getIdent()
      	));
      	
      	$fieldset->addField('content', 'textarea', array(
      			'label'     => Mage::helper('bkg_license')->__('Text'),
      			//'class'     => 'required-entry',
      			//'required'  => true,
      			'name'      => 'content',
      			'value' => $copy->getContent()
      	));
      }
 
      return parent::_prepareForm();
  }
}
