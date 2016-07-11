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
 * @category   Egovs
 * @package    Egovs_Checkout
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shopping cart block
 *
 * @category    Egovs
 * @package     Egovs_Checkout
 */
class Egovs_Checkout_Block_Cart_Cart extends Mage_Checkout_Block_Cart
{
	
    
    public function getDeleteAllUrl()
    {
    	$url = $this->getUrl('egovs_checkout/cart/deleteall', array(
                'id'=>'0',
                Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED => $this->helper('core/url')->getEncodedUrl()
            ));
        $img = $this->getSkinUrl('images/btn_trash.gif');
        $text = Mage::helper('mpcheckout')->__('Delete All Items');
        return $url;//"<a title=\"$text\" href=\"#\" onclick=\"deleteAll(\'$url\')\" ><img height=\"16\" width=\"16\" alt=\"$text\" src=\"$img\"/></a>";
    }
    
   public function getCheckoutUrl()
    {
       return $this->helper('mpcheckout/url')->getCheckoutUrl();
    }
   
    
}
