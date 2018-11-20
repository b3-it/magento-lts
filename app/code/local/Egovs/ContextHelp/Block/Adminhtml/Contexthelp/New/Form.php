<?php

class Egovs_ContextHelp_Block_Adminhtml_Contexthelp_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Form anpasen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Localparams_New_Form
	 * 
	 */
	protected function _prepareForm() {
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/create'),
				'method' => 'post',
				'enctype' => 'multipart/form-data'
		)
		);

		$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldset('localparams_form', array('legend'=>Mage::helper('contexthelp')->__('Context Help')));

        $fieldset->addField('package_theme', 'select', array(
            'name'     => 'package_theme',
            'label'    => Mage::helper('widget')->__('Design Package/Theme'),
            'title'    => Mage::helper('widget')->__('Design Package/Theme'),
            'required' => true,
            'values'   => $this->getPackageThemeOptionsArray()
        ));

		return parent::_prepareForm();
	}

    /**
     * Retrieve package/theme options array
     *
     * @return array
     */
    public function getPackageThemeOptionsArray()
    {
        return Mage::getModel('core/design_source_design')
            ->setIsFullLabel(true)->getAllOptions(true);
    }
}