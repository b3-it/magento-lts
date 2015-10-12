<?php
class Sid_Wishlist_Block_Share_Sharing extends Sid_Wishlist_Block_Wishlist_Abstract
{
    /**
     * Kunden-Instanz
     *
     * @var Mage_Customer_Model_Customer
     */
    protected $_customer = null;

    /**
     * Global Layout vorbereiten
     *
     * @return Sid_Wishlist_Block_Share_Sharing
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();

        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->setTitle($this->getHeader());
        }
        return $this;
    }

    /**
     * Liefert die Instanz des Besitzer des Merkzettels
     *
     * @return Mage_Customer_Model_Customer
     */
    public function getWishlistCustomer() {
        if (is_null($this->_customer)) {
            $this->_customer = Mage::getModel('customer/customer')
                ->load($this->getWishlist()->getCustomerId());
        }

        return $this->_customer;
    }

    /**
     * Liefert Page Header
     *
     * @return string
     */
    public function getHeader() {
        return Mage::helper('sidwishlist')->__("%s's Collector List", $this->escapeHtml($this->getWishlistCustomer()->getFirstname()));
    }
    
    public function getBackLink() {
    	$this->getUrl('*/*/view', array('id' => $this->getWishlist()->getId()));
    }
}
