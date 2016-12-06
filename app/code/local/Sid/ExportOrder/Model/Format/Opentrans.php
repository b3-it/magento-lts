<?php
/**
 * Sid ExportOrder_Format Transdoc
 *
 * Erzeugen eines XML Streams für transdoc2.1
 * @category   	Sid
 * @package		Sid_ExportOrder_Format
 * @name	   	Sid_ExportOrder_Format_Model_Transdoc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Opentrans extends Sid_ExportOrder_Model_Format
{
	protected $_FileExtention = '.xml';

	public function _construct()
	{
		parent::_construct();
		$this->_init('exportorder/format_opentrans');
	}
	
	/**
	 * Erzeugen eines XML Streams für transdoc2.1
	 * {@inheritDoc}
	 * @see Sid_ExportOrder_Model_Format::processOrder()
	 * 
	 * @param  Mage_Sales_Model_Order $order
	 */
	public function processOrder($order)
	{
		$this->setLog('Erstelle opentrans für order: '.$order->getId() );

		$openTrans = new B3it_XmlBind_Opentrans21_Order();

		$openTrans->setAttribute("version", "2.1");
		$openTrans->setAttribute("type", "release");

		$orderHeader = $openTrans->getOrderHeader();

		$orderHeader->getControlInfo()->getGenerationDate()->setValue(Zend_Date::now()->toString(Zend_Date::ISO_8601));

		$orderInfo = $orderHeader->getOrderInfo();
		$orderInfo->getOrderId()->setValue($order->getIncrementId());
		$orderInfo->getOrderDate()->setValue($order->getCreatedAtDate()->toString(Zend_Date::ISO_8601));

		$orderInfo->getCurrency()->setValue($order->getOrderCurrencyCode());

		$agreement = $orderHeader->getSourcingInfo()->getAgreement();

		/** @var Sid_Framecontract_Model_Contract $contract **/
		$contract = Mage::getModel('framecontract/contract')->load($order->getFramecontract());
		$vendor = Mage::getModel('framecontract/vendor')->load($contract->getFramecontractVendorId());

		$agreement->getAgreementId()->setValue($contract->getContractnumber());

		$startDate = new Zend_Date($contract->getStartDate());
		$endDate =  new Zend_Date($contract->getEndDate());
		$agreement->getAgreementStartDate()->setValue($startDate->toString(Zend_Date::ISO_8601));
		$agreement->getAgreementEndDate()->setValue($endDate->toString(Zend_Date::ISO_8601));
		$agreement->getAgreementDescr()->setValue($contract->getTitle());
		$agreement->getSupplierIdref()->setValue('C_'.$vendor->getData('framecontract_vendor_id'));
		
		//rechnungsadresse
		/** @var Mage_Sales_Model_Order_Address $billing */
		$billing = $order->getBillingAddress();

		$billingParty = $orderInfo->getParties()->getParty();

		$billingParty->getPartyId()->setValue('B_'.$billing->getCustomerId());
		$billingParty->getPartyRole()->setValue("buyer");
		$billingParty->getPartyRole()->setValue("customer");
		$billingParty->getPartyRole()->setValue("invoice_recipient");

		$address = $billingParty->getAddress();
		$address->getName()->setValue($billing->getCompany());
		$address->getName2()->setValue($billing->getCompany2());
		$address->getName3()->setValue($billing->getCompany3());

		$contact = $address->getContactDetails();
		$contact->getContactId()->setValue('BA_'.$billing->getCustomerAddressId());
		$contact->getContactName()->setValue($billing->getLastname());
		$contact->getFirstName()->setValue($billing->getFirstname());

		$address->getCity()->setValue($billing->getCity());
		$address->getZip()->setValue($billing->getPostcode());
		$address->getCountry()->setValue($billing->getCountry());
		$address->getStreet()->setValue($billing->getStreetFull());
		$address->getEmail()->setValue($order->getCustomerEmail());

		//versandadresse
		if(!$order->getIsVirtual()){
			$shipping = $order->getShippingAddress();
			$shippingParty = $orderInfo->getParties()->getParty();

			$shippingParty->getPartyId()->setValue('S_'.$shipping->getCustomerId());
			$shippingParty->getPartyRole()->setValue("delivery");

			$address = $shippingParty->getAddress();
			$address->getName()->setValue($shipping->getCompany());
			$address->getName2()->setValue($shipping->getCompany2());
			$address->getName3()->setValue($shipping->getCompany3());

			$contact = $address->getContactDetails();
			$contact->getContactId()->setValue('SA_'.$shipping->getCustomerAddressId());
			$contact->getContactName()->setValue($shipping->getLastname());
			$contact->getFirstName()->setValue($shipping->getFirstname());

			$address->getCity()->setValue($shipping->getCity());
			$address->getZip()->setValue($shipping->getPostcode());
			$address->getCountry()->setValue($shipping->getCountry());
			$address->getStreet()->setValue($shipping->getStreetFull());

			$adr = Mage::getmodel('customer/address')->load($shipping->getCustomerAddressId());
			if(!empty($adr->getDap())){
				$txt = "Im Fall einer Lieferung 'frei Verwendungstelle' bitte hierher liefern: ".$adr->getDap();
				$address->getAddressRemarks()->setValue($txt);
			}
		}

		//lieferant
		$supplierParty = $orderInfo->getParties()->getParty();
		$supplierParty->getPartyId()->setValue('C_'.$vendor->getData('framecontract_vendor_id'));
		$supplierParty->getPartyRole()->setValue('supplier');

		$address = $supplierParty->getAddress();
		$address->getName()->setValue($vendor->getCompany());
		$address->getName2()->setValue($vendor->getOperator());

		$orderInfo->getOrderPartiesReference()->getBuyerIdref()->setValue('B_'.$billing->getCustomerId());
		$orderInfo->getOrderPartiesReference()->getInvoiceRecipientIdref()->setValue('B_'.$billing->getCustomerId());

		$orderInfo->getOrderPartiesReference()->getSupplierIdref()->setValue('C_'.$vendor->getData('framecontract_vendor_id'));

		$orderInfo->getCustomerOrderReference()->getCustomerIdref()->setValue('B_'.$billing->getCustomerId());

		$orderInfo->getCustomerOrderReference()->getOrderDescr()->setValue($contract->getTitle());

		$orderList = $openTrans->getOrderItemList();

		$i = 0;
		foreach($order->getAllItems() as $item)
		{
			/** @var Mage_Sales_Model_Order_Item $item */
			if ($item->getParentItemId() != null) {
				continue;
			}

			$order_item = $orderList->getOrderItem();
			$order_item->getLineItemId()->setValue($i++);

			$productId = $order_item->getProductId();
			$productId->getSupplierPid()->setValue($item->getProduct()->getSupplierSku());
			$productId->getDescriptionShort()->setValue($item->getName());
			$productId->getInternationalPid()->setValue($item->getProduct()->getEan());
			$productId->getBuyerPid()->setValue($item->getSku());
			if (!empty($item->getProductOptions())) {
				$options = $item->getProductOptions();
				if (isset($options['bundle_options'])) {
					$productId->getConfigCodeFix()->setValue($item->getSku());
				}
			}

			// TODO find a way to set the ManufacturName
			// it should have use ManufacturId

			$order_item->getQuantity()->setValue($item->getQtyOrdered());
			$order_item->getOrderUnit()->setValue('C62');
			$order_item->getProductPriceFix()->getPriceAmount()->setValue($item->getBasePrice());

			if (!empty($item->getProductOptions())) {
				$product = $item->getProduct();
				$options = $item->getProductOptions();

				if (isset($options['bundle_options'])) {
					/** @var Mage_Catalog_Model_Product_Type_Abstract $typeInstance */
					$typeInstance = $product->getTypeInstance(true);

					$comps = $order_item->getProductComponents();
					$opsel = $options['info_buyRequest']['bundle_option'];

					foreach ($options['bundle_options'] as $okey => $o) {

						$idxs = $opsel[$okey];
						if (!is_array($idxs)) {
							$idxs = array($idxs);
						}

						/** @var Mage_Bundle_Model_Resource_Selection_Collection $selectionCollection */
						$selectionCollection = $typeInstance->getSelectionsCollection(array($okey), $product);
						$selectionCollection->setSelectionIdsFilter($idxs);

						$selidx = 0;
						foreach ($selectionCollection as $selitem) {
							$sku = $selitem->getSku();
							// ignore base configuration object
							if (static::endsWith($sku, ":base")) {
								continue;
							}

							$osel = $o['value'][$selidx];

							$c = $comps->getProductComponent();

							$c->getQuantity()->setValue($osel['qty']);
							$c->getOrderUnit()->setValue('C62');
							$c->getProductPriceFix()->getPriceAmount()->setValue($osel['price']);

							$productId = $c->getProductId();
							$productId->getSupplierPid()->setValue($selitem->getSupplierSku());
							$productId->getDescriptionShort()->setValue($selitem->getName());
							$productId->getInternationalPid()->setValue($selitem->getEan());
							$productId->getBuyerPid()->setValue($selitem->getSku());

							$selidx++;
						}
					}
				} else if (isset($options['options'])) {
					$features = $order_item->getProductFeatures();
					foreach ($options['options'] as $o) {
						$f = $features->getFeature();
						$f->getFname()->setValue($o['label']);
						$f->getFvalue()->setValue($o['value']);
					}
				}
			}
		}

		$summary = $openTrans->getOrderSummary();
		$summary->getTotalAmount()->setValue($order->getBaseGrandTotal());
		$summary->getTotalItemNum()->setValue(count($order->getAllItems()));

		$xml = new DOMDocument('1.0', 'utf-8');
		$xml->formatOutput = true;
		$xml->preserveWhiteSpace = false;
		$openTrans->toXml($xml);

		return $xml->saveXML();
	}

	private static function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}
}
