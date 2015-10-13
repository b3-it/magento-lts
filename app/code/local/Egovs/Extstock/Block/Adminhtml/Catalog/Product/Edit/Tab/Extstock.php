<?php

class Egovs_Extstock_Block_Adminhtml_Catalog_Product_Edit_Tab_Extstock extends Mage_Adminhtml_Block_Widget  implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    private $_attributes = null;
    
    public function __construct($attributes)
    {
    	$this->_attributes = $attributes;
        parent::__construct();
        //$this->setProductId($this->getRequest()->getParam('id'));
        $this->setTemplate('egovs/extstock/catalog/product/tab/extstock.phtml');
        $this->setId('extstock_product');
        
    }
    
  	protected function _prepareLayout()
    {
    	//TODO : frochlitzer: Funktionen reinbringen!!
    	$this->setChild('stock_order',
            $this->getLayout()->createBlock('extstock/adminhtml_catalog_product_edit_tab_extstock_order')
        );
    	  	
    	
        $this->setChild('grid',
            $this->getLayout()->createBlock('extstock/adminhtml_extstock_grid','',array('extstockproductmode'=>true))
        );

       
       
        return parent::_prepareLayout();
    }
    
    /**
     * Liefert aktuelle Produkt Instanz
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct() {
    	return Mage::registry('product');
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
    
    public function isNew() {
    	if ($this->getProduct()->getId()) {
    		return false;
    	}
    	return true;
    }
    
    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab() {
    	$p = $this->getProduct();
    	if(($p != null) && ($p->getTypeInstance(true)->IsComposite()))
    	{
    		return false;
    	}
    	if (($this->getProduct()->hasStockItem() && $this->getProduct()->getStockItem()->getManageStock()) || $this->isNew()) {
    		return true;
    	}
    	
    	return false;
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
