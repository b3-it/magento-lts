<?php
class Dwd_ConfigurableVirtual_Block_Adminhtml_Catalog_Product_Edit_Tab_Configvirtual_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Retrieve product
	 *
	 * @return Mage_Catalog_Model_Product
	 */
	public function getProduct() {
		return Mage::registry('current_product');
	}
	
	/**
	 * Retrieve product attributes
	 *
	 * if $groupId is null - retrieve all product attributes
	 *
	 * @return  array
	 */
	public function getAttributesForConfigVirtual()
	{
		$cacheKey = '_cache_configvirtual_attributes';
		if (!$this->getProduct()->hasData($cacheKey)) {
			$attributes = array();
			$productAttributes = $this->getProduct()->getTypeInstance(true)->getEditableAttributes($this->getProduct());
			/* @var $attribute Mage_Eav_Model_Attribute */
			foreach ($productAttributes as $attributeCode => $attribute) {
				$applyTo = $attribute->getApplyTo();
				if (count($applyTo) == 1
					&& $attribute->hasFrontendLabel()
					&& array_search(Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL, $applyTo) !== false) {
					$attributes[$attributeCode] = $attribute;
				}
			}
			$this->getProduct()->setData($cacheKey, $attributes);
		}
	
		return $this->getProduct()->getData($cacheKey);
	}
	
	protected function _prepareForm() {
		$form = new Varien_Data_Form();
		
		//$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldset('configvirtual_form', array('legend'=>Mage::helper('configvirtual')->__('Configurable Settings')));

		
		/* @var $attribute Mage_Eav_Model_Attribute */
		foreach($this->getAttributesForConfigVirtual() as $attributeCode => $attribute) {
			$input = 'text';
			if ($attribute->hasFrontendInput()) {
				$input = $attribute->getFrontendInput();
			}
			$options = null;
			if ($attribute->hasSourceModel()) {
				$options = $attribute->getSource()->getAllOptions();
			}
			$onclick = null;
			if($attributeCode == 'icd_use')
			{
				//$onclick = "toogleRequiredIcdConnection()";
				$onclick = 'if($(icd_use).value == 1) {$(icd_connection).className=\'required-entry required-entry select\'; $(icd_connection).up().previous().down(\'label\').insert(\'<span>*</span>\').down(\'span\').addClassName(\'required\');} else {$(icd_connection).className=\'\';  $(icd_connection).up().previous().down(\'.required\').remove();  }';
				
			}
			if($attributeCode == 'icd_connection')
			{
				$useicd = !$this->getProduct()->hasData('icd_use') ? false : $this->getProduct()->getData('icd_use');
				$attribute->setIsRequired($useicd);
			
			}
			
			$fieldset->addField($attributeCode, $input, array(
					'label'     => Mage::helper('configvirtual')->__($attribute->getFrontendLabel()),
					'class'     => ((bool) $attribute->getIsRequired()) ? 'required-entry' : null,
					'required'  => (bool) $attribute->getIsRequired(),
					'name'      => "configvirtual[$attributeCode]",
					'values' 	=> $options,
					'value'		=> !$this->getProduct()->hasData($attributeCode) ? $attribute->getDefaultValue() : $this->getProduct()->getData($attributeCode),
					'onchange'	=> $onclick,
			));
		}
		
		return parent::_prepareForm();
	}
	
	 public function xxgetFormHtml()
	 {
	 	$script = "<script type='text/javascript'>function toogleRequiredIcdConnection(){ alert('test'); }</script>";
	 	return $script." ".parent::getFormHtml();
	 }
}