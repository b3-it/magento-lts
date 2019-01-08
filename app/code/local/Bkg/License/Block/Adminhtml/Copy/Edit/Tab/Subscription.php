<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Customergroup
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Subscription extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('copysubscription_form', array('legend'=>Mage::helper('bkg_license')->__('Subscription')));

        $dataModel = Mage::registry('entity_data');
 
      
       
        
        
        
        $fieldset->addField('subscripe', 'checkbox', array(
        		'label'     => Mage::helper('b3it_subscription')->__('Subscription'),
        		//'class'     => 'required-entry',
        		//'required'  => true,
        		'name'      => 'subscripe',
        		'onchange'	=> 'toogleSubscription();',
        		'checked'	=> $dataModel->getPeriodId()? 'checked' : '', 
        ));
        
        $fieldset->addField('initial_period_length', 'text', array(
        		'label'     => Mage::helper('b3it_subscription')->__('Initial Period Length'),
        		'class'     => 'required-entry',
        		'required'  => true,
        		'name'      => 'period[initial_period_length]',
        
        		'value'	=> $dataModel->getPeriod()->getInitialPeriodLength()
        ));
        
        $fieldset->addField('initial_period_unit', 'select', array(
        		'label'     => Mage::helper('b3it_subscription')->__('Initial Period Unit'),
        		
        		'name'      => 'period[initial_period_unit]',
        
        		'values' => B3it_Subscription_Model_Period_Unit::getOptions(),
        		'value'	=> $dataModel->getPeriod()->getInitialPeriodUnit()
        ));
        
        $fieldset->addField('period_length', 'text', array(
        		'label'     => Mage::helper('b3it_subscription')->__('Period Length'),
        		'class'     => 'required-entry',
        		'required'  => true,
        		'name'      => 'period[period_length]',
        		 
        		'value'	=> $dataModel->getPeriod()->getPeriodLength()
        ));
        
        $fieldset->addField('period_unit', 'select', array(
        		'label'     => Mage::helper('b3it_subscription')->__('Period Unit'),
        		
        		'name'      => 'period[period_unit]',
        
        		'values' => B3it_Subscription_Model_Period_Unit::getOptions(),
        		'value'	=> $dataModel->getPeriod()->getPeriodUnit()
        ));
        
        $fieldset->addField('renewal_offset', 'text', array(
        		'label'     => Mage::helper('b3it_subscription')->__('Renewal Offset'),
        		'class'     => 'required-entry',
        		'required'  => true,
        		'name'      => 'period[renewal_offset]',
        		'note'	=>Mage::helper('b3it_subscription')->__('-1 means: create new order one day before period will end'),
        		'value'	=> $dataModel->getPeriod()->getRenewalOffset()
        ));



        return parent::_prepareForm();
    }
}
