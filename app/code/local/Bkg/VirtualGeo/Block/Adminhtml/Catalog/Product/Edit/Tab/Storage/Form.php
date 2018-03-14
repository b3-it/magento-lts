<?php
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Storage_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		$fieldset = $form->addFieldset('storage_form', array(
				'legend' => Mage::helper('virtualgeo')->__('Storage')
		));

		/*
		$fieldset->addField('use_storage', 'select', array(
				'label'     => Mage::helper('regionallocation')->__('Use Storage'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'product[use_storage]',
				'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
		));

		$field = $fieldset->addField('storage', 'multiselect', array(
				'label'     => Mage::helper('virtualgeo')->__('Usage'),
				'name'      => 'product[storage][]',
				'defaultname'      => 'product[storage_default][]',
				'values'    => Mage::getModel('virtualgeo/components_storage')->getCollectionAsOptions($this->getProduct()->getId()),
				'value'		=> Mage::getModel('virtualgeo/components_storageproduct')->getValue4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId()),
				'default'	=> Mage::getModel('virtualgeo/components_storageproduct')->getDefaul4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId())

		));
		if ($field) {
			$field->setRenderer(
					$this->getLayout()->createBlock('virtualgeo/adminhtml_catalog_product_edit_tab_renderer_list')
					);
		}
*/
		
		$productCollection = Mage::getModel('catalog/product')->getCollection();
		$productCollection->addAttributeToSelect('name');
		$products = array();
		
		foreach($productCollection as $p)
		{
			$products[] = array('label'=> $p->getSku() .", ". $p->getName(),'value'=>$p->getId());
		}
		
        $fieldset->addType('componentparts','Bkg_VirtualGeo_Block_Adminhtml_Widget_Form_Componentparts_Bundle');
        $fieldset->addField('storage', 'componentparts', array(
            'label'     => Mage::helper('bkg_orgunit')->__('Storage'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'product[storage]',
        	'products' => $products,
            'values' => Mage::getModel('virtualgeo/components_storage')->getCollectionAsOptions($this->getProduct()->getId()),
            'value' => Mage::getModel('virtualgeo/components_storageproduct')->getComponents4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId()),
        ));

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



}
