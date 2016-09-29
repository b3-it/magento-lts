<?php
/**
 * Sid ExportOrder_Format
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Format_Model_Plain
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Plain extends Sid_ExportOrder_Model_Format
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/format_plain');
    }
    
    public function processOrder($order)
    {
    	$line_separator = $this->getLineSeparator() ? $this->getLineSeparator() : "\n";
    	$item_separator = $this->getItemSeparator() ? $this->getItemSeparator() : "\t";
    	
    	$line_separator = $this->_fitEscape($line_separator);
    	$item_separator = $this->_fitEscape($item_separator);
    	 $result = array();
    	 
    	 $result[] = 'Rechnungsadresse';
    	 $result[] = $order->getBillingAddress()->getName();
    	 $result[] = $order->getBillingAddress()->getStreetFull();
    	 $result[] = $order->getBillingAddress()->getCity();
    	 $result[] = $order->getBillingAddress()->getPostcode();
    	 
    	 if($order->getShippingAddress())
    	 {
	    	$result[] = 'Lieferadresse';
	    	$result[] = $order->getShippingAddress()->getName();
	    	$result[] = $order->getShippingAddress()->getStreetFull();
	    	$result[] = $order->getShippingAddress()->getCity();
	    	$result[] = $order->getShippingAddress()->getPostcode();
    	 }
    	 
    	 $result[] = implode($item_separator,array('Artikelnummer','Bezeichnung','Menge','Preis'));
     	 
     	 foreach($order->getAllItems() as $item)
     	 {
     	 	$orderItem = array();
     	 	$orderItem[] = $item->getSku();
     	 	$orderItem[] = $item->getName();
     	 	$orderItem[] = $item->getQtyOrdered();
     	 	$orderItem[] = $item->getPrice();
     	 	
     	 	$result[] = implode($item_separator,$orderItem);
     	 }
    	 
     	 Sid_ExportOrder_Model_History::createHistory($order->getId(), 'Plaindatei erzeugt');
     	 
    	 return implode($line_separator,$result);
    }
    
    private function _fitEscape($value)
    {
    	if($value == '\\t') return "\t";
    	if($value == '\\n') return "\n";
    	if($value == '\\r') return "\r";
    	
    	return $value;
    }
}
