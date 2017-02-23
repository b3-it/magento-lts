<?php
class Dwd_ProductOnDemand_Helper_Data extends Mage_Downloadable_Helper_Data
{
	/**
	 * Setzt abgelaufene Links auf den entspr. Status
	 * 
	 * @param Varien_Object $context Kontext
	 *
	 * @return Dwd_ProductOnDemand_Helper_Data
	 */
	public function cleanUpExpiredPurchasedLinks($context = null) {
		if (!$context) {
			$context = new Varien_Object();
		}
		
		/* @var $expiredCollection Mage_Downloadable_Model_Resource_Link_Purchased_Item_Collection */
		$expiredCollection = Mage::getModel('downloadable/link_purchased_item')->getCollection();
		$expiredCollection->addFieldToFilter('valid_to', array('notnull' => true));
		$expiredCollection->addFieldToFilter('valid_to', array('lteq' => date(Varien_Date::DATETIME_PHP_FORMAT)));
		
		if ($context->hasExpirePurchasedLinksAdditionalFilterFields()) {
			foreach ($context->getExpirePurchasedLinksAdditionalFilterFields() as $field => $condition) {
				$expiredCollection->addFieldToFilter($field, $condition);
			}
		}
		
		/* @var $link Mage_Downloadable_Model_Link_Purchased_Item */
		foreach ($expiredCollection as $link) {
			if ($link->getStatus() != Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_EXPIRED) {
				$link->setStatus(Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_EXPIRED);
			}
		}
		$expiredCollection->save();
		
		return $this;
	}
	
	protected function _getWesteProductInfo($item, $key) {
		if ($item instanceof Mage_Sales_Model_Order_Item) {
			$req = $item->getProductOptionByCode('info_buyRequest');
		} else {
			$req = $item->getOptionByCode('info_buyRequest');
			if ($req) {
				$req = unserialize($req->getData('value'));
			}
		}
		if (is_array($req)) {
			if (isset($req['product_info'])) {
				if (isset($req['product_info'][$key])) {
					return $req['product_info'][$key];
				}
			}
		}
		return array();
	}

	public function getStations($item) {
		if ($options = $this->_getWesteProductInfo($item, 'stations')) {
			if (isset($options['station']) && is_array($options['station'])) {
				return $options['station'];
			} else {
				return $options;
			}
		}
		return "";
	}
	
	public function getProducts($item) {
		if ($options = $this->_getWesteProductInfo($item, 'products')) {
			if (isset($options['product']) && is_array($options['product'])) {
				return $options['product'];
			} else {
				return $options;
			}
		}
		return "";
	}
	
	public function getFormats($item) {
		if ($options = $this->_getWesteProductInfo($item, 'exportFormats')) {
			if (isset($options['format']) && is_array($options['format'])) {
				return $options['format'];
			} else {
				return $options;
			}
		}
		return "";
	}
	
	public function getStartDate($item) {
		if ($str = $this->_getWesteProductInfo($item, 'startDate')) {
			return substr($str, 0, 7);
		}
		return false;
	}
	
	/**
	 * Erzeugt aus einem Array einen String mit <dt> und <dd> tags für ein <dl> tag. 
	 *
	 * @param string $label Label, wird in Funktion übersetzt
	 * @param array  $list  Liste
	 *
	 * @return string
	 */
	public function getListAsHtml($label, $list) {
		$html = "<dt>".$this->escapeHtml($this->__($label))."</dt>";
		$i = 0;
	
		foreach ($list as $item) {
			$html .= "<dd>";
			if (0 == $i) {
				$html .= $this->escapeHtml("$item");
			} else {
				$html .= $this->escapeHtml(", $item");
			}
			$html .= "</dd>";
			$i++;
		}
	
		return $html;
	}
}