<?php
class Dwd_Periode_Block_Adminhtml_Catalog_Product_Edit_Tab_Periode_Input extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		$fieldset = $form->addFieldset('periode_form', array(
				'legend' => Mage::helper('periode')->__('Add Periode Data')
		));

		$fieldset->addField('periode_product_id', 'hidden', array(
				'name'  => 'periode_product_id',
				'value' => $this->getProduct()->getId()
		));

		$fieldset->addField('periode_id', 'hidden', array(
				'name'  => 'periode_id',
				'value'	=> '0'
		));

		$fieldset->addField('store_id', 'hidden', array(
				'name'  => 'store_id',
				'value'	=> $this->getProduct()->getStoreId()
		));
		
		if($this->getProductHasAboOption()){
			$type = Dwd_Periode_Model_Periode_Type::getOptionArray();
		} else {
			$type = Dwd_Periode_Model_Periode_Type::getOptionArrayWithoutAbo();
		}

		$fieldset->addField('periode_type', 'select', array(
				'label'    => Mage::helper('periode')->__('Type'),
				'name'     => 'periode_type',
				'onchange' => 'changeArt(this.value)',
				'options'	 => $type,
		));
		
		$fieldset->addField('periode_label', 'text', array(
				'label' => Mage::helper('periode')->__('Label'),
				'name'  => 'periode_label',
		));

		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$fieldset->addField('periode_from', 'date', array(
				'label'        => Mage::helper('periode')->__('From'),
				'name'         => 'periode_from',
				'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
				'image'        => $this->getSkinUrl('images/grid-cal.gif'),
				'format'       => $dateFormatIso,
		));

		$fieldset->addField('periode_to', 'date', array(
				'label'        => Mage::helper('periode')->__('To'),
				'name'         => 'periode_to',
				'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
				'image'        => $this->getSkinUrl('images/grid-cal.gif'),
				'format'       => $dateFormatIso,
		));

		$fieldset->addField('periode_duration', 'text', array(
				'label' => Mage::helper('periode')->__('Duration'),
				'name'  => 'periode_duration',
		));


		$fieldset->addField('periode_unit', 'select', array(
				'label'   => Mage::helper('periode')->__('Unit'),
				'name'    => 'periode_unit',
				'options'	=> Dwd_Periode_Model_Periode_Unit::getOptionArray(),
		));

		if($this->getProductHasAboOption()){
			$fieldset->addField('cancelation_period', 'text', array(
					'label' => Mage::helper('periode')->__('Cancelation Period [Days]'),
					'name'  => 'cancelation_period',
			));
		}

		$fieldset->addField('periode_price', 'text', array(
				'label' => '+ '.Mage::helper('periode')->__('Price'). ' [€]',
				'name'  => 'periode_price',
				'note'  => Mage::helper('periode')->__('Value will be added to product base price.')
		));

		if($this->getProductHasAboOption()){
			$fieldset->addField('periode_tier_price', 'text', array(
					'name'  => 'periode_tier_price',
					'class' => 'requried-entry',
					'label' => '',
					'value' => '',
					'note'  => Mage::helper('periode')->__('Value will be replace product base price.')
			));

			$form->getElement('periode_tier_price')->setRenderer(
					$this->getLayout()->createBlock('periode/adminhtml_catalog_product_edit_tab_periode_price_tier')
			);
		}

		return parent::_prepareForm();
	}

	public function getProduct()
	{
		if (!$this->_productInstance) {
			if ($product = Mage::registry('product')) {
				$this->_productInstance = $product;
			} else {
				$this->_productInstance = Mage::getSingleton('catalog/product');
			}
		}

		return $this->_productInstance;
	}

	public function getProductHasAboOption()
	{
		return $this->getProduct()->getTypeId() == 'configvirtual';
	}

}
