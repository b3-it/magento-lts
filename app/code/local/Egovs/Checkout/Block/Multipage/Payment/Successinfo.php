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
 * @category   Mage
 * @package    Mage_Checkout
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Multishipping checkout payment information data
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Checkout_Block_Multipage_Payment_Successinfo extends Mage_Core_Block_Template
{
	private $_PaymentInfo = null;

	
	
	
    /**
     * Retrieve payment info model
     *
     * @return Mage_Payment_Model_Info
     */
    public function getPaymentInfo()
    {
    	if($this->_PaymentInfo == null)
    	{
    		$this->_PaymentInfo = Mage::getSingleton('mpcheckout/multipage')->getQuote()->getPayment();
    	}
        return $this->_PaymentInfo;
    }
    
    public function setPaymentInfo($PaymentInfo)
    {
    	$this->_PaymentInfo = $PaymentInfo;
    }

    protected function _toHtml()
    {
    	if ($info = $this->getPaymentInfo()) {
    		
            $this->setChild(
                $this->_getInfoBlockName(),
                Mage::helper('payment')->getInfoBlock($info)
            );
        }
    	
    	
        $html = '';
        if ($block = $this->getChild($this->_getInfoBlockName())) {
            $html = $block->toHtml();
        }
        return $html;
    }
    

   /**
     * Retrieve info block name
     *
     * @return string|bool
     */
    protected function _getInfoBlockName()
    {
        if ($info = $this->getPaymentInfo()) {
            return 'payment.info.'.$info->getMethodInstance()->getCode();
        }
        return false;
    }
}