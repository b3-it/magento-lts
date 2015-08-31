<?php
class Stala_CustomerReports_Block_Adminhtml_Report_Customer_Accounts_Grid extends Mage_Adminhtml_Block_Report_Customer_Accounts_Grid {
	
	public function __construct()
    {
        parent::__construct();
        
//        $this->setSaveParametersInSession(true);
//        $this->setUseAjax(true);
        
        $this->setTemplate('stala/customerreports/grid.phtml');
//        $this->setSubReportSize(0);	//nicht beschränkt!
    }
    
	protected function _prepareLayout() {
    	
		parent::_prepareLayout();
		
    	Mage::helper('stalareports')->prepareLayout($this);

    	return $this;
	}
	
	public function getCustomerGroupSwitcherHtml() {
		return $this->getChildHtml('group_switcher');
	}
}