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
 * @category    Mage
 * @package     Mage_Downloadable
 * @copyright   Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Block to display downloadable links bought by customer
 *
 * @category    Mage
 * @package     Mage_Downloadable
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Stala_Abo_Block_Downloads_List extends Mage_Core_Block_Template
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $purchased = Mage::getModel('stalaabo/delivered')->getCollection();
        $eav = Mage::getResourceModel('eav/entity_attribute');
        
        $max = new Zend_Db_Expr("SELECT max(abo_deliver_id)	FROM ".$purchased->getTable('stalaabo/delivered')." AS t1
								INNER JOIN ".$purchased->getTable('stalaabo/contract')." AS t2 ON t1.abo_contract_id=t2.abo_contract_id
								where customer_id=".$customer->getId()."
								group by base_product_id");
        
        
        
        $purchased->getSelect()
        	->join(array('contract'=>$purchased->getTable('stalaabo/contract')),'main_table.abo_contract_id=contract.abo_contract_id')
        	->join(array('product'=>$purchased->getTable('catalog/product')),"main_table.product_id=product.entity_id AND type_id='".Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE."'",'sku')
        	->join(array('productname'=>'catalog_product_entity_varchar'),'productname.entity_id=product.entity_id AND productname.attribute_id='.$eav->getIdByCode('catalog_product','name'),array('product_name'=>'value'))	
        	->where('shipping_qty = contract_qty')
        	->where('abo_deliver_id in ('.$max.')')
        	;

        	
        
//die($purchased->getSelect()->__toString()); 
        $this->setItems($purchased);
    }

    /**
     * Enter description here...
     *
     * @return Mage_Downloadable_Block_Customer_Products_List
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'downloadable.customer.products.pager')
            ->setCollection($this->getItems());
        $this->setChild('pager', $pager);
        $this->getItems()->load();
        /*
        foreach ($this->getItems() as $item) {
            $item->setPurchased($this->getPurchased()->getItemById($item->getPurchasedId()));
        }
        */
        return $this;
    }

    /**
     * Return order view url
     *
     * @param integer $orderId
     * @return string
     */
    public function getOrderViewUrl($orderId)
    {
        return $this->getUrl('sales/order/view', array('order_id' => $orderId));
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getBackUrl()
    {
        if ($this->getRefererUrl()) {
            return $this->getRefererUrl();
        }
        return $this->getUrl('customer/account/');
    }


    /**
     * Return url to download link
     *
     * @param Mage_Downloadable_Model_Link_Purchased_Item $item
     * @return string
     */
    public function getDownloadUrl($item)
    {
        return $this->getUrl('*/index/link', array('id' => $item->getLinkHash(), '_secure' => true));
    }

    /**
     * Return true if target of link new window
     *
     * @return bool
     */
    public function getIsOpenInNewWindow()
    {
        return Mage::getStoreConfigFlag(Mage_Downloadable_Model_Link::XML_PATH_TARGET_NEW_WINDOW);
    }
    
    public function getLinkTitle($item)
    {
    	return "xxxxx";
    }

}
