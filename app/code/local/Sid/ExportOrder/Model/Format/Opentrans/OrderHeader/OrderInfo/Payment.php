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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "PAYMENT";
	
	
	/* @var $card Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card */
public $card = null;
/* @var $central_regulation Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_CentralRegulation */
public $central_regulation = null;
/* @var $payment_terms Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_PaymentTerms */
public $payment_terms = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->card = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card($node,$this->_xml);
$this->central_regulation = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_CentralRegulation($node,$this->_xml);
$this->payment_terms = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_PaymentTerms($node,$this->_xml);
	}
	
	
	
    
}
