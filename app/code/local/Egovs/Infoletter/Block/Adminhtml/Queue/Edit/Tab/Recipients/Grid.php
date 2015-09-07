<?php

class Egovs_Infoletter_Block_Adminhtml_Queue_Edit_Tab_Recipients_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_model = null;
  public function __construct()
  {
      parent::__construct();
      $this->setId('resipientsGrid');
      $this->setDefaultSort('resipient_id');
      $this->setDefaultDir('ASC');
      //$this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
  
  }

  protected function _prepareCollection()
  {
  	  //$model = Mage::registry('stationen_data');
      $collection = Mage::getModel('infoletter/recipient')->getCollection();
      $queueid = 0;
      if(Mage::registry('queue_data')->getMessageId())
      {
      	 $queueid = Mage::registry('queue_data')->getMessageId();
      }
      $collection->getSelect()->where("message_id=".$queueid);
     
      		;
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

	

  

  

  
  
  protected function _prepareColumns()
  {
 	
      $this->addColumn('email', array(
      		'header'    => Mage::helper('infoletter')->__('Email'),
      		'align'     =>'left',
      		'index'     => 'email',
      		'filter_index' => 'email'
      ));
      
      $this->addColumn('name', array(
          'header'    => Mage::helper('infoletter')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      	  'filter_index' => 'name'	
      ));

      $this->addColumn('status', array(
      		'header'    => Mage::helper('infoletter')->__('Status'),
      		'align'     =>'left',
      		'index'     => 'status',
      		'filter_index' => 'status',
      		'width'     => '80px',
      		'type'      => 'options',
      		'options'   => Egovs_Infoletter_Model_Recipientstatus::getOptionArray(),
      ));

      $this->addColumn('send', array(
      		'header'    => Mage::helper('infoletter')->__('Send At'),
      		'align'     =>'left',
      		'index'     => 'processed_at',
      		'filter_index' => 'processed_at',
      		'type'      => 	'datetime',
            'gmtoffset' => true,
      		'width'     => '120px',
      ));
      
		
		//$this->addExportType('stationen/adminhtml_set/exportCsv', Mage::helper('stationen')->__('CSV'));
		//$this->addExportType('stationen/adminhtml_set/exportXml', Mage::helper('stationen')->__('XML'));
	  
      return parent::_prepareColumns();
  }

	public function xgetGridUrl()
    {
         return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/stationen_stationen/setgrid', array('_current'=>true));
    }
    
 

}