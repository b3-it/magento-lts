<?php

class Sid_Cms_Block_Adminhtml_Page_Edit_Tabs_Information extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Initialize block
     *
     */
	public function __construct()
    {
        return parent::__construct();
    }

    /**
     * Retrieve Tab class (for loading)
     *
     * @return string
     */
    public function getTabClass()
    {
        return 'ajax';
    }

    /**
     * Retrieve Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('sidcms')->__('Send Update Information');
    }

    /**
     * Retrieve Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('sidcms')->__('Send Update Information');
    }

    /**
     * Can show tab flag
     *
     * @return bool
     */
    public function canShowTab()
    {
 
        return true;
    }

    /**
     * Check is a hidden tab
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
    
    public function getTabUrl() {
    	return $this->getUrl('adminhtml/cms_navi/tabInformation', array('_current' => true));
    }	
}
