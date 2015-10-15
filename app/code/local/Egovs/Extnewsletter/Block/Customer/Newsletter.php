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
 * @package    Mage_Customer
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Customer front  newsletter manage block
 *
 * @category   Mage
 * @package    Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Extnewsletter_Block_Customer_Newsletter extends Mage_Customer_Block_Newsletter//Mage_Customer_Block_Account_Dashboard // Mage_Core_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('egovs/extnewsletter/customer/newsletter.phtml');
    }

    //alle Produkte die der Kunde gekauft hat
    protected function getSalesProducts()
    {
    	    $orders = Mage::getResourceModel('sales/order_collection')
            ->addAttributeToSelect('*')
           // ->joinAttribute('shipping_firstname', 'order_address/firstname', 'shipping_address_id', null, 'left')
           // ->joinAttribute('shipping_lastname', 'order_address/lastname', 'shipping_address_id', null, 'left')
             ->addAttributeToFilter('customer_id', $this->getCustomer()->getId())
           ;
           if(count($orders->getItems()) == 0) return array();
            
           $ordersItems = Mage::getResourceModel('sales/order_item_collection');
           $ordersItems->getSelect()
              	->join(array('cp'=>'catalog_product_entity_int'),'main_table.product_id=cp.entity_id',array())
    			->join(array('e'=>'eav_attribute'),'e.attribute_id = cp.attribute_id',array())
    			->join(array('t'=>'eav_entity_type'),'t.entity_type_id = e.entity_type_id',array())
    	    	->where("((t.entity_type_code = 'catalog_product') AND (e.attribute_code = 'extnewsletter') AND (cp.value=1))");

        
    	   $filter = array();
           foreach($orders as $order)
           {
           		$filter[] = $order->getId();
           }
		   $ordersItems->getSelect()->where('order_id in ('.implode(',',$filter).')');
           //die($ordersItems->getSelect()->__toString());
			
           $res = array();

           foreach($ordersItems->getItems() as $item)
           {
           		$res[$item->getData('product_id')] = $item->getName();
           }
           
          return $res;
    }
    
    private function getSubscripedProducts()
    {
    	
    	if($this->getSubscriptionObject()->getId() == null) return array();
    	 $collection = Mage::getModel('extnewsletter/extnewsletter')
		->getCollection()
		->addProductInfoToQuerry()
		->addSubscriberId($this->getSubscriptionObject()->getId())//Data('subscriber_id'))
		->load();
		//die($collection->getSelect()->__toString());
		$res = array();
		foreach($collection->getItems() as $product)
		{
			if($product->getData('is_active')=='1')
			{
				$res[$product->getData('product_id')] = $product->getData('name');
			}
		}
		
		return $res;
    }
    
    public function getProducts()
    {
    	//alle gel�schten Produkte aus der Liste l�schen
    	Mage::getResourceModel('extnewsletter/extnewsletter')->deleteNotExistingProductKeys();
    	$res = array();
 
		$allgemein = false;
		$aboProducts = $this->getSubscripedProducts();
		$saleProducts = array_diff($this->getSalesProducts(),$aboProducts);
		
		//falls allgemeiner newsletter(0) nicht in den abonierten enthalten 
		//ist, dann zu den anderen hinzu
		$hasGeneral = array_keys($aboProducts);
		if(!in_array(0,$hasGeneral))
		{
			$saleProducts[0] = $this->__('General Subscription');
		}
		//ansonsen den Namen festlegen
		else
		{
			$aboProducts[0] = $this->__('General Subscription');
		}
		if($this->getIsSubscribed())
    	{
			foreach($aboProducts as $key=>$value)
			{
				$res[] = array('label'=>$value,'value'=>$key,'checked'=>true);		
			}
	    	foreach($saleProducts as $key=>$value)
			{
				$res[] = array('label'=>$value,'value'=>$key,'checked'=>false);		
			}
    	}
    	else 
    	{
    		$res[] = array('label'=> $this->__('General Subscription'),'value'=>0,'checked'=>false);
    	}
		return $res;
    }
    /**
     * Alle nuewsletterthemen finden und ggf selektiren , einmal Themen aussschliessen
     * @return multitype:|multitype:multitype:boolean NULL
     */
    
    public function getIssues()
    {
    	$subscriber = $this->getSubscriptionObject();
    	if($subscriber == null)
    	{
    		$msg = "Subcriber not found(CustomerId: " .$this->getCustomer()->getId().", StoreId: " . Mage::app()->getStore()->getId().")";
    		Mage::log("extNewsletter.getIssues::$msg", Zend_Log::NOTICE, Egovs_Extstock_Helper_Data::LOG_FILE);
    		return array();
    	}
    	$subid = $subscriber->getId();

    	$collection = Mage::getModel('extnewsletter/issue')->getCollection();
    	$collection->addStoreOrAllFilter($subscriber->getStoreId());
   
//echo "<pre>"; var_dump($this->getSubscriptionObject()); die();
    	
    	if($subscriber->getId())
    	{
	    	$collection->getSelect()
	    	->joinleft(array('t1'=>'extnewsletter_issues_subscriber'),"main_table.extnewsletter_issue_id = t1.issue_id and subscriber_id = $subid and is_active=1",'is_active')
	    	->where('remove_subscriber_after_send = 0')
	    	;
    	}
    	
    	
    	$res = array();
    	if($this->getIsSubscribed())
    	{
	    	foreach ($collection->getItems() as $item)
	    	{
	    		$res[] = array('label'=>$item->getTitle(),'value'=>$item->getId(),'checked'=>$item->getIsActive()!= null);	
	    	}
    	}
    	return $res;
    }
    
    
    public function getIsSubscribed()
    {
        return $this->getSubscriptionObject()->isSubscribed();
    }

    public function getAction()
    {
        return $this->getUrl('extnewsletter/subscriber/save');
    }
    
  

}
