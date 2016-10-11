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
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents_ProductComponent extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "PRODUCT_COMPONENT";
	
	
	/* @var $product_id Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents_ProductComponent_ProductId */
public $product_id = null;
/* @var $product_features Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents_ProductComponent_ProductFeatures */
public $product_features = null;
/* @var $quantity Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents_ProductComponent_Quantity */
public $quantity = null;
/* @var $order_unit Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents_ProductComponent_OrderUnit */
public $order_unit = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->product_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents_ProductComponent_ProductId($node,$this->_xml);
$this->product_features = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents_ProductComponent_ProductFeatures($node,$this->_xml);
$this->quantity = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents_ProductComponent_Quantity($node,$this->_xml);
$this->order_unit = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductComponents_ProductComponent_OrderUnit($node,$this->_xml);
	}
	
	
	
    
}
