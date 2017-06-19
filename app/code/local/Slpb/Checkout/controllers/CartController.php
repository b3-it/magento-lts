<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Slpb
 * @package    Slpb_Checkout
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shopping cart controller
 */
class Slpb_Checkout_CartController extends Mage_Checkout_CartController
{
 
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }
	
    /**
     * Delete shoping cart all item action
     */
    public function deleteallAction()
    {
    	
       try {
       			$card = $this->_getCart();
      			$items = $card->getItems();

      			foreach($items as $item)
                { 
                	$card->removeItem($item->getId());
                }
                
                $card->save();
                
            } 
            catch (Exception $e) 
            {
                $this->_getSession()->addError($this->__('Cannot remove items'));
                Mage::log("card::deleteAll ".$e->getMessage(), Zend_Log::ERR, Slpb_Helper::EXCEPTION_LOG_FILE);
                
            }

        //$this->_redirectReferer(Mage::getUrl('*/*'));
        $this->_redirect('checkout/cart/index');
    }

  
    
}