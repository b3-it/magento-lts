<?php
/**
 *
 * @category   	Bkg
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Block_Adminhtml_Periodntity_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Block_Adminhtml_Period_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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

      $dataModel = Mage::registry('entity_data');

      $fieldset = $form->addFieldset('entity_form', array('legend'=>Mage::helper('b3it_subscription')->__('Period Information')));

        $store_id = intval($this->getRequest()->getParam('store', 0));

        
        if($store_id != 0)
        {
        	$fieldset->addField('period_length', 'text', array(
        		'label'     => Mage::helper('b3it_subscription')->__('Period Length'),
        		//'class'     => 'required-entry',
        		//'required'  => true,
        		'name'      => 'period_length',
        		'readonly' => 'readonly',
        		'disabled' => 'disabled',
        		'value'	=> $dataModel->getPeriodLength()
        	));
        	
        	$fieldset->addField('renewal_offset', 'text', array(
        			'label'     => Mage::helper('b3it_subscription')->__('Renewal Offset'),
        			//'class'     => 'required-entry',
        			//'required'  => true,
        			'name'      => 'renewal_offset',
        			'readonly' => 'readonly',
        			'disabled' => 'disabled',
        			'value'	=> $dataModel->getRenewalOffset()
        	));
        }else{
        	$fieldset->addField('period_length', 'text', array(
        			'label'     => Mage::helper('b3it_subscription')->__('Period Length'),
        			'class'     => 'required-entry',
        			'required'  => true,
        			'name'      => 'period_length',
        			
        			'value'	=> $dataModel->getPeriodLength()
        	));
        	 
        	$fieldset->addField('renewal_offset', 'text', array(
        			'label'     => Mage::helper('b3it_subscription')->__('Renewal Offset'),
        			'class'     => 'required-entry',
        			'required'  => true,
        			'name'      => 'renewal_offset',
        			
        			'value'	=> $dataModel->getRenewalOffset()
        	));
        }
        
        
  
   
  	$fieldset->addField('shortname', 'text', array(
  			'label'     => Mage::helper('b3it_subscription')->__('Short Name'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'shortname',
  			'value'	=> $dataModel->getShortname()
  	));

  	$fieldset->addField('name', 'text', array(
  			'label'     => Mage::helper('b3it_subscription')->__('Name'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'name',
  			'value'	=> $dataModel->getName()
  	));

  	$fieldset->addField('description', 'text', array(
  			'label'     => Mage::helper('b3it_subscription')->__('Description'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'description',
  			'value'	=> $dataModel->getDescription()
  	));

  	$fieldset->addField('store', 'hidden', array(
  			//'label'     => Mage::helper('b3it_subscription')->__('Name'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'store',
  			'value'	=> $dataModel->getStoreId()
  	));




      return parent::_prepareForm();

  }
}
