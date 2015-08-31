<?php
class Stala_CustomerReports_Block_Adminhtml_Report_Sales_Revenue_Grid extends Egovs_Extreport_Block_Adminhtml_Sales_Revenue_Grid {
	
	public function __construct($attributes=array()) {
        parent::__construct($attributes);
        
        $this->unsRowClickCallback();        
    }

	protected function _prepareColumns() {
		parent::_prepareColumns();		
		
		$this->addColumn('customer_group_id',
            array(
                'header'=> Mage::helper('customer')->__('Customer Groups'),
                'width' => '80px',
                'index' => 'customer_group_id',
             	'type'  => 'options',
                'options' => $this->_getCustomerGroupsAsOptionArray(),
            	'filter_index' => '`customer`.`group_id`',
        ));
	}
    
	protected function _getCustomerGroupsAsOptionArray() {
		$collection = Mage::getSingleton('customer/group')->getCollection();
		$collection->load();
		
//		printf($collection->getSelect()->assemble()."<br>");
		
		$res = array();
   		foreach($collection->getItems() as $item) {
   			if ($item->getData('customer_group_id') == 0) {
   				$res['NULL'] = $item->getData('customer_group_code');
   			} else {
   				$res[$item->getData('customer_group_id')] = $item->getData('customer_group_code');
   			}   			
   		}
   		
   		return $res;
	}
}