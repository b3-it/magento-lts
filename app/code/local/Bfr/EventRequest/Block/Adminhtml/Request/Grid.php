<?php
/**
 * Bfr EventRequest
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Block_Adminhtml_Request_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Block_Adminhtml_Request_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('requestGrid');
      $this->setDefaultSort('eventrequest_request_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
  	  $eav = Mage::getResourceModel('eav/entity_attribute');
  	  
      $collection = Mage::getModel('eventrequest/request')->getCollection();
      $collection->getSelect()
      	->join(array('customer'=>$collection->getTable('customer/entity')), 'main_table.customer_id = customer.entity_id',array('email'))
      	->join(array('product'=>$collection->getTable('catalog/product')), 'main_table.product_id = product.entity_id',array('sku'))
      	->joinleft(array('first'=>$collection->getTable('customer/entity').'_varchar'), 'first.entity_id = customer.entity_id AND first.attribute_id = '. $eav->getIdByCode('customer', 'firstname') ,array('firstname'=>'value'))
      	->joinleft(array('last'=>$collection->getTable('customer/entity').'_varchar'), 'last.entity_id = customer.entity_id AND last.attribute_id = '. $eav->getIdByCode('customer', 'lastname') ,array('lastname'=>'value'))
      	->joinleft(array('pre'=>$collection->getTable('customer/entity').'_varchar'), 'pre.entity_id = customer.entity_id AND pre.attribute_id = '. $eav->getIdByCode('customer', 'prefix') ,array('prefix'=>'value'))
      	 
      ;
     
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('eventrequest_request_id', array(
          'header'    => Mage::helper('eventrequest')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'eventrequest_request_id',
      	  'type'      => 'number',
      ));

      $this->addColumn('created_time', array(
      		'header'    => Mage::helper('eventrequest')->__('Created'),
      		'index'     => 'created_time',
      		'type'      => 'datetime',
      		'width'     => '150px',
      		//'filter_condition_callback' => array($this, '_filterCreatedAtCondition'),
      ));
      /*
      $this->addColumn('product_id', array(
      		'header'    => Mage::helper('eventrequest')->__('Product Id'),
      		'width'     => '100px',
      		'index'     => 'product_id',
      		'type'      => 'number',
      ));
       */
      $this->addColumn('sku', array(
      		'header'    => Mage::helper('eventrequest')->__('Sku'),
      		'width'     => '100px',
      		'index'     => 'sku',
      		//'type'      => 'number',
      ));
      
      $this->addColumn('title', array(
          'header'    => Mage::helper('eventrequest')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      
      $this->addColumn('email', array(
      		'header'    => Mage::helper('eventrequest')->__('Email'),
      		'align'     =>'left',
      		'index'     => 'email',
      ));
      
      $this->addColumn('firstname', array(
      		'header'    => Mage::helper('eventrequest')->__('Firstname'),
      		'align'     =>'left',
      		'index'     => 'firstname',
          'filter_index' => 'first.value'
      ));
      
      $this->addColumn('lastname', array(
      		'header'    => Mage::helper('eventrequest')->__('Lastname'),
      		'align'     =>'left',
      		'index'     => 'lastname',
          'filter_index' => 'last.value'
      ));

      $this->addColumn('status', array(
          'header'    => Mage::helper('eventrequest')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => Bfr_EventRequest_Model_Status::getOptionArray(),
      ));
	
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('eventrequest')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('eventrequest')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('eventrequest')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('eventrequest')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('request_id');
        $this->getMassactionBlock()->setFormFieldName('request');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('eventrequest')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('eventrequest')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('eventrequest/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('eventrequest')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('eventrequest')->__('Status'),
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
