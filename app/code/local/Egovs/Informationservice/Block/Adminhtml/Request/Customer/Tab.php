<?php

class Egovs_Informationservice_Block_Adminhtml_Request_Customer_Tab
    extends Mage_Adminhtml_Block_Widget_Grid_Container
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

	
	
	public function __construct()
	  {
	    $this->_controller = 'adminhtml_request_customer_tab';
	    $this->_blockGroup = 'informationservice';
	    $this->_headerText = Mage::helper('informationservice')->__('Information Service');
	    $this->_addButtonLabel = Mage::helper('informationservice')->__('New Request');
	    
	 	//$this->setUseAjax(true);
	    
	    parent::__construct();
	    
	  }
  
  
  public function _prepareLayout()
  {
  	//falls von der Kundenverwaltung
  	$res =  parent::_prepareLayout();
  	$this->customer_id = $this->getRequest()->getParam('customer_id');
        $customer = Mage::registry('current_customer');
        if($customer)
        {
        	$this->customer_id = $customer->getId();
        }
    if($this->customer_id != null)
    {
      	$customer_id = intval($this->customer_id);
      	$this->_updateButton('add', 'onclick', "setLocation('". $this->getUrl('adminhtml/informationservice_request/edit', array('customer' => $customer_id))."');");
    }
    else
    {
    	$this->_removeButton('add');
    }
    
    $this->testAddresses4Usage(Mage::registry('current_customer')->getId(),$res); 
    return $res;
  }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Information Service');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Information Service');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
    	$customer = Mage::registry('current_customer');
        return (bool)$customer->getId();
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }


    /**
     * Defines after which tab, this tab should be rendered
     *
     * @return string
     */
    public function getAfter()
    {
        return 'orders';
    }

	//im BE warnen wenn eine Adresse verwendet wird
	private function testAddresses4Usage($customer_id, $block)
	{
		
		$collection = Mage::getModel('customer/address')->getCollection();
		$collection->addAttributeToSelect('firstname');
		$collection->addAttributeToSelect('lastname');
		$collection->addAttributeToSelect('street');
		$collection->addAttributeToSelect('city');
		$collection->addAttributeToSelect('postcode');
		$collection->getSelect()
			->where('parent_id= ?',intval($customer_id))
			->where('(entity_id  in (select address_id from '.$collection->getTable('informationservice_request').'))');
		//die($collection->getSelect()->__toString());
		
		foreach ($collection->getItems() as $item)
		{
			$street = $item->getStreet();
			if(is_array($street)) $street = implode(" ", $street);
			$text = Mage::helper('informationservice')->__('Following Address is used by Informationservice:');
			$text .= " ". $item->getFirstname()." ".$item->getLastname()." ".$street." ". $item->getCity()." ".$item->getPostcode();
			$block->getLayout()->getMessagesBlock()->addNotice($text);
		}
	}
}
