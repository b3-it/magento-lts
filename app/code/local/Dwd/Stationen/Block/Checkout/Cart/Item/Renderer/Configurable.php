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
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shopping cart item render block
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Dwd_Stationen_Block_Checkout_Cart_Item_Renderer_Configurable extends Mage_Checkout_Block_Cart_Item_Renderer_Configurable
{
 	public function getStation($item)
   {
   		$childs = $item->getChildren();
   		if(is_array($childs) && (count($childs) > 0) )
   		{
   			$item = $childs[0];
   		}
	   	if($item->getStationId())
	   	{
	   		$station = Mage::getModel('stationen/stationen')->load($item->getStationId());
	   		return $station;
	   	}
	   	return "";
   } 

   public function getPeriode($item)
   {
   		$childs = $item->getChildren();
   		if(is_array($childs) && (count($childs) > 0) )
   		{
   			$item = $childs[0];
   		}
   		
	   	if($item->getPeriodId())
	   	{
	   		$periode = Mage::getModel('periode/periode')->load($item->getPeriodId());
	   		return $periode;
	   	}
	   	return "";
   } 
}
