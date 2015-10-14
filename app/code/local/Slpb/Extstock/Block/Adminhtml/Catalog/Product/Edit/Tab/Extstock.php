<?php

class Slpb_Extstock_Block_Adminhtml_Catalog_Product_Edit_Tab_Extstock extends Mage_Adminhtml_Block_Widget  implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    private $_attributes = null;
    
    public function __construct($attributes)
    {
    	$this->_attributes = $attributes;
        parent::__construct();
        $this->setProductId($this->getRequest()->getParam('id'));
        $this->setTemplate('slpb/extstock/catalog/product/tab/extstock.phtml');
        $this->setId('extstock_product');
    }
    
  	protected function _prepareLayout()
    {
    	//TODO : frochlitzer: Funktionen reinbringen!!
    	$this->setChild('stock_order',
            $this->getLayout()->createBlock('extstock/adminhtml_catalog_product_edit_tab_extstock_order')
        );
    	  	
        $this->setChild('grid',
            $this->getLayout()->createBlock('extstock/adminhtml_extstock_grid','',$this->_attributes)
        );

       $this->setChild('stock_move',
            $this->getLayout()->createBlock('extstock/adminhtml_catalog_product_edit_tab_extstock_move','',$this->_attributes)
        );
       
        return parent::_prepareLayout();
    }

     /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
    	return Mage::helper('catalog')->__('Extended Inventory');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
    	return "Title";
    }
    

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
    	return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
    	return false;
    }

}
