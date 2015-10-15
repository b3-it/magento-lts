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
 * @package    Mage_Shipping
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Slpb_Shipping_Model_Carrier_Abstract extends Mage_Shipping_Model_Carrier_Abstract
{
    protected function getStars($items)
    {
    	$star = 0;
    	foreach ($items as $item) {
	            if ($item->getParentItem()) {
	                continue;
	            }

	            $p = $item->getProduct();
	            if($p->getSlpbLimit()=== null)
	            {
	            	$p = Mage::getModel('catalog/product')->load($p->getId());
	            }
	            if($p->getSlpbLimit()){
	            	if ($p->getSternchen()){
	            		$star += $p->getSternchen() * $item->getQty();
	            	}
	            }
	     }
	     return $star;    
    }
	 public function collectRates(Mage_Shipping_Model_Rate_Request $request)
	 {
	 	
	 }
}
