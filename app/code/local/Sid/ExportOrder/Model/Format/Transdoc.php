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
class Sid_ExportOrder_Model_Format_Transdoc extends Sid_ExportOrder_Model_Format
{
	
	private $_xml = null;
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/format_transdoc');
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
    	$ORDER = $this->_xml->createElementNS('http://www.opentrans.org/XMLSchema/2.1', 'ORDER');
    	$this->_xml->appendChild($ORDER);
    	$ORDER->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:bmecat','http://www.bmecat.org/bmecat/2005');
    	$ORDER->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xmime','http://www.w3.org/2005/05/xmlmime');
    	
    	
    	$ORDER_HEADER = $this->_addElement('ORDER_HEADER',null, $ORDER);
    	$ORDER_INFO = $this->_addElement('ORDER_INFO', null, $ORDER_HEADER);
    	
    	
    	$this->_addAddresses($ORDER_INFO, $order);
    	
    	$ORDER_ITEM_LIST = $this->_addElement('ORDER_ITEM_LIST',null, $ORDER);
    	$this->_addItems($ORDER_ITEM_LIST,$order);
    	
    	$this->_addTotals($ORDER, $order);
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
     * die Adressen in den xml Baum einhängen
     * @param DOMElement                $parent
     * @param Mage_Sales_Model_Order    $order
     */
    protected function _addAddresses(DOMElement $parent, $order)
    {
    	$PARTIES = $this->_addElement('PARTIES',null, $parent);
    	$PARTIE = $this->_addElement('PARTIE',null, $PARTIES);
    	$PARTY_ROLE = $this->_addElement('PARTY_ROLE', 'buyer', $PARTIE);
    	$ADDRESS = $this->_addElement('ADDRESS', null, $PARTIE);
    	
    	$adr = $order->getBillingAddress();
    	$this->_addElement('bmecat:STREET', $adr->getStreetFull(), $ADDRESS);
    	$this->_addElement('bmecat:ZIP', $adr->getPostcode(), $ADDRESS);
    	$this->_addElement('bmecat:CITY', $adr->getCity(), $ADDRESS);
    	$this->_addElement('bmecat:COUNTRY', $adr->getCountry(), $ADDRESS);
    	
    	
    	if(!$order->getIsVirtual()){
    		$PARTIE = $this->_addElement('PARTIE',null, $PARTIES);
    		$PARTY_ROLE = $this->_addElement('PARTY_ROLE', 'xxxx', $PARTIE);
    		$ADDRESS = $this->_addElement('ADDRESS', null, $PARTIE);
    		$adr = $order->getShippingAddress();
    		$this->_addElement('bmecat:STREET', $adr->getStreetFull(), $ADDRESS);
    		$this->_addElement('bmecat:ZIP', $adr->getPostcode(), $ADDRESS);
    		$this->_addElement('bmecat:CITY', $adr->getCity(), $ADDRESS);
    		$this->_addElement('bmecat:COUNTRY', $adr->getCountry(), $ADDRESS);
    	}
    }
    
    /**
     * die OrderItems in den xml Baum einhängen
     * @param DOMElement               $parent
     * @param Mage_Sales_Model_Order   $order
     */
    protected function _addItems(DOMElement $parent, $order)
    {
    	$i = 0;
    	foreach($order->getAllItems() as $item)
    	{
    		$i++;
    		$ORDER_ITEM = $this->_addElement('ORDER_ITEM',null, $parent);
    		$this->_addElement('LINE_ITEM_ID',$i, $ORDER_ITEM);
    		
    		$PRODUCT_ID = $this->_addElement('PRODUCT_ID',null, $ORDER_ITEM);
    		$PRODUCT_ID = $this->_addElement('bmecat:SUPPLIER_PID',$item->getSku(), $PRODUCT_ID);
    		
    		$this->_addElement('QUANTITY',$item->getQtyOrdered(), $ORDER_ITEM);
    		$this->_addElement('PRICE_LINE_AMOUNT',$item->getBasePrice(), $ORDER_ITEM);
    		
    	}
    }
    
    
    /**
     * die Totals in den xml Baum einhängen
     * @param DOMElement               $parent
     * @param Mage_Sales_Model_Order   $order
     */
    protected function _addTotals(DOMElement $parent, $order)
    {
    	$ORDER_SUMMARY = $this->_addElement('ORDER_SUMMARY',null, $parent);
    	$this->_addElement('TOTAL_ITEM_NUM',count($order->getAllItems()), $ORDER_SUMMARY);
    	$this->_addElement('TOTAL_AMOUNT',$order->getBaseGrandTotal(), $ORDER_SUMMARY);
    }
    
}
