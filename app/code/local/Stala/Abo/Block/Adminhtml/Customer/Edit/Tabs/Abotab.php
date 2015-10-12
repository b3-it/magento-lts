<?php
class Stala_Abo_Block_Adminhtml_Customer_Edit_Tabs_Abotab extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface 
{
 
    /**
     * Set the template for the block
     *
     */
    public function _construct()
    {
        parent::_construct();
 
        //$this->setTemplate('customtabs/catalog/product/tab.phtml');
    }
 
    /**
     * Retrieve the label used for the tab relating to this block
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('stalaabo')->__('Subscribe');
    }
 
    /**
     * Retrieve the title used by this tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Click here to view your subscribe tab content');
    }
 
    /**
     * Determines whether to display the tab
     * Add logic here to decide whether you want the tab to display
     *
     * @return bool
     */
    public function canShowTab()
    {
    	//neuer Kunde?
    	if(Mage::registry('current_customer')->getId())
    	{
	    	$p = $this->getLayout()->getBlock('customer_edit');	  	
	    	
	    	
	    	//info über benutzte Adresse anzeigen
		  	$model = Mage::getModel('stalaabo/customer_observer');
		  	$model->testAddresses4Usage(Mage::registry('current_customer')->getId(),$p);
	    	
	    	//workaround: delete Button entfernen falls Kunde abos hat 
	       $collection = Mage::getSingleton('stalaabo/contract')->getCollection();
		   $collection->getSelect()->where('customer_id='.Mage::registry('current_customer')->getId());
				
		  	if(count($collection->getItems())>0)
		  	{
		    	
		    	$p->removeButton('delete');
		    	$text = Mage::helper('stalaabo')->__('Customer can not deleted, because of existing or deleted Abo Contracts.');
		    	$this->getLayout()->getMessagesBlock()->addNotice($text);
		  	}
		  	
	  	
    	}
    	else 
    	{
    		return false;
    	}
	  	
	  	
        $acl = Mage::getSingleton('acl/productacl');
    	return ($acl->testPermission('admin/stalaabo'));
    }
 
    /**
     * Stops the tab being hidden
     *
     * @return bool
     */
    public function isHidden()
    {
    	return false;
    }
 
    /**
     * AJAX TAB's
     * If you want to use an AJAX tab, uncomment the following functions
     * Please note that you will need to setup a controller to recieve
     * the tab content request
     *
     */
    /**
     * Retrieve the class name of the tab
     * Return 'ajax' here if you want the tab to be loaded via Ajax
     *
     * return string
     */
   public function getTabClass()
   {
       return 'ajax';
   }
 
    /**
     * Determine whether to generate content on load or via AJAX
     * If true, the tab's content won't be loaded until the tab is clicked
     * You will need to setup a controller to handle the tab request
     *
     * @return bool
     */
   public function getSkipGenerateContent()
   {
       return false;
   }
 
    /**
     * Retrieve the URL used to load the tab content
     * Return the URL here used to load the content by Ajax
     * see self::getSkipGenerateContent & self::getTabClass
     *
     * @return string
     */
   public function getTabUrl()
   {
       return $this->getUrl('adminhtml/stalaabo_contract_customer/customerAjax', array('_current' => true));
   }
 
}