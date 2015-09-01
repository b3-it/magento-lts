<?php

class Sid_Framecontract_Block_Adminhtml_Contract_Edit_Tab_Files_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('filesGrid');
      $this->setDefaultSort('files_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->_headersVisibility = false;
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('framecontract/files')->getCollection();
      $collection->getSelect()->where('framecontract_contract_id='. intval(Mage::registry('contract_data')->getId()));
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('framecontract_files_id', array(
          'header'    => Mage::helper('framecontract')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'framecontract_files_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('framecontract')->__('Title'),
          'align'     =>'left',
          'index'     => 'filename_original',
      ));
      
      $this->addColumn('type', array(
          'header'    => Mage::helper('framecontract')->__('Title'),
          'align'     =>'left',
          'index'     => 'type',
      	  'width'	  => '90px',
      	  'type'	=>'options',
          'options'   => Sid_Framecontract_Model_Filetype::getOptionArray()
      	
      ));


        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('framecontract')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('framecontract')->__('Download'),
                        'url'       => array('base'=> '*/*/download'),
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
        				'header'    =>  Mage::helper('framecontract')->__('Action'),
        				'width'     => '100',
        				'type'      => 'action',
        				'getter'    => 'getId',
        				'actions'   => array(
        						array(
        								'caption'   => Mage::helper('framecontract')->__('Delete'),
        								'url'       => array('base'=> '*/*/deletefile'),
        								'field'     => 'id'
        						)
        				),
        				'filter'    => false,
        				'sortable'  => false,
        				'index'     => 'stores',
        				'is_system' => true,
        		));
        
		//$this->addExportType('*/*/exportCsv', Mage::helper('framecontract')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('framecontract')->__('XML'));
	  
      return parent::_prepareColumns();
  }



  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/download', array('id' => $row->getId()));
  }

}