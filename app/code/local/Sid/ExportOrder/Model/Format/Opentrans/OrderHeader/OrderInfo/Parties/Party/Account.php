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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "ACCOUNT";
	
	
	/* @var $holder Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_Holder */
public $holder = null;
/* @var $bank_account Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_BankAccount */
public $bank_account = null;
/* @var $bank_code Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_BankCode */
public $bank_code = null;
/* @var $bank_name Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_BankName */
public $bank_name = null;
/* @var $bank_country Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_BankCountry */
public $bank_country = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->holder = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_Holder($node,$this->_xml);
$this->bank_account = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_BankAccount($node,$this->_xml);
$this->bank_code = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_BankCode($node,$this->_xml);
$this->bank_name = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_BankName($node,$this->_xml);
$this->bank_country = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Account_BankCountry($node,$this->_xml);
	}
	
	
	
    
}
