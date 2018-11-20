<?php

/**
 *
 * Product Options reports ResourceCollection
 *
 * @category   TuFreiberg
 * @package    TuFreiberg_TufReports
 * @author     Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 *
 */
class Egovs_EventBundle_Model_Resource_Report_Options_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	private $_categoryfilter = null;
	private $_categorynames = null;

	protected $_eventPrefix    = 'sales_report_eventbundle_options_collection';
	protected $_eventObject    = 'collection';
	
	private $_optionLabels = array();
	
	protected function _construct()
    {
        $this->_init('catalog/product_option');
    }
    
	private function getTablePrefix($val)
	{
		return Mage::getConfig()->getTablePrefix().$val;
	}
	
	
	public function getOptionLabels()
	{
		return $this->_optionLabels;
	}

	protected function _afterLoad()
	{
		parent::_afterLoad();
		
		foreach($this->getItems() as $item)
		{
			$option = $item->getProductOptions();
			$option = unserialize($option);
			$n = 0;
			if(isset($option['options']) && is_array($option['options']))
			{
				foreach($option['options'] as $o)
				{
					$label = 'eventoption_'.$o['label'];
					$item->setData($label, $o['value']);
					//$options[$o['label']] = $o['value'];
					$this->_optionLabels[$n] = $o['label'];
					$n++;
				}
			}
		}
		
		return $this;
	}
	
	
	

	protected function _initSelect()
	{
		parent::_initSelect();

		$this->getSelect()
			->where("p.type_id='eventbundle'")
            ->join(array('p'=>$this->getTable('catalog/product')),'main_table.product_id = p.entity_id')
			->join(array('order'=>$this->getTable('sales/order')),'order.entity_id=main_table.order_id',
						array('order_increment_id'=>'increment_id',
							   'order_entity_id'=>'entity_id',
							   
								
						))
			->where("product_options like '%options%'")
			//->where('item_id = 95')
			;
		//die($this->getSelect()->__toString());
		return $this;

	}
	
	public function getReportFull($from, $to)
    {
    	return $this;
    }
	
	/**
     * Get SQL for get record count
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $this->_renderFilters();

        $cloneSelect = clone $this->getSelect();
        $cloneSelect->reset(Zend_Db_Select::ORDER);
        $cloneSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $cloneSelect->reset(Zend_Db_Select::LIMIT_OFFSET);

        
        $countSelect = new Zend_Db_Select($cloneSelect->getAdapter());
        $countSelect->from($cloneSelect, 'COUNT(*)');

//		$sql = $this->getSelect()->assemble();
//		echo $sql.'<br>';
//		Mage::log($sql, Zend_Log::DEBUG, 'sql.log');
		
        return $countSelect;
    }

	/**
	 * Set Store filter to collection
	 *
	 * @param array $storeIds
	 * @return Mage_Reports_Model_Mysql4_Product_Sold_Collection
	 */
	public function setStoreIds($storeIds)
	{
		$vals = array_values($storeIds);
		if (count($storeIds) >= 1 && $vals[0] != '') {
			$this->addFieldToFilter('order.store_id', array('in' => (array)$storeIds));
		}
		
		return $this;
	}

	public function addWebsiteFilter($filter)
	{
		$filter = implode(',',$filter);
		$this->getSelect()->where('order.store_id in ('.$filter.')');		
	}


	public function addStoreFilter($filter)
	{
		//var_dump($filter);
		$this->getSelect()->where('order.store_id = '.$filter);
	}

}