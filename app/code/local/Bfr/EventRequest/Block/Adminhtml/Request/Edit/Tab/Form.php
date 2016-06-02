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
class Bfr_EventRequest_Block_Adminhtml_Request_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	private $_modelData = null;
  protected function _prepareForm()
  {
  	
  	
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('request_form', array('legend'=>Mage::helper('eventrequest')->__('Item information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('eventrequest')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      	'value'		=> $this->getModelData()->getTitle()
      ));

      
      $fieldset->addField('customer_name', 'text', array(
      		'label'     => Mage::helper('eventrequest')->__('Customer'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'customer_name',
      		'value'		=> $this->getModelData()->getCustomerName()
      ));
      
      $fieldset->addField('product_name', 'text', array(
      		'label'     => Mage::helper('eventrequest')->__('Product'),
      		'class'     => 'readonly',
      		'readonly'  => true,
      		'name'      => 'product_name',
      		'value'		=> $this->getModelData()->getProductName()
      ));
      
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('eventrequest')->__('Status'),
          'name'      => 'status',
          'values'    => Bfr_EventRequest_Model_Status::getAllOptions(),
      	  'value'		=> $this->getModelData()->getStatus()
      ));

      $fieldset->addField('note', 'editor', array(
          'name'      => 'note',
          'label'     => Mage::helper('eventrequest')->__('Note'),
          'title'     => Mage::helper('eventrequest')->__('Note'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          //'required'  => true,
      		'value'		=> $this->getModelData()->getNote()
      ));

     // $form->setValues($this->getModelData()->getData());
      
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
