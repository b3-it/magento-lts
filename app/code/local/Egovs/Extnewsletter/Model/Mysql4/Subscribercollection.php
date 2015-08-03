<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Newsletter
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Newsletter Subscribers Collection
 *
 * @category   Mage
 * @package    Mage_Newsletter
 * @author      Magento Core Team <core@magentocommerce.com>
 * @todo       Refactoring this collection to Mage_Core_Model_Mysql4_Collection_Abstract.
 */

class Egovs_Extnewsletter_Model_Mysql4_Subscribercollection extends Mage_Core_Model_Mysql4_Abstract
{
	private $_isProductNewsLetter = false;
	private $_wantedIds = null;
 
	public function _construct()
    {    
        $this->_init('extnewsletter/extnewsletter_subscriber', 'extnewsletter_id');
    }
	
	

  
    /*
     * zum Merken der Einstellungen f�r einen erneuten Formularaufruf
     */
    public function saveProductQueue($queueId)
    {
    		
		$products = Mage::app()->getRequest()->getPost('news_for_products');
		$this->_deletePrevious($queueId);
		if($products == null) 
		{
			$this->_isProductNewsLetter = false;
			return $this;
		}


		
			
		foreach( $products as $product)
		{
			$queueproduct= Mage::getModel('extnewsletter/queueproduct');
			$queueproduct->setProductId($product);
			$queueproduct->setQueueId($queueId);
			$queueproduct->save();
		}
		
		$this->_isProductNewsLetter = (count($products) > 0);
		return $this;
    }
 
	private function _deletePrevious($queueid)
	{
		$resource = Mage::getSingleton('core/resource');
		$conn= $resource->getConnection('core_write');
		$extTable = $resource->getTableName('extnewsletter_queue_product');
		
		$sql = "DELETE FROM " .$extTable ." WHERE queue_id=".$queueid;
		$result = $conn->query($sql);
		
	}
}