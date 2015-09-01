<?php

class Dwd_Stationen_Block_Adminhtml_Set_Edit_Tab_Products_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	private $_model = null;
	
	
	
  public function __construct()
  {
      parent::__construct();
      $this->setId('produktesetGrid');
      $this->setDefaultSort('product_id');
      $this->setDefaultDir('ASC');
      //$this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
      if(count($this->getSelectedProducts()))
      {
      	$this->setDefaultFilter(array('in_setp'=>'1'));
      }
  }

  protected function _prepareCollection()
  {
  		$type =  new Zend_Db_Expr("(type_id = '" . Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE ."' OR 
  						type_id= '" . Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL . "' OR 
  						type_id= '". Mage_Catalog_Model_Product_Type_Configurable::TYPE_CODE . "')");
  	
      $collection = Mage::getModel('catalog/product')->getCollection();
      $collection->addAttributeToSelect('*');
      $collection->getSelect()->where($type);
      	
 //die($collection->getSelect()->__toString());     
  
        	;
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
  
  
  protected function _addColumnFilterToCollection($column) {
		if ($this->getCollection()) {
			if ($column->getId() == 'in_setp') 
			{
				$sets = $this->_getProducts();
	            if (empty($sets)) {
	                $sets = 0;
	            }
	            
	            if ($column->getFilter()->getValue()== '1') {
	                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$sets));
	            }
	            else if ($column->getFilter()->getValue()== '0')
	            {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$sets));
                
            	}
				return $this;
			}
			
		}

		return parent::_addColumnFilterToCollection($column);
	}
  
  

 
   
    
  protected function _prepareColumns()
  {
  	
  		$this->addColumn('in_setp', array(
	        'header_css_class' => 'a-center',
	        'type'      	=> 'checkbox',
	        'name'      	=> 'in_setp',
  	   		'field_name'	=> 'in_setp',
	        'values'    	=> $this->_getProducts(),
	        'align'     	=> 'center',
//     		'filter_index' 	=> '`catalog/product`.entity_id',
	        'index'     	=> 'entity_id',
	        'width'			=> '90px'
        ));
  	
  	
      $this->addColumn('sku', array(
          'header'    => Mage::helper('stationen')->__('sku'),
          'align'     =>'right',
          'width'     => '150px',
          'index'     => 'sku',
      ));

      $this->addColumn('name_product', array(
          'header'    => Mage::helper('stationen')->__('Name'),
          'align'     =>'left',
          'index'     => 'name_product',
      	  'filter_index' =>'name'
      ));
      /*
      $this->addColumn('category',
    	array(
    			'header'=> Mage::helper('catalog')->__('Category'),
    			'width' => '150px',
    			'index' => 'single_category_id',
    			'type'  => 'options',
    			//'renderer' => 'adminhtml/widget_grid_column_renderer_text',
    			'options' => Mage::getSingleton('extreport/product_overview')->getCollection()->getCategorysAsOptionArray(),
    			'filter_index' => 'category_ids',
    	));
      */
      $this->addColumn('visibility',
            array(
                'header'=> Mage::helper('catalog')->__('Visibility'),
                'width' => '100px',
                'index' => 'visibility',
                'type'  => 'options',
                'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
        ));
	  
      $this->addColumn('status_product', array(
          'header'    => Mage::helper('stationen')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status_product',
      	  'filter_index'     => 'status',
          'type'      => 'options',
          'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
      ));
	 
      
      $this->addColumn('dummy', array(
            'header'    	=> Mage::helper('catalog')->__('ID'),
        	'name'			=> 'dummy',
            'index'     	=> 'entity_id',
            'header_css_class'	=> 'no-display ', //header
            'column_css_class'	=> 'no-display ', //body,footer
        	'editable'          => true,
            'edit_only'         => true,
            
        ));
      
 
		$this->addExportType('*/*/exportCsv', Mage::helper('stationen')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('stationen')->__('XML'));
	  
      return parent::_prepareColumns();
  }

 
  private function getModel()
  {
  	if($this->_model == null)
  	{
	  	$this->_model = Mage::registry('set_data');
	  	if(!$this->_model)
	  	{
	  		$id = $this->getRequest()->getParam('id');
	  		$this->_model  = Mage::getModel('stationen/set')->load($id);
	  	}
  	}
  	return $this->_model;
  }
  
  
  //ermitteln der verbunenen Stationen
	 private function _getProducts()
	  {
	  	$res = $this->getProductsSet();
  		if($res == null){
  			$res = array_keys( $this->getSelectedProducts());
  		}
  		return $res;

	  }

	 //ermitteln der verbunenen Producte
	 public function getSelectedProducts()
	 {
	  	
	 	$res = array();
	  	$collection = Mage::getModel('catalog/product')->getCollection();
	  	if($this->getModel()->getId())
	  	{
	  		$collection->addAttributeToFilter('stationen_set',$this->getModel()->getId());
			// die($collection->getSelect()->__toString()); 	
		  	foreach($collection->getItems() as $item)
		  	{
		  		$res[$item->getId()] =  array('dummy' => $item->getId());
		  	}
	  	}
	  	return $res;
	  }
	protected function _afterLoadCollection()
    {
    	
    	//umbenennen wegen namensgleicheiten mit dem set
        foreach($this->getCollection()->getItems() as $item)
        {
        	$item->setNameProduct($item->getName());
        	$item->setStatusProduct($item->getStatus());
        	
        }
        return $this;
    }
   
	
	public function getGridUrl()
    {
         return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/stationen_set/productsgrid', array('_current'=>true,'id'=>$this->getModel()->getId()));
    }
	
}