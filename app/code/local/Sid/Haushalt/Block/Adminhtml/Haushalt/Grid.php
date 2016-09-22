<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Block_Adminhtml_Haushalt_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('haushaltGrid');
      //$this->setDefaultSort('haushalt_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _getCollectionClass()
  {
  	return 'sales/order_grid_collection';
  }
  
  protected function _prepareCollection()
  {
  	
    	$collection = Mage::getResourceModel($this->_getCollectionClass());
    	
    	$collection->getSelect()
    		->join(array('order_info'=>$collection->getTable('sidhaushalt/order_info')),'main_table.entity_id = order_info.order_id');
    	
    	$this->setCollection($collection);
      	return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	
  	$yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
  	$yesno = array();
  	foreach ($yn as $n)
  	{
  		$yesno[$n['value']] = $n['label'];
  	}
  	
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
            	'width' => '200px',
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
        
 		$this->addColumn('haushaltsystem', array(
 				'header' => Mage::helper('sidhaushalt')->__('Haushalts System'),
 				'index' => 'haushalts_system',
 				'width' => '70px',
 				'type'  => 'options',
 				'options' => Sid_Haushalt_Model_Type::getTypeList(),
 		));

 		$this->addColumn('status', array(
 				'header' => Mage::helper('sales')->__('Status'),
 				'index' => 'status',
 				'type'  => 'options',
 				'width' => '70px',
 				'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
 		));
 		
        $this->addColumn('exported', array(
            'header' => Mage::helper('sidhaushalt')->__('Exported'),
            'index' => 'exported',
            'type'  => 'options',
            'width' => '70px',
            'options' => $yesno,
        ));
		
		
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('haushalt');

        $this->getMassactionBlock()->addItem('export', array(
             'label'    => Mage::helper('sidhaushalt')->__('Export'),
             'url'      => $this->getUrl('*/*/massExport'),
             //'confirm'  => Mage::helper('sidhaushalt')->__('Are you sure?')
        ));

        
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}