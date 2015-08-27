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
	
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('catalog/product/edit/options/type/select.phtml');
     
    }
	 
	

}