<?php

class Dwd_ConfigurableVirtual_Block_Adminhtml_Credential_Edit_Tab_Purchased_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
      //$this->setDefaultFilter(array('station_status'=>Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE));
  }

  protected function _prepareCollection()
  {
  	  $id = intval($this->getRequest()->getParam('id'));  	
      $collection = Mage::getModel('configvirtual/purchased_item')->getCollection();
      //$collection->addAttributeToSelect('*');
      $collection->getSelect()
      	->joinleft(array('stationen'=>'stationen_entity'),'main_table.station_id=stationen.entity_id',array('stationskennung'))
      	->join(array('products'=>'catalog_product_entity'),'main_table.product_id=products.entity_id',array('sku'))
      	->join(array('order_item'=>'sales_flat_order_item'),'order_item.item_id = main_table.order_item_id',array('period_start','period_end'))
      	->where('credential_id='.$id);
      	
 
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
  
  
  protected function x_addColumnFilterToCollection($column) {
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
	  $this->addColumn('sku', array(
          'header'    => Mage::helper('stationen')->__('sku'),
          'align'     =>'right',
          'width'     => '150px',
          'index'     => 'sku',
      ));

      $this->addColumn('external_link_url', array(
          'header'    => Mage::helper('stationen')->__('Link'),
          'align'     =>'left',
          'index'     => 'external_link_url',
      ));
      
     $this->addColumn('stationskennung', array(
          'header'    => Mage::helper('stationen')->__('Station'),
          'align'     =>'left',
     	 'width' => '80',
          'index'     => 'stationskennung',
      ));
 	
     $this->addColumn('period_start', array(
          'header'    => Mage::helper('configvirtual')->__('Period Start'),
          'align'     =>'left',
      	  'width'	  => '120',
      	  'type' 	  => 'datetime',
          'index'     => 'period_start',
      ));
      
      $this->addColumn('period_end', array(
          'header'    => Mage::helper('configvirtual')->__('Period End'),
          'align'     =>'left',
      	  'width'	  => '120',
      	  'type' 	  => 'datetime',
          'index'     => 'period_end',
      ));
      
 
		$this->addExportType('*/*/exportCsv', Mage::helper('stationen')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('stationen')->__('XML'));
	  
      return parent::_prepareColumns();
  }

 
	public function getGridUrl()
    {
         return $this->getUrl('*/configvirtual_credential/purchasedgrid', array('id'=>intval($this->getRequest()->getParam('id'))));
    }
 
   
	
	public function xgetGridUrl()
    {
         return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/stationen_set/productsgrid', array('_current'=>true,'id'=>$this->getModel()->getId()));
    }
	
}