<?php
/**
 * 
 */
require_once 'Mage/Adminhtml/controllers/Catalog/ProductController.php';

/**
 * 
 * @author Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 *
 */
class Bkg_VirtualAccess_Adminhtml_Virtualaccess_Product_EditController extends Mage_Adminhtml_Catalog_ProductController
{

    /**
     * Varien class constructor
     *
     */
    protected function _construct()
    {
        $this->setUsedModuleName('Bkg_VirtualAccess');
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
