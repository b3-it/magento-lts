<?php
class TuChemnitz_Voucher_Block_Adminhtml_Catalog_Product_Edit_Tab_Voucher_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Retrieve product
	 *
	 * @return Mage_Catalog_Model_Product
	 */
	public function getProduct() {
		return Mage::registry('current_product');
	}
	
	
	
	protected function _prepareForm() {
		$form = new Varien_Data_Form();
		
		//$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldset('tucvoucher_form', array('legend'=>Mage::helper('tucvoucher')->__('Voucher Import')));

		$fieldset->addField('tucvoucherfilename', 'file', array(
				'label'     => Mage::helper('tucvoucher')->__('New TAN List'),
				'required'  => false,
				'name'      => 'tucvoucherfilename',
		));
	
		
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$fieldset->addField('tucvoucher_expire', 'date', array(
				'label'     => Mage::helper('tucvoucher')->__('Expire Date'),
				'name'      => 'tucvoucher_expire',
				'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
				//'class'     => 'readonly',
				//'readonly'  => true,
				'style'		=> 'width: 12em',
				'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
				'image'  => $this->getSkinUrl('images/grid-cal.gif'),
				'format'       => $dateFormatIso
		));
		
		$fieldset = $form->addFieldset('tucvoucher_form2', array('legend'=>Mage::helper('tucvoucher')->__('Additional Email Text')));
		$fieldset->addField('product[tucvoucher_note_email]', 'textarea', array(
				'label'     => Mage::helper('tucvoucher')->__('Text'),
				'required'  => false,
				'name'      => 'product[tucvoucher_note_email]',
				'value'		=> $this->getProduct()->getTucvoucherNoteEmail()
		));
		return parent::_prepareForm();
	}
}