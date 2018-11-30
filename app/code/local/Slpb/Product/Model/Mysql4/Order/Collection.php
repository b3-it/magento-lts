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
 * @package    Mage_Sales
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Orders collection
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Slpb_Product_Model_Mysql4_Order_Collection extends Mage_Sales_Model_Mysql4_Order_Collection
{
	private $_shippingmethod = 0;
	private $_missingProducts = array();
	
 	public function addAttributesAndFilter($selectCashpayment,$shippingmethod)
 	{
 		$this->_shippingmethod = $shippingmethod;
	    $this
 		    ->addAttributeToSelect('*');
 		    
        $select = $this->getSelect();
       
        if($selectCashpayment){
        	$select->where("main_table.status='processing' OR (main_table.status ='pending' AND p1.method='cashpayment')" );
        }
        else {
        	$select->where("main_table.status='processing'" );
        }
        
        
        
        $exp = new Zend_Db_Expr('CONCAT(COALESCE(firstname, ""), " ", COALESCE(lastname, ""), " ", COALESCE(company, ""), " ", COALESCE(company2, "")) as shipping_name');
        $select->joinLeft(array('shipping' => 'sales_flat_order_address' ), 'main_table.shipping_address_id=shipping.entity_id', $exp);
        
        $exp = new Zend_Db_Expr("(SELECT sum(qty_shipped) as sum_qty_shipped,  order_id FROM sales_flat_order_item  group by order_id having sum_qty_shipped = 0)");
        $select->where("main_table.shipping_method='$shippingmethod'")
        	->join(array('p1'=>'sales_flat_order_payment'), 'p1.parent_id=main_table.entity_id', 'method')
        	->join(array('shipped'=>$exp),'shipped.order_id=main_table.entity_id')
        	;
        	
        	
 		//die($this->getSelect()->__toString());       	
        	return $this;
 	}
 	
 	
 	public function getMissingProducts()
 	{
 		return  $this->_missingProducts;
 	}
 	
 	protected function _afterLoad()
 	{
 		//Versandlager finden
 		if($this->_shippingmethod == 'storepickup_storepickup')
 		{
 			$stock = Mage::getModel('slpbshipping/carrier_pickup')->getConfigData('stock');
 		}
 		else 
 		{
 			$stock = Mage::getModel('slpbshipping/carrier_shipping')->getConfigData('stock');
 		}
 		//lagerbestand ermitteln und in ass. Array schreiben
 		$stockitems = Mage::getResourceModel('extstock/detail_collection');
 		
 		
 		if($stock != null)
 		{
 			$stockitems->getSelect()->where("main_table.stock_id=".$stock);
 		}
 		
 		$havingItems = array();
 		foreach($stockitems->getItems() as $item)
 		{
 			$havingItems[$item->getProductId()] = $item->getQty()+0;
 		}
 		
 		
		//alle Items der Bestellung finden
 		$orderids = array();
 		foreach($this->getItems() as $item)
 		{
 			$orderids[] = $item->getId();
 		}
 		
 		$orderItems = Mage::getResourceModel('sales/order_item_collection');
 		if(count($orderids) > 0)
 		{
	 		$orderItems->getSelect()
	 			->where("order_id in (".implode(',',$orderids).")")
	 			->order("order_id");
 			
	 		//fehlende Items pro Bestellung merken
	 		$missingItems = array();
	 		foreach($orderItems->getItems() as $item)
	 		{
	 			$product = $item->getProductId();
	 			if(isset($havingItems[$product]))
	 			{
	 				if($item->getQtyOrdered() > $havingItems[$product])
	 				{
	 					if(!isset($missingItems[$item->getOrderId()]))
	 					{
	 						$missingItems[$item->getOrderId()] = array();
	 					}
	 					$missingItems[$item->getOrderId()][] = $item->getSku() . " (".intval($item->getQtyOrdered()).")" ;
	 				}
	 				$havingItems[$product] = $havingItems[$product] - $item->getQtyOrdered();
	 				$this->_missingProducts[$item->getSku()] =array('name' => $item->getName(), 'qty'=>$havingItems[$product]);
	 			}
	 			else //falls gar nicht vorhanden weil neu
	 			{
	 				$missingItems[$item->getOrderId()][] = $item->getSku() . " (".intval($item->getQtyOrdered()).")" ;
	 			}
	 		}
	
	 		//die fehlenden an die Bestellung anh�ngen
	 		foreach($this->getItems() as $item)
	 		{
	 			if(isset($missingItems[$item->getId()]))
	 			{
	 				$item->setMissingItems(implode(', ',$missingItems[$item->getId()]));
	 			}
	 		}
 		}
 	
 	}
 	
 
}
