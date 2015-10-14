<?php
class Stala_CustomerReports_Block_Adminhtml_Report_Sales_Quantity_Grid extends Egovs_Extreport_Block_Adminhtml_Sales_Quantityordered_Grid
{
	
	public function __construct()
    {
        parent::__construct();
        
        $this->setTemplate('stala/customerreports/grid.phtml');
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