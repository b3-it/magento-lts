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
 * Shopping cart block
 *
 * @category    Slpb
 * @package     Slpb_Checkout
 */
class Slpb_Checkout_Block_Cart extends Mage_Checkout_Block_Cart
{
	private $_CheckoutUrl = 'egovs_checkout/multipage';

	public function getDeleteAllUrl()
    {
    	return $this->getUrl(
    		       'slpb_checkout/cart/deleteall',
    			   array(
                       'id'=>'0',
                       Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED => $this->helper('core/url')->getEncodedUrl()
                   )
    		   );
    }
    
    public function getCheckoutUrl()
    {
        return $this->getUrl($this->_CheckoutUrl, array('_secure'=>true));
    }
    
   	public function setCheckoutUrl($url)
    {
        $this->_CheckoutUrl = $url;
    }
    
}