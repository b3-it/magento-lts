<?php
/**
 * User Yubico Konfiguration
 *
 * @category    B3it
 * @package     B3it_Admin
 * @author     	Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class B3it_Admin_Block_Adminhtml_Permissions_User_Edit_Tab_Yubico extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * 
     */
	public function __construct()
	{
		parent::__construct();
		$this->setDestElementId('yubico_form');
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see Mage_Adminhtml_Block_Widget_Form::_prepareForm()
	 */
	protected function _prepareForm()
	{
		$model = Mage::registry('permissions_user');
	
		$form = new Varien_Data_Form();
	
		$form->setHtmlIdPrefix('user_');
	
		$fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('b3itadmin')->__('Yubico OTP Information')));
	
		$fieldset->addField('use_otp_token', 'select', array(
				'name'  	=> 'use_otp_token',
				'label' 	=> Mage::helper('b3itadmin')->__('Use OTP token'),
				'id'    	=> 'use_otp_token',
				'title' 	=> Mage::helper('b3itadmin')->__('Use OTP token'),
				'class' 	=> 'input-select',
				'style'		=> 'width: 80px',
				'options'	=> array('1' => Mage::helper('adminhtml')->__('Enabled'), '0' => Mage::helper('adminhtml')->__('Disabled')),
		));

		$fieldset->addField('otp_token_id', 'text', array(
				'name'  => 'otp_token_id',
				'label' => Mage::helper('b3itadmin')->__('Yubico OTP Token ID'),
				'id'    => 'otp_token_id',
				'title' => Mage::helper('b3itadmin')->__('Yubico OTP Token ID'),
				'note'      => Mage::helper('b3itadmin')->__('Semicolon separated list of token IDs.'),
				'required' => true,
		));
		
		$data = $model->getData();
		
		unset($data['password']);
		
		$form->setValues($data);
		
		// define field dependencies
		$this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
				->addFieldMap($form->getHtmlIdPrefix()."otp_token_id", 'otp_token_id')
				->addFieldMap($form->getHtmlIdPrefix()."use_otp_token", 'use_otp_token')
				->addFieldDependence('otp_token_id', 'use_otp_token', '1')
		);
		
		Mage::dispatchEvent('adminhtml_permissions_user_edit_prepare_form', array(
							'form'      => $form,
		));
		
		$this->setForm($form);
		
		return parent::_prepareForm();
	}
}