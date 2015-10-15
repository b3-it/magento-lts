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
class Dwd_ConfigurableVirtual_Adminhtml_Configvirtual_Product_EditController extends Mage_Adminhtml_Catalog_ProductController
{

    /**
     * Varien class constructor
     *
     */
    protected function _construct()
    {
        $this->setUsedModuleName('Dwd_ConfigurableVirtual');
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
