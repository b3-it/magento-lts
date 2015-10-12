<?php

class Stala_Abo_Model_Extstock_Mysql4_Collection extends Egovs_Extstock_Model_Mysql4_Extstock_Collection
{

	//TODO: hat hier nichts verloren, sollte besser ins Model übertragen werden!!!!
	/**
	 * Verringert die verfügbare Menge des jeweiligen Produktes
	 *
	 * @param int $product_id
	 * @param int $qty
	 * @return false|array Bei Erfolg Array mit extstock_ids und zugehörigen Mengen array(id => integer, qty => integer)
	 */
	public function decreaseQuantityPerProduct($product_id, $qty) {
		if (!($product_id && $qty))
			return false;
		if ($qty <= 0) {
			Mage::log("extstock::Quantity must be greater zero!", Zend_Log::WARN, Egovs_Extstock_Helper_Data::LOG_FILE);
			return false;
		}
			
		$sql = "SELECT extstock_id,quantity FROM ".$this->getTable("extstock")." WHERE quantity > 0 AND is_abo = 0 AND product_id=".$product_id." ORDER BY `date_ordered`, `extstock_id`";
		$data = $this->getConnection()->fetchAll($sql);

		$errorMessage = "extstock::No product in store found to decrease stock value! [Product ID: $product_id;Quantity: $qty]";
		if (!is_array($data)) {
			Mage::log($errorMessage, Zend_Log::ALERT, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
			return false;
		}

		$itemsToDecrease = array();
		$handledQuantity = 0;
		//kleinste ID sollte immer zuerst drin stehen!
		foreach ($data as $row) {
			if (!is_array($row)) {
				Mage::log($errorMessage, Zend_Log::ALERT, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
				continue;
			}
			if (!array_key_exists("extstock_id", $row)) {
				Mage::log($errorMessage." 'extstock_id' key is missing!", Zend_Log::ALERT, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
				continue;
			}
			if (!array_key_exists("quantity", $row)) {
				Mage::log($errorMessage." 'quantity' key is missing!", Zend_Log::ALERT, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
				continue;
			}
			if ($handledQuantity >= $qty)
			break;

			if ($row["quantity"] >= $qty-$handledQuantity) {
				$itemsToDecrease[] = array(
					"id" => $row["extstock_id"],
					"qty" => $qty-$handledQuantity
				);
				$handledQuantity += ($qty-$handledQuantity);
				break;
			} else {
				$itemsToDecrease[] = array(
					"id" => $row["extstock_id"],
					"qty" => $row["quantity"]
				);
				$handledQuantity += $row["quantity"];
			}
		}

		if ($handledQuantity < $qty) {
		Mage::log("extstock::Not enough products found to decrease stock value! [Product ID: $product_id;Quantity: $qty]",
				Zend_Log::WARN,
				Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
			$i = count($itemsToDecrease) - 1;
			if ($i >= 0) {
				/*20140714::Frank Rochlitzer
				 *Lagerbestand an neuem Item verbuchen um Magento-Lagerverwaltung bei möglichen Stornos/Gutschriften nicht auseinanderlaufen zu lassen
				 *Der Lagerbestand wird dann in der erweiterten Lagerverwaltung negativ!
				 */
				$negQty = round($qty - $handledQuantity, 8);
				$newNegativ = Mage::getModel('extstock/extstock')->load($itemsToDecrease[$i]['id']);
				$newNegativ->unsetData($newNegativ->getIdFieldName())
					->unsetData('id')
					->setCreatedTime(now())
					->setUpdateTime(now())
					->setData('quantity', 0)
					->setQuantityOrdered(0)
					->setPrice(0)
					->setDateOrdered(now())
					->setDateDelivered(now())
					->setOmitMagentoStockUpdate(true)
					->save()
				;
				$itemsToDecrease[] = array(
						"id" => $newNegativ["extstock_id"],
						"qty" => $negQty
				); 
			}
		}

		foreach ($itemsToDecrease as $item) {
			$sql = "UPDATE ".$this->getTable("extstock")." SET quantity=quantity-".$item["qty"]." WHERE extstock_id=".$item["id"];
			$this->getConnection()->query($sql);
		}

		return $itemsToDecrease;
	}
}