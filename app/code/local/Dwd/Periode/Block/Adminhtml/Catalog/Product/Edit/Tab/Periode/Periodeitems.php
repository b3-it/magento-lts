<?php
class Dwd_Periode_Block_Adminhtml_Catalog_Product_Edit_Tab_Periode_Periodeitems extends Mage_Adminhtml_Block_Template
{
	public function __construct($attributes)
    {
    	$this->_attributes = $attributes;
        parent::__construct();
        $this->setTemplate('dwd/periode/catalog/product/edit/periode/periodeitems.phtml');
        $this->setId('periode_items');
        
    }
    
}
