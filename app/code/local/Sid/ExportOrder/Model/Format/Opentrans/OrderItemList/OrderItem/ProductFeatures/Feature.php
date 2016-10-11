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
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "FEATURE";
	
	
	/* @var $fname Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Fname */
public $fname = null;
/* @var $fvalue Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Fvalue */
public $fvalue = null;
/* @var $funit Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Funit */
public $funit = null;
/* @var $forder Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Forder */
public $forder = null;
/* @var $fdescr Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Fdescr */
public $fdescr = null;
/* @var $fvalue_details Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_FvalueDetails */
public $fvalue_details = null;
/* @var $fvalue_type Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_FvalueType */
public $fvalue_type = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->fname = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Fname($node,$this->_xml);
$this->fvalue = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Fvalue($node,$this->_xml);
$this->funit = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Funit($node,$this->_xml);
$this->forder = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Forder($node,$this->_xml);
$this->fdescr = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_Fdescr($node,$this->_xml);
$this->fvalue_details = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_FvalueDetails($node,$this->_xml);
$this->fvalue_type = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature_FvalueType($node,$this->_xml);
	}
	
	
	
    
}
