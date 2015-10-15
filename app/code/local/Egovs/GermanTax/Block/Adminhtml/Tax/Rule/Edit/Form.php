<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Block_Adminhtml_Tax_Rule_Edit_Form extends Mage_Adminhtml_Block_Tax_Rule_Edit_Form
{
    /**
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();
        
        $model  = Mage::registry('tax_rule');
        
        /* @var $fieldset Varien_Data_Form_Element_Fieldset */
        $fieldset = $this->getForm()->getElement('base_fieldset');
        
        $fieldset->addField('taxkey', 'text',
        		array(
        				'name'      => 'taxkey',
        				'label'     => Mage::helper('tax')->__('Tax Key'),
        				//'class'     => 'required-entry',
        				//'required'  => true,
        		),
        		'code'
        );
        
        $opt = Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray();
        $fieldset->addField('valid_taxvat', 'select',
        		array(
        				'name'      => 'valid_taxvat',
        				'label'     => Mage::helper('tax')->__('Recipient Valid Tax Vat Only'),
        				'class'     => 'required-entry',
        				'options'   => $opt,
        				'value'     => $model->getValidTaxvat(),
        				'required'  => true,
        		),
        		'taxkey'
        );
        
        $this->getForm()->addValues($model->getData());
        
        return $this;
    }
}
