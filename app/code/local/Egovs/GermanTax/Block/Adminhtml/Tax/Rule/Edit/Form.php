<?php


class Egovs_GermanTax_Block_Adminhtml_Tax_Rule_Edit_Form extends Mage_Adminhtml_Block_Tax_Rule_Edit_Form
{
  

    /**
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model  = Mage::registry('tax_rule');
        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));

        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('tax')->__('Tax Rule Information')
        ));

        $productClasses = Mage::getModel('tax/class')
            ->getCollection()
            ->setClassTypeFilter(Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT)
            ->toOptionArray();

        $customerClasses = Mage::getModel('tax/class')
            ->getCollection()
            ->setClassTypeFilter(Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER)
            ->toOptionArray();

        $rates = Mage::getModel('tax/calculation_rate')
            ->getCollection()
            ->toOptionArray();

        $fieldset->addField('code', 'text',
            array(
                'name'      => 'code',
                'label'     => Mage::helper('tax')->__('Name'),
                'class'     => 'required-entry',
                'required'  => true,
            )
        );
        
        $fieldset->addField('taxkey', 'text',
        		array(
        				'name'      => 'taxkey',
        				'label'     => Mage::helper('tax')->__('Tax Key'),
        				//'class'     => 'required-entry',
        				//'required'  => true,
        		)
        );

        $yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(); 
        $opt = array();
        foreach ($yn as $n)
        {
        	$opt[$n['value']] = $n['label'];
        }
        $fieldset->addField('valid_taxvat', 'select',
        		array(
        				'name'      => 'valid_taxvat',
        				'label'     => Mage::helper('tax')->__('Recipient Valid Tax Vat Only'),
        				'class'     => 'required-entry',
        				'options'   => $opt,
        				'value'     => $model->getValidTaxvat(),
        				'required'  => true,
        		)
        );
        
        
        $fieldset->addField('tax_customer_class', 'multiselect',
            array(
                'name'      => 'tax_customer_class',
                'label'     => Mage::helper('tax')->__('Customer Tax Class'),
                'class'     => 'required-entry',
                'values'    => $customerClasses,
                'value'     => $model->getCustomerTaxClasses(),
                'required'  => true,
            )
        );

        $fieldset->addField('tax_product_class', 'multiselect',
            array(
                'name'      => 'tax_product_class',
                'label'     => Mage::helper('tax')->__('Product Tax Class'),
                'class'     => 'required-entry',
                'values'    => $productClasses,
                'value'     => $model->getProductTaxClasses(),
                'required'  => true,
            )
        );

        $fieldset->addField('tax_rate', 'multiselect',
            array(
                'name'      => 'tax_rate',
                'label'     => Mage::helper('tax')->__('Tax Rate'),
                'class'     => 'required-entry',
                'values'    => $rates,
                'value'     => $model->getRates(),
                'required'  => true,
            )
        );
        $fieldset->addField('priority', 'text',
            array(
                'name'      => 'priority',
                'label'     => Mage::helper('tax')->__('Priority'),
                'class'     => 'validate-not-negative-number',
                'value'     => (int) $model->getPriority(),
                'required'  => true,
                'note'      => Mage::helper('tax')->__('Tax rates at the same priority are added, others are compounded.'),
            )
        );
        $fieldset->addField('position', 'text',
            array(
                'name'      => 'position',
                'label'     => Mage::helper('tax')->__('Sort Order'),
                'class'     => 'validate-not-negative-number',
                'value'     => (int) $model->getPosition(),
                'required'  => true,
            )
        );

        if ($model->getId() > 0 ) {
            $fieldset->addField('tax_calculation_rule_id', 'hidden',
                array(
                    'name'      => 'tax_calculation_rule_id',
                    'value'     => $model->getId(),
                    'no_span'   => true
                )
            );
        }

        $form->addValues($model->getData());
        $form->setAction($this->getUrl('*/tax_rule/save'));
        $form->setUseContainer(true);
        $this->setForm($form);

        return Mage_Adminhtml_Block_Widget_Form::_prepareForm();
    }
}
