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
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "PRODUCT_ID";
	
	
	/* @var $config_code_fix Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ConfigCodeFix */
public $config_code_fix = null;
/* @var $lot_number Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_LotNumber */
public $lot_number = null;
/* @var $serial_number Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_SerialNumber */
public $serial_number = null;
/* @var $manufacturer_info Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ManufacturerInfo */
public $manufacturer_info = null;
/* @var $supplier_pid Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_SupplierPid */
public $supplier_pid = null;
/* @var $supplier_idref Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_SupplierIdref */
public $supplier_idref = null;
/* @var $international_pid Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_InternationalPid */
public $international_pid = null;
/* @var $buyer_pid Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_BuyerPid */
public $buyer_pid = null;
/* @var $description_short Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_DescriptionShort */
public $description_short = null;
/* @var $description_long Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_DescriptionLong */
public $description_long = null;
/* @var $product_type Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ProductType */
public $product_type = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->config_code_fix = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ConfigCodeFix($node,$this->_xml);
$this->lot_number = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_LotNumber($node,$this->_xml);
$this->serial_number = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_SerialNumber($node,$this->_xml);
$this->manufacturer_info = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ManufacturerInfo($node,$this->_xml);
$this->supplier_pid = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_SupplierPid($node,$this->_xml);
$this->supplier_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_SupplierIdref($node,$this->_xml);
$this->international_pid = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_InternationalPid($node,$this->_xml);
$this->buyer_pid = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_BuyerPid($node,$this->_xml);
$this->description_short = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_DescriptionShort($node,$this->_xml);
$this->description_long = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_DescriptionLong($node,$this->_xml);
$this->product_type = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ProductType($node,$this->_xml);
	}
	
	
	
    
}
