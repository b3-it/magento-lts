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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "ORDER_HEADER";
	
	
	/* @var $control_info Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_ControlInfo */
public $control_info = null;
/* @var $sourcing_info Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo */
public $sourcing_info = null;
/* @var $order_info Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo */
public $order_info = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->control_info = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_ControlInfo($node,$this->_xml);
$this->sourcing_info = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo($node,$this->_xml);
$this->order_info = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo($node,$this->_xml);
	}
	
	
	
    
}
