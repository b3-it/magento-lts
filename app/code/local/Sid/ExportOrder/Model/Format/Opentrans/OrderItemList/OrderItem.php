<?php
/**
 * Sid_ExportOrder_Model_Format_Opentrans
 *
 * Erzeugen eines XML Streams für OpenTrans 2.1
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Model_Format_Opentrans
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "ORDER_ITEM";
	
	
	/* @var $line_item_id Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_LineItemId */
public $line_item_id = null;
/* @var $product_id Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId */
public $product_id = null;
/* @var $product_features Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures */
public $product_features = null;
/* @var $product_components Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents */
public $product_components = null;
/* @var $quantity Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_Quantity */
public $quantity = null;
/* @var $product_price_fix Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix */
public $product_price_fix = null;
/* @var $price_line_amount Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_PriceLineAmount */
public $price_line_amount = null;
/* @var $partial_shipment_allowed Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_PartialShipmentAllowed */
public $partial_shipment_allowed = null;
/* @var $sourcing_info Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_SourcingInfo */
public $sourcing_info = null;
/* @var $remarks Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_Remarks */
public $remarks = null;
/* @var $item_udx Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ItemUdx */
public $item_udx = null;
/* @var $order_unit Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_OrderUnit */
public $order_unit = null;
/* @var $accounting_info Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_AccountingInfo */
public $accounting_info = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->line_item_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_LineItemId($node,$this->_xml);
$this->product_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId($node,$this->_xml);
$this->product_features = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures($node,$this->_xml);
$this->product_components = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents($node,$this->_xml);
$this->quantity = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_Quantity($node,$this->_xml);
$this->product_price_fix = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix($node,$this->_xml);
$this->price_line_amount = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_PriceLineAmount($node,$this->_xml);
$this->partial_shipment_allowed = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_PartialShipmentAllowed($node,$this->_xml);
$this->sourcing_info = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_SourcingInfo($node,$this->_xml);
$this->remarks = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_Remarks($node,$this->_xml);
$this->item_udx = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ItemUdx($node,$this->_xml);
$this->order_unit = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_OrderUnit($node,$this->_xml);
$this->accounting_info = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_AccountingInfo($node,$this->_xml);
	}
	
	
	
    
}
