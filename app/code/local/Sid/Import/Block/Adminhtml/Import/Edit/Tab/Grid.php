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
  	  $helper = Mage::helper('sidimport');
  	  /**
  	   * @var Mage_Core_Model_Resource_Db_Collection_Abstract $collection
  	   */
      $collection = Mage::getModel('sidimport/storage')->getCollection();
      $this->_id = intval($this->getRequest()->getParam('los'));
      $productModel = Mage::getModel('catalog/product');

      /**
       * @var Mage_Core_Model_Session $session
       */
      $session = Mage::getSingleton("admin/session");
      $prefix = $session->getImportDefaults()['sku_prefix'];

      $exist = array();
      foreach ($collection as $item) {
      	$sku = $item->getSku();

      	if ($productModel->loadByAttribute('sku', $prefix."/".$sku) !== false) {
      		$exist[] = $sku;
      	}
      }

      foreach ($exist as $sku) {
      	$this->getMessagesBlock()->addNotice($helper->__("Product with SKU with '%s' already exist!",  $prefix."/".$sku));
      }

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
  			'label'=> Mage::helper('sidimport')->__('Import'),
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