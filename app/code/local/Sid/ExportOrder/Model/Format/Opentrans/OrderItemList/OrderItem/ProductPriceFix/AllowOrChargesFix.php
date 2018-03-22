<?php
/**
 * Sid_ExportOrder_Model_Format_Opentrans
 *
 * Erzeugen eines XML Streams f�r OpenTrans 2.1
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Model_Format_Opentrans
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "ALLOW_OR_CHARGES_FIX";
	
	
	/* @var $allow_or_charge Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge */
public $allow_or_charge = null;
/* @var $allow_or_charges_total_amount Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrChargesTotalAmount */
public $allow_or_charges_total_amount = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->allow_or_charge = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrCharge($node,$this->_xml);
$this->allow_or_charges_total_amount = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductPriceFix_AllowOrChargesFix_AllowOrChargesTotalAmount($node,$this->_xml);
	}
	
	
	
    
}