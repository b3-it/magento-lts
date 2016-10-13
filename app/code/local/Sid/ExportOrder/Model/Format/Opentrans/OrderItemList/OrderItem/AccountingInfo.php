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
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_AccountingInfo extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "bmecat:ACCOUNTING_INFO";
	
	
	/* @var $cost_category_id Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_AccountingInfo_CostCategoryId */
public $cost_category_id = null;
/* @var $cost_type Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_AccountingInfo_CostType */
public $cost_type = null;
/* @var $cost_account Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_AccountingInfo_CostAccount */
public $cost_account = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->cost_category_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_AccountingInfo_CostCategoryId($node,$this->_xml);
$this->cost_type = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_AccountingInfo_CostType($node,$this->_xml);
$this->cost_account = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_AccountingInfo_CostAccount($node,$this->_xml);
	}
	
	
	
    
}
