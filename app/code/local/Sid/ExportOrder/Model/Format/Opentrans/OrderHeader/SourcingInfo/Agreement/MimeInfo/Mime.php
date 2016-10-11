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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "MIME";
	
	
	/* @var $file_hash_value Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_FileHashValue */
public $file_hash_value = null;
/* @var $mime_purpose Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimePurpose */
public $mime_purpose = null;
/* @var $mime_type Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimeType */
public $mime_type = null;
/* @var $mime_source Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimeSource */
public $mime_source = null;
/* @var $mime_descr Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimeDescr */
public $mime_descr = null;
/* @var $mime_order Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimeOrder */
public $mime_order = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->file_hash_value = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_FileHashValue($node,$this->_xml);
$this->mime_purpose = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimePurpose($node,$this->_xml);
$this->mime_type = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimeType($node,$this->_xml);
$this->mime_source = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimeSource($node,$this->_xml);
$this->mime_descr = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimeDescr($node,$this->_xml);
$this->mime_order = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement_MimeInfo_Mime_MimeOrder($node,$this->_xml);
	}
	
	
	
    
}
