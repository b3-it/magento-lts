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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "AGREEMENT";
	
	
	/* @var $agreement_descr Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementDescr */
public $agreement_descr = null;
/* @var $mime_info Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo */
public $mime_info = null;
/* @var $agreement_id Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementId */
public $agreement_id = null;
/* @var $agreement_line_id Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementLineId */
public $agreement_line_id = null;
/* @var $agreement_start_date Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementStartDate */
public $agreement_start_date = null;
/* @var $agreement_end_date Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementEndDate */
public $agreement_end_date = null;
/* @var $supplier_idref Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_SupplierIdref */
public $supplier_idref = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->agreement_descr = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementDescr($node,$this->_xml);
$this->mime_info = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo($node,$this->_xml);
$this->agreement_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementId($node,$this->_xml);
$this->agreement_line_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementLineId($node,$this->_xml);
$this->agreement_start_date = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementStartDate($node,$this->_xml);
$this->agreement_end_date = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_AgreementEndDate($node,$this->_xml);
$this->supplier_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_SupplierIdref($node,$this->_xml);
	}
	
	
	
    
}
