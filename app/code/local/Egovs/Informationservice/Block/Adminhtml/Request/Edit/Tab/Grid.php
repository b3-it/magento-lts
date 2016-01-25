<?php

class Egovs_Informationservice_Block_Adminhtml_Request_Edit_Tab_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	private  $_id = 0;
  public function __construct()
  {
      parent::__construct();
      $this->setId('taskGrid');
      $this->setDefaultSort('task_id');
      $this->setDefaultDir('ASC');
      $this->setUseAjax(true);
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('informationservice/task')->getCollection();
      $this->_id = $this->getRequest()->getParam('id');
      //falls noch keine request_id soll auch nichts angezeigt werden
      if($this->_id == null) $this->_id = 0;
      $collection->getSelect()->where('request_id=?', intval($this->_id));
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('task_id', array(
          'header'    => Mage::helper('informationservice')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'task_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('informationservice')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      
      $this->addColumn('title', array(
          'header'    => Mage::helper('informationservice')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      
      $users = Mage::helper('informationservice')->getUsernamesAsOptionValues();
     $this->addColumn('user_id', array(
          'header'    => Mage::helper('informationservice')->__('User'),
          'align'     =>'left',
          'width'     => '100px',
          'type'	=> 'options',
     	  'options' => $users,
          'index'     => 'user_id',
      )); 
      
     $this->addColumn('owner_id', array(
          'header'    => Mage::helper('informationservice')->__('New Owner'),
          'align'     =>'left',
          'width'     => '100px',
          'type'	=> 'options',
     	  'options' => $users,
          'index'     => 'owner_id',
      )); 
      
      $this->addColumn('created_time', array(
          'header'    => Mage::helper('informationservice')->__('Datum'),
          'align'     =>'left',
      	  'type'	=> 'Date',
      	  'width'     => '50px',
          'index'     => 'created_time',
      ));
      
      
     $this->addColumn('newstatus', array(
          'header'    => Mage::helper('informationservice')->__('New Status'),
          'align'     =>'left',
          'width'     => '50px',
          'type'	=> 'options',
     	  'options' => Mage::getModel('informationservice/status')->getOptionArray(),
          'index'     => 'newstatus',
      ));
      
      $this->addColumn('cost', array(
          'header'   => Mage::helper('informationservice')->__('Real Cost'),
          'align'    =>'left',
          'width'    => '50px',
          'type'	 => 'number',
          'index'    => 'cost',
      	  'total'	 => 'sum'
      ));


        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('informationservice')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('informationservice')->__('View'),
                        'url'       => array('base'=>'*/*/taskdetail','params'=> array('mode'=>'view')),
                        'field'     => 'id',
                    	'popup'		=>1
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                //'index'     => 'stores',
                'is_system' => true,
        ));
//$this->setCountTotals(true); 		
        
		//$this->addExportType('*/*/exportCsv', Mage::helper('informationservice')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('informationservice')->__('XML'));
	  
      return parent::_prepareColumns();
  }

	protected function X_afterLoadCollection()
    {
        $totalObj = new Mage_Reports_Model_Totals();
        $this->setTotals($totalObj->countTotals($this,0,0));
    }

  public function xgetRowUrl($row)
  {
      return $this->getUrl('*/*/taskdetail', array('task_id' => $row->getId()));
  }
  
  public function getGridUrl()
  {
  	return $this->getUrl('*/*/taskgrid', array('id' => $this->_id));
  }

}