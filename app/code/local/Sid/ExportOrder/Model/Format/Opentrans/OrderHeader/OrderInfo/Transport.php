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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Transport extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "bmecat:TRANSPORT";
	
	
	/* @var $incoterm Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Transport_Incoterm */
public $incoterm = null;
/* @var $location Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Transport_Location */
public $location = null;
/* @var $transport_remark Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Transport_TransportRemark */
public $transport_remark = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->incoterm = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Transport_Incoterm($node,$this->_xml);
$this->location = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Transport_Location($node,$this->_xml);
$this->transport_remark = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Transport_TransportRemark($node,$this->_xml);
	}
	
	
	
    
}
