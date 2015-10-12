<?php
/**
 * Transaktions-Resource-Model-Collection
 *
 * @category    Egovs
 * @package     Egovs_Paymentbase
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Transaction_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	/**
	 * Resource initialization
	 * 
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('paymentbase/transaction');
	}
}