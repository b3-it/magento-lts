<?php
/**
 * 
 * @author h.koegel
 *
 */

class Bkg_Viewer_Block_Adminhtml_Composit_Composit_Edit_Selectiontools extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bkg/viewer/composit/edit/selectiontools.phtml');
       
    }

  
	public function getTools()
	{
	    return array();
		$res = array();
        $product = $this->_getProduct();
        $collection = Mage::getModel('virtualgeo/components_content_selectiontools')->getOptions4Product($product->getId(), $product->getStoreId());

		return $collection;
	}
	

	
	/**
	 * Retirve currently edited product model
	 *
	 * @return Mage_Catalog_Model_Product
	 */
	protected function _getProduct()
	{
		return Mage::registry('current_product');
	}
	

	
}
