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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "PARTIES";
	
	
	/* @var $shippingParty Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party */
	public $shippingParty = null;
	
	/* @var $billingParty Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party */
	public $billingParty = null;
	
	/* @var $shippingParty Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party */
	public $supplierParty = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->shippingParty = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party($node,$this->_xml);
		$this->billingParty = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party($node,$this->_xml);
		$this->supplierParty = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties_Party($node,$this->_xml);
	}
	
	
	
    
}
