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

		$orderHeader = $openTrans->getOrderHeader();

		$orderHeader->getControlInfo()->getGenerationDate()->setValue(Zend_Date::now()->toString(Zend_Date::ISO_8601));

		$orderInfo = $orderHeader->getOrderInfo();
		$orderInfo->getOrderId()->setValue($order->getIncrementId());
		$orderInfo->getOrderDate()->setValue($order->getCreatedAtDate()->toString(Zend_Date::ISO_8601));

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
		$address->getZip()->setValue($billing->getCountry());
		$address->getCountry()->setValue($billing->getCity());
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
			$address->getZip()->setValue($shipping->getCountry());
			$address->getCountry()->setValue($shipping->getCity());
			$address->getStreet()->setValue($shipping->getStreetFull());

			$adr = Mage::getmodel('customer/address')->load($shipping->getCustomerAddressId());
			if(!empty($adr->getDap())){
				$txt = "Im Fall einer Lieferung 'frei Verwendungstelle' bitte hierher liefern: ".$adr->getDap();
				$address->getAddressRemarks()->setValue($txt);
			}
		}

		//lieferant
		/** @var Sid_Framecontract_Model_Contract $contract **/
		$contract = Mage::getModel('framecontract/contract')->load($order->getFramecontract());
		$vendor = Mage::getModel('framecontract/vendor')->load($contract->getFramecontractVendorId());

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
			$i++;
			$order_item = $orderList->getOrderItem();
			$order_item->getLineItemId()->setValue($i);

			$productId = $order_item->getProductId();
			$productId->getSupplierPid()->setValue($item->getProduct()->getSupplierSku());
			$productId->getDescriptionShort()->setValue($item->getName());
			$productId->getInternationalPid()->setValue($item->getProduct()->getEan());
			$productId->getBuyerPid()->setValue($item->getSku());

			// TODO find a way to set the ManufacturName
			// it should have use ManufacturId

			$order_item->getQuantity()->setValue($item->getQtyOrdered());
			$order_item->getOrderUnit()->setValue('C62');
			$order_item->getProductPriceFix()->getPriceAmount()->setValue($item->getBasePrice());

			if (!empty($item->getProductOptions())) {
				$order_item->getRemarks()->setValue(join(", ", $this->addProductCustomerOptions($item)));
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

	/**
	 * Formatierung der Individuellen Optionen als String Array
	 * @param Mage_Sales_Model_Order_Item $orderItem
	 * @return string[]
	 */
	protected function addProductCustomerOptions($orderItem)
	{
		$text = array();
		$product_options =  $orderItem->getProductOptions();
		if(isset($product_options['options']))
		{
			$options = $product_options['options'];
			foreach ($options as $option)
			{
				$tmp =  $this->getCustomerOptionText($option);
				if($tmp){
					$text[] = $tmp;
				}
			}
	
		}
		return $text;
	}
	
	/**
	 * individuelle formatierung einer Option in Abhängigkeit des Typs
	 * @param array $option
	 * @return string
	 */
	protected function getCustomerOptionText($option)
	{
		switch ($option['option_type'])
		{
			default: 
				{	
					$text = empty($option['value']) ? null :  $option['label'] .": ". $option['value'];
					return $text;
				}
		}
	}
	
}
