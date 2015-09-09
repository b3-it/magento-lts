<?php
/**
 * Egovs Infoletter
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Block_Adminhtml_Queue_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Block_Adminhtml_Queue_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('queueGrid');
      $this->setDefaultSort('queue_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('infoletter/queue')->getCollection();
      
      $collection->getSelect()
      ->joinleft(array('rec'=>$collection->getTable('infoletter/recipient')),'rec.message_id = main_table.message_id',array('recipients'=>'count(recipient_id)') );
      
      $this->setCollection($collection);
      
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('infoletter_queue_id', array(
          'header'    => Mage::helper('infoletter')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'message_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('infoletter')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));


      $this->addColumn('recipients', array(
			'header'    => Mage::helper('infoletter')->__('Recipients'),
			'width'     => '50px',
			'index'     => 'recipients',
      ));


      $this->addColumn('status', array(
          'header'    => Mage::helper('infoletter')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => Egovs_Infoletter_Model_Status::getOptionArray(),
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('infoletter')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('infoletter')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    ),
                	array(
                		'caption'   => Mage::helper('infoletter')->__('Send'),
                		'url'       => array('base'=> '*/*/send'),
                		'field'     => 'id'
                	),
                		
                	array(
                				'caption'   => Mage::helper('infoletter')->__('Preview'),
                				'url'       => array('base'=> '*/*/preview'),
                				'field'     => 'id',
                				'popup'   => true,
                		)
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		//$this->addExportType('*/*/exportCsv', Mage::helper('infoletter')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('infoletter')->__('XML'));
	  
      return parent::_prepareColumns();
  }

 
  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}