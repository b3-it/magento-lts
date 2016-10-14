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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "CARD";
	
	
	/* @var $card_num Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardNum */
public $card_num = null;
/* @var $card_auth_code Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardAuthCode */
public $card_auth_code = null;
/* @var $card_ref_num Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardRefNum */
public $card_ref_num = null;
/* @var $card_expiration_date Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardExpirationDate */
public $card_expiration_date = null;
/* @var $card_holder_name Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardHolderName */
public $card_holder_name = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->card_num = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardNum($node,$this->_xml);
$this->card_auth_code = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardAuthCode($node,$this->_xml);
$this->card_ref_num = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardRefNum($node,$this->_xml);
$this->card_expiration_date = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardExpirationDate($node,$this->_xml);
$this->card_holder_name = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_Card_CardHolderName($node,$this->_xml);
	}
	
	
	
    
}
