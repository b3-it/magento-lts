<?php
 class TuChemnitz_Voucher_Block_Adminhtml_Catalog_Product_Edit_Tab_Voucher_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('tucvouchertanGrid');
      //$this->setDefaultSort('tan_id');
      //$this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
      $this->setNoFilterMassactionColumn(true);
     // $this->canDisplayContainer = true;
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('tucvoucher/tan')->getCollection();
      $product_id = $this->getProduct()->getId();
 
      if($product_id)
      {
	      $collection->getSelect()
	      	->where('product_id='.$product_id)  	
      	;
      }
      //die($collection->getSelect()->__toString());
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	
      $this->addColumn('tan_id', array(
          'header'    => Mage::helper('tucvoucher')->__('Tan ID'),
          'align'     =>'right',
          'width'     => '50px',
      	  'type'	=> 'number',
          'index'     => 'tan_id',
      	
      ));
      
     
      $this->addColumn('tan', array(
          'header'    => Mage::helper('tucvoucher')->__('Tan'),
            // 'width'     => '120px',
             'index'     => 'tan',
      ));
      
      $this->addColumn('expire', array(
      		'header'    => Mage::helper('tucvoucher')->__('Expire Date'),
      		'align'     =>'left',
      		'width' => '120',
      		'type' => 'date',
      		'index'     => 'expire',
      		//'filter_index'     => 'main_table.created_at',
      ));
    
      
      $this->addColumn('created_at', array(
          'header'    => Mage::helper('tucvoucher')->__('Created At'),
          'align'     =>'left',
      	  'width' => '120',
      	  'type' => 'datetime',
          'index'     => 'created_at',
      	  //'filter_index'     => 'main_table.created_at',
      ));
      
     
	  
     $this->addColumn('status', array(
            'header' => Mage::helper('tucvoucher')->__('Status'),
            'index' => 'status',
     		'filter_index' =>'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('tucvoucher/status')->getOptionArray(),
        ));
        
     
      
   
      
     
	  
      return parent::_prepareColumns();
  }

  /**
   * Retrieve product
   *
   * @return Mage_Catalog_Model_Product
   */
  protected function getProduct()
  {
  	return Mage::registry('current_product');
  }
  
  
  public function getGridUrl()
  {
  	return $this->getUrl('*/voucher_product_edit/grid',array('id'=>$this->getProduct()->getId()));
  }

  protected function _prepareMassaction()
  {
  	$this->setMassactionIdField('tan_id');
  	$this->getMassactionBlock()->setFormFieldName('tan_ids');
  
  	$this->getMassactionBlock()->addItem('delete', array(
  			'label'    => Mage::helper('tucvoucher')->__('Delete'),
  			'url'      => $this->getUrl('*/voucher_product_edit/massDelete',array('product_id'=>$this->getProduct()->getId())),
  			'confirm'  => Mage::helper('tucvoucher')->__('Are you sure?')
  	));
  	return $this;
  }
}