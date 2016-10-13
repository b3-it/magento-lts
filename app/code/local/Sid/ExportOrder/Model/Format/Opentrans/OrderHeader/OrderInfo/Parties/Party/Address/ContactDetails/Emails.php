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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Emails extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "bmecat:EMAILS";
	
	
	/* @var $email Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Emails_Email */
public $email = null;
/* @var $public_key Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Emails_PublicKey */
public $public_key = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->email = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Emails_Email($node,$this->_xml);
$this->public_key = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Emails_PublicKey($node,$this->_xml);
	}
	
	
	
    
}
