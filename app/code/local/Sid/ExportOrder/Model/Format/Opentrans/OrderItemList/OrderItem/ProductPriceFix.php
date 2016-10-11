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
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "PRODUCT_PRICE_FIX";
	
	
	/* @var $allow_or_charges_fix Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix */
public $allow_or_charges_fix = null;
/* @var $tax_details_fix Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix */
public $tax_details_fix = null;
/* @var $price_base_fix Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_PriceBaseFix */
public $price_base_fix = null;
/* @var $price_amount Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_PriceAmount */
public $price_amount = null;
/* @var $price_flag Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_PriceFlag */
public $price_flag = null;
/* @var $price_quantity Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_PriceQuantity */
public $price_quantity = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->allow_or_charges_fix = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix($node,$this->_xml);
$this->tax_details_fix = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_TaxDetailsFix($node,$this->_xml);
$this->price_base_fix = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_PriceBaseFix($node,$this->_xml);
$this->price_amount = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_PriceAmount($node,$this->_xml);
$this->price_flag = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_PriceFlag($node,$this->_xml);
$this->price_quantity = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_PriceQuantity($node,$this->_xml);
	}
	
	
	
    
}
