<?php
/**
 * 
 *  @category Egovs
 *  @package  Egovs_Isolation
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Block_Adminhtml_Customer_Edit_Tab_Carts extends Mage_Adminhtml_Block_Customer_Edit_Tab_Carts
{
    /**
     * Add shopping cart grid of each website
     *
     * @return Mage_Adminhtml_Block_Customer_Edit_Tab_Carts
     */
    protected function _prepareLayout()
    {
        $sharedWebsiteIds = Mage::registry('current_customer')->getSharedWebsiteIds();
        $sharedWebsiteIds = Mage::helper('isolation')->filterSharedWebsiteIds($sharedWebsiteIds);
        $isShared = count($sharedWebsiteIds) > 1;
        foreach ($sharedWebsiteIds as $websiteId) {
            $blockName = 'customer_cart_' . $websiteId;
            $block = $this->getLayout()->createBlock('adminhtml/customer_edit_tab_cart',
                $blockName, array('website_id' => $websiteId));
            if ($isShared) {
                $block->setCartHeader($this->__('Shopping Cart from %s', Mage::app()->getWebsite($websiteId)->getName()));
            }
            $this->setChild($blockName, $block);
        }
        return Mage_Adminhtml_Block_Template::_prepareLayout();
    }

    /**
     * Just get child blocks html
     *
     * @return string
     */
    protected function _toHtml()
    {
        Mage::dispatchEvent('adminhtml_block_html_before', array('block' => $this));
        return $this->getChildHtml();
    }
}
