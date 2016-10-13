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
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "TAX_DETAILS_FIX";
	
	
	/* @var $tax_amount Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_TaxAmount */
public $tax_amount = null;
/* @var $tax_base Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_TaxBase */
public $tax_base = null;
/* @var $calculation_sequence Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_CalculationSequence */
public $calculation_sequence = null;
/* @var $tax_category Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_TaxCategory */
public $tax_category = null;
/* @var $tax_type Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_TaxType */
public $tax_type = null;
/* @var $tax Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_Tax */
public $tax = null;
/* @var $exemption_reason Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_ExemptionReason */
public $exemption_reason = null;
/* @var $jurisdiction Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_Jurisdiction */
public $jurisdiction = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->tax_amount = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_TaxAmount($node,$this->_xml);
$this->tax_base = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_TaxBase($node,$this->_xml);
$this->calculation_sequence = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_CalculationSequence($node,$this->_xml);
$this->tax_category = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_TaxCategory($node,$this->_xml);
$this->tax_type = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_TaxType($node,$this->_xml);
$this->tax = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_Tax($node,$this->_xml);
$this->exemption_reason = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_ExemptionReason($node,$this->_xml);
$this->jurisdiction = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix_Jurisdiction($node,$this->_xml);
	}
	
	
	
    
}
