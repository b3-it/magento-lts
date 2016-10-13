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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "CUSTOMER_ORDER_REFERENCE";
	
	
	/* @var $order_id Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_OrderId */
public $order_id = null;
/* @var $line_item_id Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_LineItemId */
public $line_item_id = null;
/* @var $order_date Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_OrderDate */
public $order_date = null;
/* @var $order_descr Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_OrderDescr */
public $order_descr = null;
/* @var $customer_idref Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_CustomerIdref */
public $customer_idref = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->order_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_OrderId($node,$this->_xml);
$this->line_item_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_LineItemId($node,$this->_xml);
$this->order_date = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_OrderDate($node,$this->_xml);
$this->order_descr = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_OrderDescr($node,$this->_xml);
$this->customer_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference_CustomerIdref($node,$this->_xml);
	}
	
	
	
    
}
