<?php
/**
 * 
 * @author h.koegel
 *
 */

class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Content_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function x__construct()
    {
        parent::__construct();
        $this->setTemplate('bkg/virtualgeo/product/edit/tab/content/form.phtml');
       
    }

    
	protected function _prepareForm()
    	{
    		$form = new Varien_Data_Form();
//     		$form = new Varien_Data_Form(array(
//     				'id' => 'layer_edit_form',
//     				'action' => 'test',
//     				'method' => 'post',
//     				'enctype' => 'multipart/form-data'
//     		)
//     				);
    		$this->setForm($form);
    		$fieldset = $form->addFieldset('contentlayer_form', array('legend'=>Mage::helper('bkgviewer')->__('Item information')));
    
    		$fieldset->addField('component_content_category', 'select', array(
    				'label'     => Mage::helper('virtualgeo')->__('Category'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'category',
    				'options'	=> Mage::getModel('virtualgeo/components_content_category')->getOptionsArray(),
    				'onchange' => "refeshComponentContent()"
    		));
    		
    		$layer = array();
    		$product = Mage::registry("current_product");
    		foreach(Mage::getModel('virtualgeo/components_content')->getCollectionAsOptions($product->getId()) as $opt)
    		{
    			//$layer[$opt['value']] = $opt['label'];
    			$layer[] = $opt; 
    		}
    		
    		
    		$fieldset->addField('layerForm_Name', 'multiselect', array(
    				'label'     => Mage::helper('virtualgeo')->__('Name'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'LayerForm_Name',
    				'values'  => $layer,
    		));
    		
    		$fieldset->addField('layerForm_Name_is_checked', 'checkbox', array(
    				'label'     => Mage::helper('virtualgeo')->__('Is Checked'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'LayerForm_is_checked',
    		));
    		
    		$fieldset->addField('layerForm_Name_is_readonly', 'checkbox', array(
    				'label'     => Mage::helper('virtualgeo')->__('Is Readonly'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'LayerForm_is_readonly',
    		));
    		

    
    		$fieldset->addField ( 'copy_values', 'button', array (
    				'value' => Mage::helper ( 'virtualgeo' )->__ ( 'Insert' ),
    				'name' => 'copy_values',
    				'onclick' => "addLayer();",
    				'class'	=> 'form-button',
    				'label' => Mage::helper ( 'virtualgeo' )->__ ( 'Copy selected Layer to Tree' ),
    		) );


    
    		if ( Mage::getSingleton('adminhtml/session')->getcompositlayerData() )
    		{
    			$form->setValues(Mage::getSingleton('adminhtml/session')->getcompositlayerData());
    			Mage::getSingleton('adminhtml/session')->setcompositlayerData(null);
    		} elseif ( Mage::registry('compositlayer_data') ) {
    			$form->setValues(Mage::registry('compositlayer_data')->getData());
    		}
    		return parent::_prepareForm();
    	}
    
    
    
    
    //alle verfügbaren PersonalOptions für das Produkt finden 
	public function getFields()
	{
	
		return array();
	}

	private function getStoreId()
	{
		$storeId  = $this->getRequest()->getParam('store');
		return intval($storeId);
		
	}
	
	
	
	
	private function getProduct()
	{
		$product = Mage::registry('product');
		if($product)
		{
			return $product;
		}
		
		if($this->getData('product_id')!= null)
		{
			$product = Mage::getModel('catalog/product')->load('product_id');
			$product->setStoreId($this->getStoreId());
			return $product;
		}
	
		
		return null;
	}
	
	public function getFieldsAvail()
	{
		$fields = array();//Mage::getConfig()->getNode('global/eventbundle_personal/fields')->asArray();
		return $fields;
	}
	
}
