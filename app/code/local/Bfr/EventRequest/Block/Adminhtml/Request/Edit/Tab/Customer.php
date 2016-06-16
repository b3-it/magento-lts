<?php
/**
 * Bfr EventRequest
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Block_Adminhtml_Request_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Block_Adminhtml_Request_Edit_Tab_Customer extends Mage_Adminhtml_Block_Widget_Form
{
	private $_modelData = null;
  protected function _prepareForm()
  {
  	
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('request_form', array('legend'=>Mage::helper('eventrequest')->__('Customer')));
      
      $fieldset->addField('firstname', 'text', array(
      		'label'     => Mage::helper('eventrequest')->__('Firstname'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'firstname',
      		'value'		=> $this->getModelData()->getCustomer()->getFirstname()
      ));
      
      $fieldset->addField('lastname', 'text', array(
      		'label'     => Mage::helper('eventrequest')->__('Lastname'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'lastname',
      		'value'		=> $this->getModelData()->getCustomer()->getLastname()
      ));
      
      $fieldset->addField('company', 'text', array(
      		'label'     => Mage::helper('eventrequest')->__('Company'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'company',
      		'value'		=> $this->getModelData()->getAddress()->getCompany()
      ));
      
      $fieldset->addField('company2', 'text', array(
      		'label'     => Mage::helper('eventrequest')->__('Company 2'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'company2',
      		'value'		=> $this->getModelData()->getAddress()->getCompany2()
      ));
      
      $fieldset->addField('company3', 'text', array(
      		'label'     => Mage::helper('eventrequest')->__('Company 3'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'company',
      		'value'		=> $this->getModelData()->getAddress()->getCompany3()
      ));
      
      $fieldset->addField('city', 'text', array(
      		'label'     => Mage::helper('eventrequest')->__('City'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'city',
      		'value'		=> $this->getModelData()->getAddress()->getCity()
      ));
      
      $fieldset->addField('street', 'text', array(
      		'label'     => Mage::helper('eventrequest')->__('street'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'street',
      		'value'		=> $this->getModelData()->getAddress()->getStreetFull()
      ));
      
      
      return parent::_prepareForm();
  }
  
  public function getModelData()
  {
  	if($this->_modelData == null){
	  	if ( Mage::getSingleton('adminhtml/session')->getEventRequestData() )
	  	{
	  		$this->_modelData = Mage::getSingleton('adminhtml/session')->getEventRequestData();
	  		Mage::getSingleton('adminhtml/session')->setEventRequestData(null);
	  	} elseif ( Mage::registry('request_data') ) {
	  		$this->_modelData = (Mage::registry('request_data'));
	  	}
  	}
  	
  	return $this->_modelData;
  }
  
}
