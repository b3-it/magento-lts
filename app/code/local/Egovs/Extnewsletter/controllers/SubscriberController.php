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
 * @package    Mage_Newsletter
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Newsletter subscribe controller
 *
 * @category    Mage
 * @package     Mage_Newsletter
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Extnewsletter_SubscriberController extends Mage_Core_Controller_Front_Action
{
    public function saveAction()
    {
    	if($this->_validateFormKey())
    	{
	    	$products = $this->getRequest()->getPost('extnewsletter');
	    	$issues = $this->getRequest()->getPost('extnewsletterissues');
	    	$subscriberId = $this->_getSubscriptionObject()->getData('subscriber_id');
	    	Mage::getModel('extnewsletter/subscriber')->saveOptions($subscriberId, $products, $issues);
    	}
    	$this->_redirect('customer/account/');
    }

 	public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
    }
    
    
    
   	private function _getCustomer()
    {
        return Mage::getSingleton('customer/session')->getCustomer();
    }
    
 	private function _getSubscriptionObject()
    {
    	return  Mage::getModel('newsletter/subscriber')->loadByCustomer($this->_getCustomer());
    	
    }
}