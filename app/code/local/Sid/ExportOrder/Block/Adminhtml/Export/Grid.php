<?php
/**
 * Sid ExportOrder
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Block_Adminhtml_Export_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Block_Adminhtml_Export_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('exportGrid');
      $this->setDefaultSort('export_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  /**
   * Retrieve collection class
   *
   * @return string
   */
  protected function _getCollectionClass()
  {
  	return 'sales/order_grid_collection';
  }
  
  protected function _prepareCollection()
  {
  	$collection = Mage::getResourceModel($this->_getCollectionClass());
  	$collection->getSelect()
  		->joinleft(array('export'=>$collection->getTable('exportorder/order')),'main_table.entity_id = export.order_id',array('export_status'=>'status','message'));
  		
  	$this->setCollection($collection);
  	return parent::_prepareCollection();
  }
  
  protected function _prepareColumns()
  {
  
  	$this->addColumn('real_order_id', array(
  			'header'=> Mage::helper('sales')->__('Order #'),
  			'width' => '80px',
  			'type'  => 'text',
  			'index' => 'increment_id',
  	));
  
  	if (!Mage::app()->isSingleStoreMode()) {
  		$this->addColumn('store_id', array(
  				'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
  				'index'     => 'store_id',
  				'type'      => 'store',
  				'store_view'=> true,
  				'display_deleted' => true,
  		));
  	}
  
  	$this->addColumn('created_at', array(
  			'header' => Mage::helper('sales')->__('Purchased On'),
  			'index' => 'created_at',
  			'type' => 'datetime',
  			'width' => '100px',
  	));
  
  	$this->addColumn('billing_name', array(
  			'header' => Mage::helper('sales')->__('Bill to Name'),
  			'index' => 'billing_name',
  	));
  

  	$this->addColumn('base_grand_total', array(
  			'header' => Mage::helper('sales')->__('G.T. (Base)'),
  			'index' => 'base_grand_total',
  			'type'  => 'currency',
  			'currency' => 'base_currency_code',
  	));
  
 
  
  	$this->addColumn('status', array(
  			'header' => Mage::helper('sales')->__('Order Status'),
  			'index' => 'status',
  			'type'  => 'options',
  			'width' => '70px',
  			'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
  			
  	));
  	
  	$this->addColumn('export_status', array(
  			'header' => Mage::helper('sales')->__('Export Status'),
  			'index' => 'export_status',
  			'type'  => 'options',
  			'width' => '70px',
  			'options' =>Sid_ExportOrder_Model_Syncstatus::getOptionArray(),
  			'filter_index' => 'export.status'
  	));
  	
  	$this->addColumn('message', array(
  			'header' => Mage::helper('sales')->__('Message'),
  			'index' => 'message',
  	));
  	
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('exportorder')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('exportorder')->__('Show'),
                        'url'       => array('base'=> '*/*/show'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        
        $this->addColumn('action1',
        		array(
        				'header'    =>  Mage::helper('exportorder')->__('Action'),
        				'width'     => '100',
        				'type'      => 'action',
        				'getter'    => 'getId',
        				'actions'   => array(
        						array(
        								'caption'   => Mage::helper('exportorder')->__('Download'),
        								'url'       => array('base'=> '*/*/download'),
        								'field'     => 'id'
        						)
        				),
        				'filter'    => false,
        				'sortable'  => false,
        				'index'     => 'stores',
        				'is_system' => true,
        		));

		//$this->addExportType('*/*/exportCsv', Mage::helper('exportorder')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('exportorder')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('export_id');
        $this->getMassactionBlock()->setFormFieldName('export');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('exportorder')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('exportorder')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('exportorder/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('exportorder')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('exportorder')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
