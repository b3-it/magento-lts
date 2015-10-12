<?php

class Egovs_Informationservice_Block_Adminhtml_Request_Customer_Tab_Grid
    extends Egovs_Informationservice_Block_Adminhtml_Request_Grid
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Columns, that should be removed from grid
     *
     * @var array
     */
    protected $_columnsToRemove = array('customer_id', 'customer');

    /**
     * Disable filters and paging
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('customer_edit_tab_infoservice');
        $this->customer_id = $this->getRequest()->getParam('customer_id');
        $customer = Mage::registry('current_customer');
        if($customer)
        {
        	$this->customer_id = $customer->getId();
        }
        $this->setUseAjax(true);
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
        return true;
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

    public function getGridUrl()
    {
        return $this->getUrl('informationservice/adminhtml_request_customer_tab', array('_current'=>true,'customer_id'=> $this->customer_id));
        
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

  

    /**
     * Remove some columns and make other not sortable
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $result = parent::_prepareColumns();

        foreach ($this->_columns as $key => $value) {
            if (in_array($key, $this->_columnsToRemove)) {
                unset($this->_columns[$key]);
            }
        }
        return $result;
    }
}
