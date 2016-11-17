<?php

class Sid_Import_Block_Adminhtml_Import_Edit_Tab_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	private  $_id = 0;
  public function __construct()
  {
      parent::__construct();
      $this->setId('importGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('ASC');
      $this->setUseAjax(true);
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('sidimport/storage')->getCollection();
      $this->_id = intval($this->getRequest()->getParam('los'));
    
     // $collection->getSelect()->where('los_id=?', intval($this->_id));
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('sku', array(
          'header'    => Mage::helper('sidimport')->__('Sku'),
          //'align'     =>'right',
          'width'     => '50px',
          'index'     => 'sku',
      ));
      
       $this->addColumn('type',
            array(
                'header'=> Mage::helper('catalog')->__('Type'),
                'width' => '60px',
                'index' => 'type',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));
      
      
      $this->addColumn('name', array(
      		'header'    => Mage::helper('sidimport')->__('Name'),
      		//'align'     =>'right',
      		//'width'     => '250px',
      		'index'     => 'name',
      ));
      
      
      $store = Mage::app()->getStore(0);
      $this->addColumn('price',
      		array(
      				'header'=> Mage::helper('catalog')->__('Price'),
      				'type'  => 'price',
      				'currency_code' => $store->getBaseCurrency()->getCode(),
      				'index' => 'price',
      		));
      
     

 
      return parent::_prepareColumns();
  }

  protected function _prepareMassaction()
  {
  	$this->setMassactionIdField('_id');
  	$this->getMassactionBlock()->setFormFieldName('import_ids');
  
  
	$this->getMassactionBlock()->addItem('status', array(
  			'label'=> Mage::helper('import')->__('Import'),
  			'url'  => $this->getUrl('*/*/massImport', array('_current'=>true))
  			)
  	);
  	return $this;
  }
  
  public function getGridUrl()
  {
  	return $this->getUrl('*/*/grid', array('los' => $this->_id));
  }

}