<?php

/**
 * Adminhtml-Customer-Grid-Block
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Customer_Activity_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Initialisiert das Grid
	 * 
	 * @return void
	 */
    public function __construct()
    {
        parent::__construct();
        $this->setId('customerGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('customer_filter');
        $this->addExportType('*/*/exportActivityCsv', 'CSV');
        $this->addExportType('*/*/exportActivityExcel', 'XML (Excel)');
		$this->_controller = 'adminhtml_customer';		
    }
    /**
     * Liefert den Store zurück
     *
     * @return Mage_Core_Model_Store>
     */
    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    /**
     * Bereitet die Collection vor
     * 
     * <ul>
     *  <li>Zusätzlicher Join auf log/customer</li>
     *  <li>Left join auf sales/order</li>
     *  <li>Left join auf newsletter_subscriber</li>
     * </ul>
     * 
     * @return Egovs_Extreport_Block_Adminhtml_Customer_Activity_Grid
     */
    protected function _prepareCollection()
    {
        $store = $this->_getStore();
        $collection = Mage::getSingleton('extreport/customer_activity')->getCollection()
        	->addNameToSelect();
        
        $resource = Mage::getSingleton('core/resource');
       	$collection->getSelect()
       		->join(array('cl'=>$resource->getTableName('log/customer')), 'e.entity_id = cl.customer_id', array('last_login'=>'max(login_at)'))
       		->joinleft(array('so'=>$resource->getTableName('sales/order')), 'so.customer_id = e.entity_id', array('last_order'=>'max(so.created_at)'))
       		->joinleft(array('n'=>$resource->getTableName('newsletter_subscriber')), 'n.customer_id = e.entity_id', array('subscriber_status'=>'subscriber_status'))
       		->group('entity_id');       	
   
 
//    	die( $collection->getSelect()->__toString());
        
        $this->setCollection($collection);

        parent::_prepareCollection();
        
        return $this;
    }   

    /**
     * Initialisiert die Spalten
     *
     * @return Egovs_Extreport_Block_Adminhtml_Customer_Activity_Grid
     */
    protected function _prepareColumns()
    {
    	$this->addColumn('entity_id',
    			array(
    					'header'=> Mage::helper('catalog')->__('ID'),
    					'width' => '50px',
    					'type'  => 'number',
    					'index' => 'entity_id',
    					//'total' => 'Total',
    			));
    	 
    	$this->addColumn('firstname',
    			array(
    					'header'=> Mage::helper('customer')->__('Firstname'),
    					'width' => '80px',
    					'index' => 'firstname',
    			));

    	$this->addColumn('lastname',
    			array(
    					'header'=> Mage::helper('customer')->__('Lastname'),
    					'width' => '80px',
    					'index' => 'lastname',
    			));

    		
    	$this->addColumn('email',
    			array(
    					'header'=> Mage::helper('customer')->__('eMail'),
    					//'width' => '80px',
    					'index' => 'email',
    			));
    	 
    	$groups = Mage::getResourceModel('customer/group_collection')
			    	->addFieldToFilter('customer_group_id', array('gt'=> 0))
			    	->load()
			    	->toOptionHash()
    	;

    	$this->addColumn('group', array(
    			'header'    =>  Mage::helper('customer')->__('Customer Group'),
    			'width'     =>  '100',
    			'index'     =>  'group_id',
    			'type'      =>  'options',
    			'options'   =>  $groups,
    			//	        	'filter_index' => '`group_id`',
    	));
    	 
    	 
    	$this->addColumn('customer_since', array(
    			'header'    => Mage::helper('customer')->__('Customer Since'),
    			'type'      => 'datetime',
    			'align'     => 'center',
    			'index'     => 'created_at',
    			'gmtoffset' => true
    	));

    	$this->addColumn('last_login', array(
    			'header'    => Mage::helper('extreport')->__('Last Login'),
    			'type'      => 'datetime',
    			'align'     => 'center',
    			'index'     => 'last_login',
    			'gmtoffset' => true
    	));

    	$this->addColumn('last_order', array(
    			'header'    => Mage::helper('extreport')->__('Last Order'),
    			'type'      => 'datetime',
    			'align'     => 'center',
    			'index'     => 'last_order',
    			'gmtoffset' => true
    	));

    	$this->addColumn('subscriber_status', array(
    			'header'    => Mage::helper('newsletter')->__('Newsletter'),
    			'index'     => 'subscriber_status',
    			'type'      => 'options',
    			//'filter_index' => 'n.subscriber_status',
    			'options'   => array(
    					'' => Mage::helper('extreport')->__('Not Subscribed'),
    					Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE   => Mage::helper('newsletter')->__('Not activated'),
    					Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED   => Mage::helper('newsletter')->__('Subscribed'),
    					Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED => Mage::helper('newsletter')->__('Unsubscribed'),
    			)
    	));

    	//$this->setCountTotals(true);
    	return parent::_prepareColumns();
    }
    
    /**
     * Fügt einen Splaten-Filter zur Collection hinzu
     * 
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Spalte
     * 
     * @return Egovs_Extreport_Block_Adminhtml_Customer_Activity_Grid
     */
	protected function _addColumnFilterToCollection($column)
    {
       
           if ($column->getId() == 'subscriber_status') {
           		$filter = $column->getFilter()->getValue();
           		$this->getCollection()->setSubscriberFilter($filter);
                return $this;
           }
           
           if ($column->getId() == 'customer_since') {
           		$filter = $column->getFilter()->getValue();
           		$this->getCollection()->setCustomerSinceFilter($filter);
                return $this;
           }
           
           if ($column->getId() == 'last_login') {
           		$filter = $column->getFilter()->getValue();
           		$this->getCollection()->setLastLoginFilter($filter);
                return $this;
           }
           
           if ($column->getId() == 'last_order') {
           		$filter = $column->getFilter()->getValue();
           		$this->getCollection()->setLastOrderFilter($filter);
                return $this;
           }
           
           return parent::_addColumnFilterToCollection($column); 
    }

    /**
     * Liefert die Grid-URL
     * 
     * @return string
     */
	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>'activity'));
	}	
}
