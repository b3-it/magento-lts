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
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ManufacturerInfo extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "MANUFACTURER_INFO";
	
	
	/* @var $manufacturer_idref Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ManufacturerInfo_ManufacturerIdref */
public $manufacturer_idref = null;
/* @var $manufacturer_pid Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ManufacturerInfo_ManufacturerPid */
public $manufacturer_pid = null;
/* @var $manufacturer_type_descr Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ManufacturerInfo_ManufacturerTypeDescr */
public $manufacturer_type_descr = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->manufacturer_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ManufacturerInfo_ManufacturerIdref($node,$this->_xml);
$this->manufacturer_pid = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ManufacturerInfo_ManufacturerPid($node,$this->_xml);
$this->manufacturer_type_descr = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductId_ManufacturerInfo_ManufacturerTypeDescr($node,$this->_xml);
	}
	
	
	
    
}
