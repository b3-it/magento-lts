<?php
/**
 * 
 *  Basisklasse für die Bestellübertragung
 *  @category Egovs
 *  @package  Sid_ExportOrder_Model_Transfer
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Sid_ExportOrder_Model_Transfer extends Mage_Core_Model_Abstract
{
	/**
	 * @var Sid_ExportOrder_Model_Format
	 */
	protected $_formatModel = null;
	
	
	public function setFormatModel($formatModel)
	{
		$this->_formatModel = $formatModel;
	}
	
	
	/**
	 * gibt die Datei Extention mit . z..b ".xml"
	 * @return string
	 */
	public function getFileExtention()
	{
		if(isset($this->_formatModel)){
			return $this->_formatModel->getFileExtention();
		}
		
		return '.txt';
	}
	
	
	/**
	 * 
	 * @param Sid_ExportOrder_Model_Type_Transfer $type
	 * @return Sid_ExportOrder_Model_Transfer
	 */
	public static function getInstance($type)
	{
		if($type == Sid_ExportOrder_Model_Type_Transfer::TRANSFER_TYPE_POST)
		{
			return Mage::getModel('exportorder/transfer_post');
		}
		
		if($type == Sid_ExportOrder_Model_Type_Transfer::TRANSFER_TYPE_EMAIL_ATTACHMENT)
		{
			return Mage::getModel('exportorder/transfer_attachment');
		}
		
		if($type == Sid_ExportOrder_Model_Type_Transfer::TRANSFER_TYPE_LINK)
		{
			return Mage::getModel('exportorder/transfer_link');
		}

		return Mage::getModel('exportorder/transfer_email');
	}

	/**
	 * 
	 * @param string $content
	 * @param Mage_Sales_Model_Order $order
	 * @param array $data assoziatives Array für die Email Variablen
     *
	 * @return bool | string Im Fehlerfall false ansonsten eine Textmeldung
	 */
	public abstract function send($content,$order = null, $data = array());
	
	public function canSend()
	{
		return true;
	}
}
