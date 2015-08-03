<?php
/**
 * 
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package         Egovs_Ready
 * @name            Egovs_Ready_Block_Imprint_Abstract
 * @author          Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright       Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license         http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class Egovs_Ready_Block_Imprint_Abstract extends Mage_Core_Block_Template
{
    /**
     * Set StoreId to get impressum data for this store.
     *
     * @param int $storeId Store id.
     *
     * @return void
     */
    public function setStoreId($storeId) {
        $this->setData(Mage::getStoreConfig('general/imprint', $storeId));
    }

    /**
     * Getting StoreId to get proper store related
     * information in order comments.
     *
     * @return int|null
     */
    protected function getStoreId() {
        $orderId = $this->getRequest()->getParam('order_id', 0);

        if ($orderId > 0) {
            return Mage::getSingleton('sales/order')->load($orderId)->getStoreId();
        }
        return null;
    }
    
    /**
     * Constructor to set config store view.
     *
     * @return void
     */
    public function __construct() {
        $storeId = $this->getStoreId();
        $this->setData(Mage::getStoreConfig('general/imprint', $storeId));
    }
}
