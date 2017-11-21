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
    		$this->setForm($form);
    		$fieldset = $form->addFieldset('compositlayer_form', array('legend'=>Mage::helper('bkgviewer')->__('Item information')));
    
    		$fieldset->addField('title', 'text', array(
    				'label'     => Mage::helper('bkgviewer')->__('Title'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'title',
    		));
    		$fieldset->addField('parent_id', 'text', array(
    				'label'     => Mage::helper('bkgviewer')->__('Parent'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'parent_id',
    		));
    		$fieldset->addField('composit_id', 'text', array(
    				'label'     => Mage::helper('bkgviewer')->__('Composit'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'composit_id',
    		));
    		$fieldset->addField('pos', 'text', array(
    				'label'     => Mage::helper('bkgviewer')->__('Position'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'pos',
    		));
    		$fieldset->addField('service_layer', 'text', array(
    				'label'     => Mage::helper('bkgviewer')->__('Layer'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'service_layer',
    		));
    
    
    
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
