<?php
class Stala_CustomerReports_Block_Adminhtml_Report_Sales_Invoiced_Grid extends Mage_Adminhtml_Block_Report_Sales_Invoiced_Grid 
{
    protected function _prepareCollection()
    {
        $filterData = $this->getFilterData();

        if ($filterData->getData('from') == null || $filterData->getData('to') == null) {
            $this->setCountTotals(false);
            $this->setCountSubTotals(false);
            return parent::_prepareCollection();
        }

        $storeIds = $this->_getStoreIds();;

        $orderStatuses = $filterData->getData('order_statuses');
        if (is_array($orderStatuses)) {
            if (count($orderStatuses) == 1 && strpos($orderStatuses[0],',')!== false) {
                $filterData->setData('order_statuses', explode(',',$orderStatuses[0]));
            }
        }

        $customergroup = null;
        if($filterData->getData('customergroup') > 0)  
        {
        	$customergroup = $filterData->getData('customergroup') -1;
        }  
        
        $resourceCollection = Mage::getResourceModel($this->getResourceCollectionName())
            ->setPeriod($filterData->getData('period_type'))
            ->setDateRange($filterData->getData('from', null), $filterData->getData('to', null))
            ->addStoreFilter($storeIds)
            ->addOrderStatusFilter($filterData->getData('order_statuses'))
            ->setAggregatedColumns($this->_getAggregatedColumns())
            ->addCustomerGroup($customergroup);



        if ($filterData->getData('show_empty_rows', false)) {
            Mage::helper('reports')->prepareIntervalsCollection(
                $this->getCollection(),
                $filterData->getData('from', null),
                $filterData->getData('to', null),
                $filterData->getData('period_type')
            );
        }

        if ($this->getCountSubTotals()) {
            $this->getSubTotals();
        }

        if ($this->getCountTotals()) {
            $totalsCollection = Mage::getResourceModel($this->getResourceCollectionName())
                ->setPeriod($filterData->getData('period_type'))
                ->setDateRange($filterData->getData('from', null), $filterData->getData('to', null))
                ->addStoreFilter($storeIds)
                ->addOrderStatusFilter($filterData->getData('order_statuses'))
                ->setAggregatedColumns($this->_getAggregatedColumns())
                ->isTotals(true)
                ->addCustomerGroup($customergroup);
            foreach ($totalsCollection as $item) {
                $this->setTotals($item);
                break;
            }
        }

        if ($this->_isExport) {
            $this->setCollection($resourceCollection);
            return $this;
        }
        
        $this->getCollection()->setColumnGroupBy($this->_columnGroupBy);
        $this->getCollection()->setResourceCollection($resourceCollection);

        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

}