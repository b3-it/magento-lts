<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Event_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Options_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('eventGrid');
      $this->setDefaultSort('event_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('eventmanager/event')->getCollection();
      $collection->getSelect()
      	->join(array('product'=>$collection->getTable('catalog/product')),'main_table.product_id = product.entity_id');
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('eventmanager_event_id', array(
          'header'    => Mage::helper('eventmanager')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'event_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('eventmanager')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      
  
      
      $this->addColumn('sku', array(
      		'header'    => Mage::helper('eventmanager')->__('Sku'),
      		'align'     =>'left',
      		'index'     => 'sku',
      		'width'     => '150px',
      ));
      
      $this->addColumn('event_from', array(
      		'header'    => Mage::helper('eventmanager')->__('Start Date'),
      		'align'     =>'left',
      		'index'     => 'event_from',
      		'type'	=> 'Date',
      ));


/*
      $this->addColumn('status', array(
          'header'    => Mage::helper('eventmanager')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => Bfr_EventManager_Model_Status::getOptionArray(),
      ));
	*/
//        $this->addColumn('action',
//            array(
//                'header'    =>  Mage::helper('eventmanager')->__('Action'),
//                'width'     => '100',
//                'type'      => 'action',
//                'getter'    => 'getId',
//                'actions'   => array(
//                    array(
//                        'caption'   => Mage::helper('eventmanager')->__('Edit'),
//                        'url'       => array('base'=> '*/*/edit'),
//                        'field'     => 'id'
//                    )
//                ),
//                'filter'    => false,
//                'sortable'  => false,
//                'index'     => 'stores',
//                'is_system' => true,
//        ));

		//$this->addExportType('*/*/exportCsv', Mage::helper('eventmanager')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('eventmanager')->__('XML'));

      return parent::_prepareColumns();
  }



  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

  
 
  
  
}
