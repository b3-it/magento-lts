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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_DeliveryDate extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "DELIVERY_DATE";
	
	
	/* @var $delivery_start_date Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_DeliveryDate_DeliveryStartDate */
public $delivery_start_date = null;
/* @var $delivery_end_date Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_DeliveryDate_DeliveryEndDate */
public $delivery_end_date = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->delivery_start_date = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_DeliveryDate_DeliveryStartDate($node,$this->_xml);
$this->delivery_end_date = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_DeliveryDate_DeliveryEndDate($node,$this->_xml);
	}
	
	
	
    
}
