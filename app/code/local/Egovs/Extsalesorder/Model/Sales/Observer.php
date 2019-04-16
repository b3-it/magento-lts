<?php
/**
 * Oberserver für gemeinsam genutzte Methoden zur ePayment-Kommunikation.
 *
 * @category	Egovs
 * @package		Egovs_Extsalesorder
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */

class Egovs_Extsalesorder_Model_Sales_Observer
{
	/**
	 * Fügt virtuelle Spalten eines Grids zur Erzeugungsroutine von Bestelleinträgen hinzu.
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function addColumnToInvoiceResource(Varien_Event_Observer $observer)
	{
		/* @var $resource Mage_Sales_Model_Resource_Order_Invoice */
		$resource = $observer->getEvent()->getResource();
		
		$adapter = $resource->getReadConnection();
		$checkedCompany	 = '{{table}}.company';
		$checkedCompany2 = '{{table}}.company2';
		$checkedCompany3 = '{{table}}.company3';
		
		$checkedStreet	 = $adapter->getIfNullSql('{{table}}.street', $adapter->quote(''));
		$checkedCity	 = $adapter->getIfNullSql('{{table}}.city', $adapter->quote(''));
		$checkedPostcode = $adapter->getIfNullSql('{{table}}.postcode', $adapter->quote(''));
		
		$resource->addVirtualGridColumn(
				'kassenzeichen',
				'sales/order_payment',
				//Tabellenschlüssel => Fremdschlüssel
				array('order_id' => 'parent_id'),
				'kassenzeichen'
		)
		->addVirtualGridColumn(
				'payment_method',
				'sales/order_payment',
				//Tabellenschlüssel => Fremdschlüssel
				array('order_id' => 'parent_id'),
				'method'
		)
		->addVirtualGridColumn(
            'billing_company',
            'sales/order_address',
            array('billing_address_id' => 'entity_id'),
            $adapter->getConcatSql(array($checkedCompany, $checkedCompany2, $checkedCompany3), ',<br>')
        )
        ->addVirtualGridColumn(
        		'billing_address',
        		'sales/order_address',
        		array('billing_address_id' => 'entity_id'),
        		$adapter->getConcatSql(array($checkedStreet, $adapter->quote("<br>\n"), $checkedCity, $adapter->quote(" "), $checkedPostcode))
        );
	}
	
	/**
	 * Fügt virtuelle Spalten eines Grids zur Erzeugungsroutine von Bestelleinträgen hinzu.
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return void
	 */
	public function addColumnToOrderResource(Varien_Event_Observer $observer)
	{
		/* @var $resource Mage_Sales_Model_Resource_Order_Invoice */
		$resource = $observer->getEvent()->getResource();
	
		$adapter = $resource->getReadConnection();
		$checkedCompany	 = '{{table}}.company';
		$checkedCompany2 = '{{table}}.company2';
		$checkedCompany3 = '{{table}}.company3';
	
		$checkedStreet	 = $adapter->getIfNullSql('{{table}}.street', $adapter->quote(''));
		$checkedCity	 = $adapter->getIfNullSql('{{table}}.city', $adapter->quote(''));
		$checkedPostcode = $adapter->getIfNullSql('{{table}}.postcode', $adapter->quote(''));
	
		$resource->addVirtualGridColumn(
				'payment_method',
				'sales/order_payment',
				//Tabellenschlüssel => Fremdschlüssel
				array('entity_id' => 'parent_id'),
				'method'
		)
		->addVirtualGridColumn(
				'billing_company',
				'sales/order_address',
				array('billing_address_id' => 'entity_id'),
				$adapter->getConcatSql(array($checkedCompany, $checkedCompany2, $checkedCompany3), ',<br>')
		)
		->addVirtualGridColumn(
				'billing_address',
				'sales/order_address',
				array('billing_address_id' => 'entity_id'),
				$adapter->getConcatSql(array($checkedStreet, $adapter->quote("<br>\n"), $checkedCity, $adapter->quote(" "), $checkedPostcode))
		)
		->addVirtualGridColumn(
				'shipping_company',
				'sales/order_address',
				array('shipping_address_id' => 'entity_id'),
				$adapter->getConcatSql(array($checkedCompany, $checkedCompany2, $checkedCompany3), ',<br>')
		)
		->addVirtualGridColumn(
				'shipping_address',
				'sales/order_address',
				array('shipping_address_id' => 'entity_id'),
				$adapter->getConcatSql(array($checkedStreet, $adapter->quote("<br>\n"), $checkedCity, $adapter->quote(" "), $checkedPostcode))
		);
	}
	
	public function onAdminhtmlSalesOrderCreditmemoRegisterBefore($observer) {
		$creditmemo = $observer->getCreditmemo();
	
		$creditmemo->setSpecialCancel(true);
	
		/* @var $request Mage_Core_Controller_Request_Http */
		$request = $observer->getRequest();
		if ($request->getActionName() != 'new') {
			return;
		}
	
		foreach ($creditmemo->getAllItems() as $item) {
			if ($this->_canReturnItemToStock($item) && $item->getQty() > 0 && $item->getOrderItem()->getQtyToShip() > 0) {
				$item->setBackToStock(true);
			} else {
				$item->setBackToStock(false);
			}
		}
	}
	
	protected function _canReturnItemToStock($item=null) {
		$canReturnToStock = Mage::getStoreConfig(Mage_CatalogInventory_Model_Stock_Item::XML_PATH_CAN_SUBTRACT);
		if (!is_null($item)) {
			if (!$item->hasCanReturnToStock()) {
				$product = Mage::getModel('catalog/product')->load($item->getOrderItem()->getProductId());
				if ( $product->getId() && $product->getStockItem()->getManageStock() ) {
					$item->setCanReturnToStock(true);
				} else {
					$item->setCanReturnToStock(false);
				}
			}
			$canReturnToStock = $item->getCanReturnToStock();
		}
		return $canReturnToStock;
	}
	
	public function addOrderGridColumns($observer) {
	    $block = $observer->getBlock();
	    if (!($block instanceof Mage_Adminhtml_Block_Sales_Order_Grid)) {
	        return;
        }
	    /** @var \Mage_Adminhtml_Sales_OrderController $controller */
        $controller = Mage::app()->getFrontController()->getAction();
        $fullActionName = $controller->getFullActionName();
	    if ($block->getNameInLayout() === 'sales_order.grid' || stripos($fullActionName, 'adminhtml_sales_order_export') !== 0) {
	        return;
        }

	    $block->getLayout()->getUpdate()->load('add_order_grid_column_handle');
        $block->getLayout()->generateXml();

        $node = $block->getLayout()->getNode('reference');
        $node->attributes()->name = $block->getNameInLayout();

        $block->getLayout()->generateBlocks();
    }
}