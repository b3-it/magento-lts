<?php
/**
 * Ordnet bestellte Produkte wieder ihren entsprechenden Lagerlieferungen zu
 *
 * @category	Slpb
 * @package		Slpb_Extstock
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2010 - 2012 EDV Beratung Hempel
 * @copyright	Copyright (c) 2010 - 2012 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Slpb_Extstock_Model_Salesorder extends Mage_Core_Model_Abstract
{
	protected $notManaged = false;
	
	/**
	 * Magento Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Varien_Object::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        
        //Sollte damit auf Slpb_Extstock_Model_Mysql4_SalesOrder zeigen
        $this->_init('extstock/salesorder');
    }
    
    /**
     * Übersetzungsfunktion
     * 
     * @param string $text Text
     * 
     * @return string
     */
    public function __($text = '') {
    	return Mage::helper('extstock')->__($text);
    }
    
    /**
     * Prüft ob die Voraussetzungen zum Speichern erfüllt sind
     * 
     * @param Mage_Sales_Model_Order_Item $salesOrderItem Sales Order Item
     * 
     * @return boolean
     */
    protected function _checkPreConditions($salesOrderItem) {
    	if (!$salesOrderItem || !($salesOrderItem instanceof Mage_Sales_Model_Order_Item)) {
			return false;
    	}
		
		if ($salesOrderItem->getStatusId() === Mage_Sales_Model_Order_Item::STATUS_CANCELED) {
			$helper = Mage::helper('extstock');
			$msg = $helper->__("Extended Stock").": ";
			$msg .= $helper->__("Item in order allready canceled [Order ID: %s;Item ID: %s]", $salesOrderItem->getOrderID(), $salesOrderItem->getId())."!";
			Mage::log("extstock::$msg", Zend_Log::NOTICE, Slpb_Extstock_Helper_Data::LOG_FILE);
			Mage::getSingleton('adminhtml/session')->addWarning($msg);
			return false;
		}
		
		return true;
    }
    
    /**
     * Bucht stornierte Items in der erweiterten Lagerverwaltung zurück.
     * Wichtig:
     * Diese Funktion wird pro bestelltes Produkt aufgerufen, und NICHT pro Bestellung!!!
     * 
     * @param Mage_Sales_Model_Order_Item $salesOrderItem Ein bestelltes Produkt
     * 
     * @return Slpb_Extstock_Model_SalesOrder
     */
    public function salesOrderItemCancel($salesOrderItem) {
    	if (!$this->_checkPreConditions($salesOrderItem)) {
			return $this;
    	}
    	$qtyToCancel = 0;
		//Kindelemente von Configurable Products sind Dummies
		if ($salesOrderItem->isDummy()
			&& !is_null($parentItem = $salesOrderItem->getParentItem())
		) {
			//Es wird erst das Configurabe Product storniert dann seine Kinder!
			//->Können also nur noch QtyCanceled abfragen!
			$qtyToCancel = $parentItem->getQtyCanceled();
		} else {
			$qtyToCancel = $salesOrderItem->getQtyToCancel();	
		}
		
		$this->_backToStock($salesOrderItem, $qtyToCancel);
		
		return $this;
    }
    
	/**
     * Bucht gutgeschriebene Items in der erweiterten Lagerverwaltung zurück.
     * Wichtig:
     * Diese Funktion wird pro bestelltes Produkt aufgerufen, und NICHT pro Bestellung!!!
     * 
     * @param Mage_Sales_Model_Order_Item $salesOrderItem Ein bestelltes Produkt
     * 
     * @return Slpb_Extstock_Model_SalesOrder
     */
    public function salesOrderItemRefund($salesOrderItem) {
    	if (!$this->_checkPreConditions($salesOrderItem)) {
			return $this;
    	}
		
    	$backToStock = 0;
		//Kindelemente von Configurable Products sind Dummies
		if ($salesOrderItem->isDummy()
			&& !is_null($parentItem = $salesOrderItem->getParentItem())
		) {
			//Es wird erst das Configurabe Product storniert dann seine Kinder!
			//->Können also nur noch QtyCanceled abfragen!
			$backToStock = $parentItem->getQtyRefunded();
		} else {
			$backToStock = $salesOrderItem->getQtyRefunded();	
		}
		
		$this->_backToStock($salesOrderItem, $backToStock);
		
		return $this;
    }
    
    /**
     * Bucht stornierte/gutgeschriebene Items in der erweiterten Lagerverwaltung zurück.
     * Wichtig:
     * Diese Funktion wird pro bestelltes Produkt aufgerufen, und NICHT pro Bestellung!!!
     * 
     * @param Mage_Sales_Model_Order_Item $salesOrderItem Ein bestelltes Produkt
     * @param Integer                     $backToStock    Anzahl der Produkte die zurück in Lager sollen
     * 
     * @return Slpb_Extstock_Model_SalesOrder
     */
	protected function _backToStock($salesOrderItem, $backToStock = 0) {
		$orderId = $salesOrderItem->getOrderID();
		$productId = $salesOrderItem->getProductID();
				
		$collection = $this->getCollection();
		
		if (!$collection) {
			Mage::throwException("extstock::Fatal error no resource collection found [Resource Name:".$this->getResourceName()."]");
		}
		if (!($collection instanceof Slpb_Extstock_Model_Mysql4_SalesOrder_Collection)) {
			Mage::throwException("extstock::Wrong type of collection. 'Slpb_Extstock_Model_Mysql4_SalesOrder_Collection' expected!");
		}
		
		$extstockModel = Mage::getModel("extstock/extstock");
		$extstockModel->getResource()->beginTransaction();
		
		try {
			//extstock_id ist eindeutig!!!
			$extstock = $extstockModel->getCollection();

			$extstockTableName = 'extstock';
			$collection = $collection->addFieldToFilter("sales_order_id", array("eq" => $orderId))
									->join($extstockTableName, //entity
											"$extstockTableName.extstock_id = main_table.extstock_id",
											array("product_id")
									)->addFieldToFilter("product_id", array("eq" => $productId));
			
			if (!$collection) {
				$extstockModel->getResource()->rollBack();
				Mage::throwException("extstock::Collection was null.");
			}
			
			//TODO: Meldung falls extstock collection size < sales_order_items collection size!
			
			$order  = Mage::getModel('sales/order')->load($orderId);
			
			$carrier = $order->getShippingCarrier();
			$decreaseOnShipping = false;
			if ($carrier instanceof Slpb_Shipping_Model_Carrier_Abstract
				&& $carrier->getConfigData('decrease_event') == Slpb_Shipping_Model_System_Config_Decrease::DECREASE_ON_SHIPPING
			) {
				$decreaseOnShipping = true;
			}
			
			$hasShipments = false;
			if ($order->hasShipments()) {
				$hasShipments = true;
			}
			
			//falls noch nichts verschifft
			if( $decreaseOnShipping && !$hasShipments)
			{
				//Könnte auch commit sein, es ist bisher noch nix passiert!
				$extstockModel->getResource()->rollBack();
				return $this;
			}
			
			
			//Kann für alte Produkte passieren, die vor der erweiterten Lagerverwaltung gekauft worden!!
			if (($collection->getSize() < 1 && $hasShipments && $decreaseOnShipping)
				|| $collection->getSize() < 1 && !$decreaseOnShipping
			) {
				$this->_addNotManagedWarning($orderId, $productId);
								
				//Könnte auch commit sein, es ist bisher noch nix passiert!
				$extstockModel->getResource()->rollBack();
				
				return $this;
			}
			
			foreach ($collection->getItems() as $item) {
				if (!$item) {
					continue;
				}
				
				$extItem = $extstock->getItemById($item->getExtstockID());
				
				//Kommt sonst zu doppelten Stornierungen! -->eigentlich seit 01.03.2010 veraltet!
				//->siehe Collectionzusammenstellung weiter oben!
				if ($productId != $extItem->getProductId()) {
					$this->_addNotManagedWarning($orderId, $productId);
					continue;
				}
				
				if (is_null($extItem)) {
					$extstockModel->getResource()->rollBack();
					Mage::throwException("extstock::Missing extstock item [ID:".$item->getExtstockID()."]. Maybe the database integrity is corrupted!");
				}
				
				$qty = $extItem->getQuantity();
				$qtyOrdered = $extItem->getQuantityOrdered();
				//Menge die dieses Item überhaupt aufnehmen kann (Notwendig wegen ZVM568)
				//Rundungsfehler bei gleichgroßen Zahlen vermeiden
				$maxBackToStock = round($qtyOrdered - $qty, 4);
				//Menge die aus diesem Extstockitem in Lieferung übernommen wurde.
				$maxBackToStockForOrderItem = $item->getQtyOrdered();
				
				//Falls Produkt in einer Bestellung aus mehreren Lagerlieferungen stammt!
				if ($backToStock > $maxBackToStockForOrderItem) {
					$subBackToStock  = max($maxBackToStockForOrderItem, 0);
					
					$backToStock = max($backToStock - $subBackToStock, 0);
					if ($subBackToStock > $maxBackToStock) {
						//Fall durch #1181 (ZVM568) möglich, sonst nicht
						$maxBackToStock = max($maxBackToStock, 0);
						$backToStock = $backToStock + max($subBackToStock - $maxBackToStock, 0);
						$extItem->setData("quantity", $qty+$maxBackToStock);
					} else {
						$extItem->setData("quantity", $qty+$subBackToStock);
					}
				} else {
					if ($backToStock > $maxBackToStock) {
						//Fall durch #1181 (ZVM568) möglich, sonst nicht
						$maxBackToStock = max($maxBackToStock, 0);
						$backToStock = max($backToStock - $maxBackToStock, 0);
						$extItem->setData("quantity", $qty+$maxBackToStock);
					} else {
						$extItem->setData("quantity", $qty+$backToStock);
						$backToStock = 0;
					}
				}
				$extItem->save(true);
			}
			//Verursacht Fehler: da das Element am ende irgendwie leer ist??? -->jedes element einzeln speichern!!
			//SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`magento`.`extstock`, CONSTRAINT `extstock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON DELETE CASCADE)
			//$extstockModel->save();
			if ($backToStock != 0.0) {
				$msg = Mage::helper('extstock')->__("Data integrity is corrupted, not all items can return to stock (rest: %s)", $backToStock);
				$msg .= "!";
				Mage::log(
						"extstock::".$msg,
						Zend_Log::WARN,
						Egovs_Extstock_Helper_Data::LOG_FILE
				);
				Mage::getSingleton('adminhtml/session')->addWarning($msg);
			}
			
			$extstockModel->getResource()->commit();
		} catch (Exception $e){
            $extstockModel->getResource()->rollBack();
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::throwException($e->getMessage());
        }
		return $this;
    }
    
    /**
     * Logging für Produkte die nicht von der Erweiterten Lagerverwaltung verwaltet werden
     * 
     * @param int $orderId   Bestell ID
     * @param int $productId Produkt ID
     * 
     * @return void
     */
    protected function _addNotManagedWarning($orderId=-1, $productId=-1) {
    	$helper = Mage::helper('extstock');
		$mA = $helper->__('Item is not managed by extended stock');
		$mB = $helper->__('Skipping cancelling of order item for extended stock');
		//$mC = $helper->__('in most cases you can ignore this message');
		$msg = "$mA [Order ID:$orderId;Product ID: $productId]. $mB.";
		Mage::log("extstock::".$msg, Zend_Log::NOTICE, Slpb_Extstock_Helper_Data::LOG_FILE);
		Mage::getSingleton('adminhtml/session')->addWarning($msg);
    }
}