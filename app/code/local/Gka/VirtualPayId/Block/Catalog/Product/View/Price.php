<?php

/**
 * 
 * @author h.koegel
 *
 */
class Gka_VirtualPayId_Block_Catalog_Product_View_Price extends Mage_Catalog_Block_Product_View_Type_Virtual
{
	protected $_kassenzeichen = null;
	
	public function fetchPrice($mandant,$kz) {
		$this->_kassenzeichen = $kz;
		
		if (!empty($kz) && is_string($kz)) {
			/** @var $helper Egovs_Paymentbase_Helper_Data */
			$helper = Mage::helper('paymentbase');
			$kInfo = $helper->lesenKassenzeichenInfo($kz,$mandant);
			if ($kInfo instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis) {
				if ($kInfo->ergebnis->isOk() == false) {
					$msg = sprintf(
							"%s; Error code: %s; Kassenzeichen: %s",
							$kInfo->ergebnis->getLongText(),
							$kInfo->ergebnis->getCode(),
							$kz
					);
					Mage::log("paymentbase::$msg", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
				} else {
					//OK
					if ($kInfo->saldo > 0.01) {
						$this->setBasePrice($kInfo->saldo);
						$this->setTemplate('gka/virtualpayid/catalog/product/view/price.phtml');
						return $this;
					}else{
						$this->setTemplate('gka/virtualpayid/catalog/product/view/priceempty.phtml');
						return $this;
					}
				}
			}
		}
		//fallback
		$this->setTemplate('gka/virtualpayid/catalog/product/view/pricemanual.phtml');
		
		return $this;
	}
	
	
	
}
