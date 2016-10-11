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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "CONTACT_DETAILS";
	
	
	/* @var $contact_role Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_ContactRole */
public $contact_role = null;
/* @var $contact_id Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_ContactId */
public $contact_id = null;
/* @var $contact_name Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_ContactName */
public $contact_name = null;
/* @var $first_name Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_FirstName */
public $first_name = null;
/* @var $title Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Title */
public $title = null;
/* @var $academic_title Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_AcademicTitle */
public $academic_title = null;
/* @var $contact_descr Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_ContactDescr */
public $contact_descr = null;
/* @var $phone Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Phone */
public $phone = null;
/* @var $fax Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Fax */
public $fax = null;
/* @var $url Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Url */
public $url = null;
/* @var $emails Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Emails */
public $emails = null;
/* @var $authentification Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Authentification */
public $authentification = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->contact_role = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_ContactRole($node,$this->_xml);
$this->contact_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_ContactId($node,$this->_xml);
$this->contact_name = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_ContactName($node,$this->_xml);
$this->first_name = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_FirstName($node,$this->_xml);
$this->title = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Title($node,$this->_xml);
$this->academic_title = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_AcademicTitle($node,$this->_xml);
$this->contact_descr = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_ContactDescr($node,$this->_xml);
$this->phone = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Phone($node,$this->_xml);
$this->fax = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Fax($node,$this->_xml);
$this->url = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Url($node,$this->_xml);
$this->emails = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Emails($node,$this->_xml);
$this->authentification = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails_Authentification($node,$this->_xml);
	}
	
	
	
    
}
