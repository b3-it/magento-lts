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
class Dwd_ProductOnDemand_Adminhtml_Configdownloadable_Product_EditController extends Mage_Adminhtml_Catalog_ProductController
{

    /**
     * Varien class constructor
     *
     */
    protected function _construct()
    {
        $this->setUsedModuleName('Dwd_ProductOnDemand');
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
}
