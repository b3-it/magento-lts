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
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "ORDER_ITEM_LIST";
	
	
	/* @var $order_items[] Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem */
	public $order_items = array();


	

	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
	}
	
	/**
	 * 
	 * @return Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem
	 */
	public function add()
	{
		$order_item = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem($this->_MyNode,$this->_xml);
		$this->order_items[] = $order_item;
		
		return $order_item;
		
	}
	
    
}
