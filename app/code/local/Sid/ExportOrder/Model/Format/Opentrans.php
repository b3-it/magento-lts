<?php
/**
 * Sid ExportOrder_Format Transdoc
 *
 * Erzeugen eines XML Streams für transdoc2.1
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Format_Model_Transdoc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Opentrans extends Sid_ExportOrder_Model_Format
{
	protected $_FileExtention = '.xml';
	
	private $_xml = null;
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/format_opentrans');
    }
    
    /**
     * Erzeugen eines XML Streams für transdoc2.1
     * {@inheritDoc}
     * @see Sid_ExportOrder_Model_Format::processOrder()
     */
    public function processOrder($order)
    {
    	$this->_xml = new DOMDocument('1.0', 'utf-8');
    	$this->_xml->formatOutput = true;
    	$this->_xml->preserveWhiteSpace = false;
    	$ORDER = $this->_xml->createElementNS('http://www.opentrans.org/XMLSchema/2.1', 'ORDER');
    	$this->_xml->appendChild($ORDER);
    	$ORDER->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:bmecat','http://www.bmecat.org/bmecat/2005');
    	$ORDER->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xmime','http://www.w3.org/2005/05/xmlmime');
    	
    	/** @var Sid_ExportOrder_Model_Format_Opentrans_OrderHeader */
    	$ORDER_HEADER = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader($ORDER, $this->_xml);
    	$ORDER_HEADER->control_info->generation_date->setValue(now());
    	$ORDER_HEADER->order_info->order_id->setValue($order->getIncrementId());
    	
    	
    	
    	//rechnungsadresse
    	$billing = $order->getBillingAddress();
    	$ORDER_HEADER->order_info->parties->billingParty->party_id->setValue('B_'.$billing->getCustomerId());   	
    	$ORDER_HEADER->order_info->parties->billingParty->address->name->setValue($billing->getCompany());
    	$ORDER_HEADER->order_info->parties->billingParty->address->name2->setValue($billing->getCompany2());
    	$ORDER_HEADER->order_info->parties->billingParty->address->name3->setValue($billing->getCompany3());
    	
    	$ORDER_HEADER->order_info->parties->billingParty->address->contact_details->contact_id->setValue('BA_'.$billing->getCustomerAddressId());
    	$ORDER_HEADER->order_info->parties->billingParty->address->contact_details->contact_name->setValue($billing->getLastname());
    	$ORDER_HEADER->order_info->parties->billingParty->address->contact_details->first_name->setValue($billing->getFirstname());
    	
    	$ORDER_HEADER->order_info->parties->billingParty->address->city->setValue($billing->getCity());
    	$ORDER_HEADER->order_info->parties->billingParty->address->zip->setValue($billing->getPostcode());
    	$ORDER_HEADER->order_info->parties->billingParty->address->country->setValue($billing->getCountry());
    	$ORDER_HEADER->order_info->parties->billingParty->address->street->setValue($billing->getStreetFull());
    	
    	//versandadresse
    	if(!$order->getIsVirtual()){
	    	$shipping = $order->getShippingAddress();
	    	$ORDER_HEADER->order_info->parties->shippingParty->party_id->setValue('S_'.$shipping->getCustomerId());
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->name->setValue($shipping->getCompany());
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->name2->setValue($shipping->getCompany2());
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->name3->setValue($shipping->getCompany3());
	    	
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->contact_details->contact_id->setValue('SA_'.$shipping->getCustomerAddressId());
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->contact_details->contact_name->setValue($shipping->getLastname());
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->contact_details->first_name->setValue($shipping->getFirstname());
	    	
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->city->setValue($shipping->getCity());
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->zip->setValue($shipping->getPostcode());
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->country->setValue($shipping->getCountry());
	    	$ORDER_HEADER->order_info->parties->shippingParty->address->street->setValue($shipping->getStreetFull());
	    	
	    	$adr = Mage::getmodel('customer/address')->load($shipping->getCustomerAddressId());
	    	if(!empty($adr->getDap())){
	    		$txt = "Im Fall einer Lieferung 'frei Verwendungstelle' bitte hierher liefern: ".$adr->getDap();
	    		$ORDER_HEADER->order_info->parties->shippingParty->address->address_remarks->setValue($txt);
	    	}
	    	
	    	$ORDER_HEADER->order_info->order_parties_reference->shipment_parties_reference->final_delivery_idref->setValue('S_'.$shipping->getCustomerId());
    	}
    	
    	//lieferant
    	$contract = Mage::getModel('framecontract/contract')->load($order->getFramecontract());
  		$vendor = Mage::getModel('framecontract/vendor')->load($contract->getFramecontractVendorId());
    	$ORDER_HEADER->order_info->parties->supplierParty->party_id->setValue('C_'.$vendor->getData('framecontract_vendor_id'));
    	$ORDER_HEADER->order_info->parties->supplierParty->address->name->setValue($vendor->getCompany());
    	$ORDER_HEADER->order_info->parties->supplierParty->address->name2->setValue($vendor->getOperator());
    	
    	
    	$ORDER_HEADER->order_info->order_parties_reference->buyer_idref->setValue('B_'.$billing->getCustomerId());
    	$ORDER_HEADER->order_info->order_parties_reference->supplier_idref->setValue('C_'.$vendor->getData('framecontract_vendor_id'));
    	
    	
    	
    	//die Positionen
    	$ORDER_ITEM_LIST = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList($ORDER, $this->_xml);
    	$this->_addItems($ORDER_ITEM_LIST,$order);
    	
    	//totals
    	$ORDER_SUMMARY = new Sid_ExportOrder_Model_Format_Opentrans_OrderSummary($ORDER, $this->_xml);
    	$ORDER_SUMMARY->total_amount->setValue($order->getBaseGrandTotal());
    	$ORDER_SUMMARY->total_item_num->setValue(count($order->getAllItems()));
    	
      	Sid_ExportOrder_Model_History::createHistory($order->getId(), 'Opentransdatei erzeugt');
    	
    	$xpath = new DOMXPath($this->_xml);

	    while (($notNodes = $xpath->query('//*[not(node())]')) && ($notNodes->length)) {
		  foreach($notNodes as $node) {
		    $node->parentNode->removeChild($node);
		  }
		}
    	
    	
// 		//debug helper
//     	$text = htmlentities($this->_xml->saveXML());
//     	$text = str_replace("\n", "<br>", $text);
//     	echo '<pre>';
//     	die($text);
    	
    	
    	return $this->_xml->saveXML();
    }
    
    /**
     * helper: erzeugen und einfügen
     * @param string $name Knotenname
     * @param string $value Wert
     * @param DOMElement $parent Elternknoten
     * @return DOMElement
     */
    protected function _addElement($name, $value = null,  $parent = null)
    {
    	$node = $this->_xml->createElement($name, $value);
    	if($parent == null){
    		$parent = $this->_xml;
    	}
    	
    	$parent->appendChild($node);
    	return $node;
    }
    
    
    
    /**
     * die OrderItems in den xml Baum einhängen
     * @param DOMElement $parent
     * @param unknown $order
     */
    protected function _addItems(Sid_ExportOrder_Model_Format_Opentrans_OrderItemList $ORDER_ITEM_LIST, $order)
    {
    	$i = 0;
    	foreach($order->getAllItems() as $item)
    	{
    		$i++;
    		$order_item = $ORDER_ITEM_LIST->add();
    		$order_item->line_item_id->setValue($i);
    		$order_item->product_id->supplier_pid->setValue($item->getProduct()->getSupplierSku());
    		$order_item->product_id->description_short->setValue($item->getName());
    		$order_item->product_id->international_pid->setValue($item->getProduct()->getEan());
    		$order_item->product_id->buyer_pid->setValue($item->getSku());
    		$order_item->product_id->manufacturer_info->setValue($item->getProduct()->getManufacturerName());
    		
    		
    		
    		$order_item->quantity->setValue($item->getQtyOrdered());
    		$order_item->order_unit->setValue('C62');
    		$order_item->product_price_fix->price_amount->setValue($item->getBasePrice());
    		
    	}
    }
    
    
   
}
