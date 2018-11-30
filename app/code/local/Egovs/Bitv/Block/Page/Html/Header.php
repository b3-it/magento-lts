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
 * @package    Mage_Page
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Html page block
 *
 * Template wird im Layout gesetzt!
 *
 * @category   Mage
 * @package    Mage_Page
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Bitv_Block_Page_Html_Header extends Mage_Page_Block_Html_Header
{
	private $_jump = null;
	
    private function getChilds($node)
    {
    	if($node == null) return; 
    	if($node->getJumptitle()!= null)
    	{
    		$this->_jump[$node->getNameInLayout()] = $node;
    	}
    	
	   	foreach($node->getChild('') as $key=>$value)
    	{
    		$this->getChilds($value);
    	}
    }
    
    

     public function getJumps()
     {
     	if($this->_jump == null)
     	{
	     	$this->_jump = array();
     		$layout = $this->getLayout();
     		$this->getChilds($layout->getBlock('root'));
	     	foreach($layout->getBlock('root')->getChild('') as $key=>$value)
	    	{
	    		$this->getChilds($value);
	    	}
     	}
     	return $this->_jump;
     }

     public function getTitel()
     {
     	$head = $this->getLayout()->getBlock("head");
     	if($head)
     	{   		
     		return $head->getTitle();
     	}

     	return Mage::getBlockSingleton("page/html_head")->getTitle();
     }

    public function getUrl($route = '', $params = array()) {
        if (strlen($route) < 1 && count($params) < 1) {
            $homelink = Mage::getStoreConfig('web/url/header_home_link');
            if (!empty($homelink)) {
                return $homelink;
            }
            return Mage::app()->getStore()->getHomeUrl();
        }
        return parent::getUrl($route, $params);
    }

     public function getWelcome() {
     	if (empty($this->_data['welcome'])) {
     		if (Mage::isInstalled() && Mage::getSingleton('customer/session')->isLoggedIn()) {
     			$customer = Mage::getSingleton('customer/session')->getCustomer();
	     		if (strlen($customer->getCompany()) > 0) {
		    		$str = trim($customer->getName());
		    		//Firma
		    		if (!empty($str)) {
		    			$str = trim(sprintf('%s <span id="welcome-company">(%s)</span>', $this->escapeHtml($str), $this->escapeHtml($customer->getCompany())));
		    		} else {
		    			$str = trim(sprintf('%s', $this->escapeHtml($customer->getCompany())));
		    		}
		    	} else {
		    		$str = $this->escapeHtml($customer->getName());
		    	}
                $this->_data['welcome'] = $this->__('Welcome, %s!', $str);
     		} else {
     			$this->_data['welcome'] = Mage::getStoreConfig('design/header/welcome');
     		}
     	}
     
     	return $this->_data['welcome'];
     }
     
}
