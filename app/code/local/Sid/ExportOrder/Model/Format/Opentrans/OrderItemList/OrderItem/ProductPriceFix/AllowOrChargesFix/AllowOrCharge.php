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
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "ALLOW_OR_CHARGE";
	
	
	/* @var $allow_or_charge_sequence Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeSequence */
public $allow_or_charge_sequence = null;
/* @var $allow_or_charge_name Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeName */
public $allow_or_charge_name = null;
/* @var $allow_or_charge_type Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeType */
public $allow_or_charge_type = null;
/* @var $allow_or_charge_descr Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeDescr */
public $allow_or_charge_descr = null;
/* @var $allow_or_charge_value Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeValue */
public $allow_or_charge_value = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->allow_or_charge_sequence = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeSequence($node,$this->_xml);
$this->allow_or_charge_name = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeName($node,$this->_xml);
$this->allow_or_charge_type = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeType($node,$this->_xml);
$this->allow_or_charge_descr = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeDescr($node,$this->_xml);
$this->allow_or_charge_value = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge_AllowOrChargeValue($node,$this->_xml);
	}
	
	
	
    
}
