<?php
/**
 * 
 * ändert alle Lins zu einem Produkt falls es ein Update gibt
 * 
 * 
 *
 * @category   	 Egovs
 * @package    	 Egovs_Downloadupdate
 * @name       	 Egovs_Downloadupdate_Model_File
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Downloadupdate_Model_File extends Mage_Core_Model_Abstract
{
	private $_conn = null;
	private $_table = "";
	
	public function _construct()
	{
		$this->_conn = Mage::getSingleton('core/resource')->getConnection('core_write');
		$this->_table= Mage::getSingleton('core/resource')->getTableName('downloadable/link_purchased_item');
	}
	
	//falls gew�nscht, werden alle die den Link gekauft haben mit dem
	//update versehen
	public function updateFile($product)
	{
		$productid= $product->getId();
		
		$data = $product->getData('downloadable_data');
		if($data == null) Mage::throwException("The product downloadable data wasn't set!");
		$mod = Mage::getSingleton('downloadable/link');
		
		$links = $data['link'];
		if(isset($links))
		{
			foreach($links as $link)
			{
				//$files = Zend_Json::decode($link['file']);
				$linkid = $link['link_id'];	
				
				//foreach($files as $file)
				{
					//if($file['status'] == 'new')
					{
						$ln = $mod->load($linkid); 
						$this->_updateOrder($productid,$linkid,$ln->getData(),$link['title']);
					}
				}
			}
		}
	}
	
	protected function _updateOrder($productid,$linkid,$link_data,$title)
	{
		try
		{
			$sql = "UPDATE ".$this->_table." SET "; //$this->getTable('egovssearch/soundex');
			$sql .= $this->_conn->quoteInto (" link_title=?, ",$title);
			if(isset($link_data['link_file']))$sql .= $this->_conn->quoteInto (" link_file=? ,",$link_data['link_file']);		
			if(isset($link_data['link_type']))$sql .= $this->_conn->quoteInto (" link_type=? ,",$link_data['link_type']);
			if(isset($link_data['link_url']))$sql .= $this->_conn->quoteInto (" link_url=? ,",$link_data['link_url']);
			if(isset($link_data['is_shareable']))$sql .= $this->_conn->quoteInto (" is_shareable=? ",$link_data['is_shareable']);
			$sql .= " WHERE product_id=".$productid;
			$sql .= " AND link_id=".$linkid;
			$result = $this->_conn->query($sql);
		}
		catch(Exception $e)
		{
			Mage::log("downloadupdate::".$e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
	}
}