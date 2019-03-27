<?php

/**
 * 
 * @author h.koegel
 *
 */
class Gka_InternalPayId_Block_Catalog_Product_View_Type extends Mage_Catalog_Block_Product_View_Type_Virtual
{
		public function getKzInfoUrl()
		{
			return $this->getUrl('internalpayid/index/kzinfo');
		}
		
		/**
		 * Get JSON encoded configuration array which can be used for JS dynamic
		 * price calculation depending on product options
		 *
		 * @return string
		 */
		public function getJsonConfig()
		{
			$config = array();
			 
		
			$_request = Mage::getSingleton('tax/calculation')->getDefaultRateRequest();
			/* @var $product Mage_Catalog_Model_Product */
			$product = $this->getProduct();
			$_request->setProductClassId($product->getTaxClassId());
			$defaultTax = Mage::getSingleton('tax/calculation')->getRate($_request);
		
			$_request = Mage::getSingleton('tax/calculation')->getRateRequest();
			$_request->setProductClassId($product->getTaxClassId());
			$currentTax = Mage::getSingleton('tax/calculation')->getRate($_request);
		
			$_regularPrice = $product->getPrice();
			$_finalPrice = $product->getFinalPrice();
			if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
				$_priceInclTax = Mage::helper('tax')->getPrice($product, $_finalPrice, true,
						null, null, null, null, null, false);
				$_priceExclTax = Mage::helper('tax')->getPrice($product, $_finalPrice, false,
						null, null, null, null, null, false);
			} else {
				$_priceInclTax = Mage::helper('tax')->getPrice($product, $_finalPrice, true);
				$_priceExclTax = Mage::helper('tax')->getPrice($product, $_finalPrice);
			}
			$_tierPrices = array();
			$_tierPricesInclTax = array();
			foreach ($product->getTierPrice() as $tierPrice) {
				$_tierPrices[] = Mage::helper('core')->currency(
						Mage::helper('tax')->getPrice($product, (float)$tierPrice['website_price'], false) - $_priceExclTax
						, false, false);
				$_tierPricesInclTax[] = Mage::helper('core')->currency(
						Mage::helper('tax')->getPrice($product, (float)$tierPrice['website_price'], true) - $_priceInclTax
						, false, false);
			}
			$config = array(
					'productId'           => $product->getId(),
					'priceFormat'         => Mage::app()->getLocale()->getJsPriceFormat(),
					'includeTax'          => Mage::helper('tax')->priceIncludesTax() ? 'true' : 'false',
					'showIncludeTax'      => Mage::helper('tax')->displayPriceIncludingTax(),
					'showBothPrices'      => Mage::helper('tax')->displayBothPrices(),
					'productPrice'        => Mage::helper('core')->currency($_finalPrice, false, false),
					'productOldPrice'     => Mage::helper('core')->currency($_regularPrice, false, false),
					'priceInclTax'        => Mage::helper('core')->currency($_priceInclTax, false, false),
					'priceExclTax'        => Mage::helper('core')->currency($_priceExclTax, false, false),
					/**
					 * @var skipCalculate
			* @deprecated after 1.5.1.0
			*/
					'skipCalculate'       => ($_priceExclTax != $_priceInclTax ? 0 : 1),
					'defaultTax'          => $defaultTax,
					'currentTax'          => $currentTax,
					'idSuffix'            => '_clone',
					'oldPlusDisposition'  => 0,
					'plusDisposition'     => 0,
					'plusDispositionTax'  => 0,
					'oldMinusDisposition' => 0,
					'minusDisposition'    => 0,
					'tierPrices'          => $_tierPrices,
					'tierPricesInclTax'   => $_tierPricesInclTax,
			);
		
			 
		
			return Mage::helper('core')->jsonEncode($config);
		}
		
		public function getClientSelectBox()
		{
		    $collection = Mage::getModel('internalpayid/specializedProcedure_client')->getCollection();
			$collection->getSelect()->where("FIND_IN_SET(?,visible_in_stores) > 0", Mage::app()->getStore()->getGroupId());
			$txt = array();
			$txtAdditionalOptions = array();
			$_clientsAvailable = false;
			$_htmlClass = array('required-entry');

			foreach ($collection as $client) {
			    if (!$client->getClient() || !$client->getPayOperator()) {
			        continue;
                }
				$tmp = sprintf('%s/%s', $client->getClient(), $client->getPayOperator());
                $txtAdditionalOptions[] = '<option value="'.$tmp.'">'. $client->getTitle() .'</option>';
				$_clientsAvailable = true;
			}


			if (!$_clientsAvailable) {
			    $this->setPayClientValidationAdvice($this->__("No valid specialized procedure configuration available"));
			    $_htmlClass[] = 'validation-failed';
            }
            $_htmlClass = implode(" ", $_htmlClass);
            $txt[] = sprintf('<select id="pay_client" name="pay_client" class="%s">', $_htmlClass);
            $txt[] = '<option value="">-- Bitte wählen --</option>';
            $txt = array_merge($txt, $txtAdditionalOptions);
            $txt[] = '</select>';

			return implode(' ',$txt);
		}
}
