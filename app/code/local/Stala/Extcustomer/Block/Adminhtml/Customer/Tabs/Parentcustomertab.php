<?php
class Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Parentcustomertab extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface 
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
        return Mage::helper('extcustomer')->__('Parent Customer');
    }
 
    /**
     * Retrieve the title used by this tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Click here to view your Parent Customer tab content');
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
    		if((Mage::registry('current_customer')->getIsParentCustomer() == 1))
  			{
  				return false;
  			}
  			return true;
    	}
    	
    	return false;
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
       return $this->getUrl('adminhtml/extcustomer_customer_parentcustomer', array('_current' => true,'customer_id'=>Mage::registry('current_customer')->getId()));
   }
 
}