<?php
class Stala_Abo_Block_Adminhtml_Product_Edit_Renderer_Aboswitch extends Varien_Data_Form_Element_Select
{
	public function getHtml()
    {
    	$product = Mage::registry('product');
    	if ($product && $product->getAboParentProduct()) {
        	$this->setData('disabled','disabled');
    	}
        return parent::getHtml();
    }
}