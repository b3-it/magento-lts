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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "ADDRESS";
	
	
	/* @var $contact_details Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails */
public $contact_details = null;
/* @var $tax_number Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_TaxNumber */
public $tax_number = null;
/* @var $name Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Name */
public $name = null;
/* @var $name2 Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Name2 */
public $name2 = null;
/* @var $name3 Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Name3 */
public $name3 = null;
/* @var $department Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Department */
public $department = null;
/* @var $street Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Street */
public $street = null;
/* @var $zip Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Zip */
public $zip = null;
/* @var $boxno Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Boxno */
public $boxno = null;
/* @var $zipbox Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Zipbox */
public $zipbox = null;
/* @var $city Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_City */
public $city = null;
/* @var $state Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_State */
public $state = null;
/* @var $country Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Country */
public $country = null;
/* @var $country_coded Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_CountryCoded */
public $country_coded = null;
/* @var $vat_id Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_VatId */
public $vat_id = null;
/* @var $phone Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Phone */
public $phone = null;
/* @var $fax Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Fax */
public $fax = null;
/* @var $email Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Email */
public $email = null;
/* @var $public_key Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_PublicKey */
public $public_key = null;
/* @var $url Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Url */
public $url = null;
/* @var $address_remarks Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_AddressRemarks */
public $address_remarks = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->contact_details = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_ContactDetails($node,$this->_xml);
$this->tax_number = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_TaxNumber($node,$this->_xml);
$this->name = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Name($node,$this->_xml);
$this->name2 = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Name2($node,$this->_xml);
$this->name3 = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Name3($node,$this->_xml);
$this->department = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Department($node,$this->_xml);
$this->street = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Street($node,$this->_xml);
$this->zip = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Zip($node,$this->_xml);
$this->boxno = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Boxno($node,$this->_xml);
$this->zipbox = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Zipbox($node,$this->_xml);
$this->city = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_City($node,$this->_xml);
$this->state = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_State($node,$this->_xml);
$this->country = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Country($node,$this->_xml);
$this->country_coded = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_CountryCoded($node,$this->_xml);
$this->vat_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_VatId($node,$this->_xml);
$this->phone = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Phone($node,$this->_xml);
$this->fax = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Fax($node,$this->_xml);
$this->email = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Email($node,$this->_xml);
$this->public_key = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_PublicKey($node,$this->_xml);
$this->url = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_Url($node,$this->_xml);
$this->address_remarks = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party_Address_AddressRemarks($node,$this->_xml);
	}
	
	
	
    
}
