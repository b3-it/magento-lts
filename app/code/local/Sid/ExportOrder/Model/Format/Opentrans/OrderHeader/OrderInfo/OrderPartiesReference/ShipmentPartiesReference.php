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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_ShipmentPartiesReference extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "SHIPMENT_PARTIES_REFERENCE";
	
	
	/* @var $delivery_idref Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_ShipmentPartiesReference_DeliveryIdref */
public $delivery_idref = null;
/* @var $final_delivery_idref Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_ShipmentPartiesReference_FinalDeliveryIdref */
public $final_delivery_idref = null;
/* @var $deliverer_idref Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_ShipmentPartiesReference_DelivererIdref */
public $deliverer_idref = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->delivery_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_ShipmentPartiesReference_DeliveryIdref($node,$this->_xml);
$this->final_delivery_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_ShipmentPartiesReference_FinalDeliveryIdref($node,$this->_xml);
$this->deliverer_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_ShipmentPartiesReference_DelivererIdref($node,$this->_xml);
	}
	
	
	
    
}
