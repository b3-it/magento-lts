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
 * @package     Mage_Downloadable
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Sales Order downloadable items name column renderer
 *
 * @category   Mage
 * @package    Mage_Downloadable
 * @author     Magento Core Team <core@magentocommerce.com>
 */

class Dwd_Stationen_Block_Adminhtml_Sales_Items_Column_Name extends Mage_Adminhtml_Block_Sales_Items_Column_Name
{
    private $_station = null;
    
 	public function getItem()
 	{
 		$item = parent::getItem();
 		$childs = $item->getChildren();
   		if(is_array($childs) && (count($childs) > 0) )
   		{
   			$item = $childs[0];
   		}
   		return $item;
 	}
    

    public function getStation()
    {
    	if($this->_station == null)
    	{
    		$id = $this->getItem()->getStationId();
    		if($id == null)
    		{
    			return null;
    		}
    	 	$this->_station = Mage::getModel('stationen/stationen')->load($id);
    	}
     	return $this->_station;   
    }
    
 	public function hasPeriode()
    {
    	return ($this->getItem()->getPeriodType() > 0);
    }
    
    public function getFormatedPeriode()
    {
    	return $this->getItem()->getPeriodStart().' - '.$this->getItem()->getPeriodEnd();
    }
}
?>
