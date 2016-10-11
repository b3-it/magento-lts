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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_PaymentTerms_TimeForPayment extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "TIME_FOR_PAYMENT";
	
	
	/* @var $days Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_PaymentTerms_TimeForPayment_Days */
public $days = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->days = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment_PaymentTerms_TimeForPayment_Days($node,$this->_xml);
	}
	
	
	
    
}
