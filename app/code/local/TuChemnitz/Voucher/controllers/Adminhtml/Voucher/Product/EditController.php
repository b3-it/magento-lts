<?php
/**
 * 
 */
require_once 'Mage/Adminhtml/controllers/Catalog/ProductController.php';

/**
 * 
 * @author TheRoch
 *
 */
class TuChemnitz_Voucher_Adminhtml_Voucher_Product_EditController extends Mage_Adminhtml_Catalog_ProductController
{

    /**
     * Varien class constructor
     *
     */
    protected function _construct()
    {
        $this->setUsedModuleName('TuChemnitz_Voucher');
    }

    /**
     * Load downloadable tab fieldsets
     *
     */
    public function formAction()
    {
        $this->_initProduct();
        
        $this->loadLayout();        
        $this->renderLayout();
        
        return $this;
    }
    
    public function gridAction()
    {

    	$this->_initProduct();
    	$this->loadLayout();
    	
    		$this->getResponse()->setBody(
    				$this->getLayout()->createBlock('tucvoucher/adminhtml_catalog_product_edit_tab_voucher_grid')->toHtml()
    		);
    }
    
    public function massDeleteAction() {
    	$voucherIds = $this->getRequest()->getParam('tan_ids');
    	$product_id = $this->getRequest()->getParam('product_id');
    	if(!is_array($voucherIds) && (count($voucherIds) > 0)) {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select TAN(s)'));
    	} else {
    		try {
    			$voucherId = $voucherIds[0];
    			$voucher = Mage::getModel('tucvoucher/tan')->load($voucherId);
    			
    			$pending = $voucher->countPendingOrders4Product();
    			if($pending > 0)
    			{
    				throw new Exception($this->__("TAN are pending and could not deleted therefore!"));
    			}
    			
    			$sold = $voucher->countSoldTans($voucherIds, $voucher->getProductId());
    			if($sold > 0)
    			{
    				Mage::getSingleton('adminhtml/session')->addNotice($sold . " ".$this->__("TAN are sold and could not deleted therefore!"));
    			}
    			
    			$count = $voucher->deleteTans($voucherIds, $voucher->getProductId());
    			if($count > 0){
	    			Mage::getSingleton('adminhtml/session')->addSuccess(
	    			Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', $count)
	    			);
    			}
    		} catch (Exception $e) {
    			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    		}
    	}
    	if($product_id){
    		$this->_redirect('*/catalog_product/edit',array('id'=>$product_id));
    	}else {
    		$this->_redirect('*/catalog_product/index');
    	}
    }
    
   
    
}
