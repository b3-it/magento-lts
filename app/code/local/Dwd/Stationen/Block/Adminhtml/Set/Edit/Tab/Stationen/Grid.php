<?php

class Dwd_Stationen_Block_Adminhtml_Set_Edit_Tab_Stationen_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	private $_model = null;
	
	
	
  public function __construct()
  {
      parent::__construct();
      $this->setId('stationensetGrid');
      $this->setDefaultSort('stationskennung');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(false);
      $this->setUseAjax(true);
      $this->setIdFieldName('entity_id');
      
      if(count($this->getSelectedStationen()))
      {
      	$this->setDefaultFilter(array('in_set'=>Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE));
      }
      
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('stationen/stationen')->getCollection();
      $collection->addAttributeToSelect('*');
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
  
  
  protected function _addColumnFilterToCollection($column) {
		if ($this->getCollection()) {
			if ($column->getId() == 'in_set') 
			{
				$sets = $this->_getSelectedStations();
	            if (empty($sets)) {
	                $sets = 0;
	            }
	            
	            if ($column->getFilter()->getValue()== '1') {
	                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$sets));
	                $sql = $this->getCollection()->getSelect()->__toString();
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
  
  

  protected function _afterLoadCollection()
    {
    	
    	//umbenennen wegen namensgleicheiten mit dem set
        foreach($this->getCollection()->getItems() as $item)
        {
        	$item->setNameStation($item->getName());
        	$item->setStationId($item->getStationskennung());
        	$item->setStationStatus($item->getStatus());
        	
        }
        return $this;
    }
  
 	
   
    
  protected function _prepareColumns()
  {
  	
  		$this->addColumn('in_set', array(
	        'header_css_class' => 'a-center',
	        'type'      	=> 'checkbox',
	        'name'      	=> 'in_set',
  	   		'field_name'	=> 'in_set',
	        'values'    	=> $this->_getSelectedStations(),
	        'align'     	=> 'center',
//     		'filter_index' 	=> '`catalog/product`.entity_id',
	        'index'     	=> 'entity_id',
  			'use_index'     => 'entity_id',
	        'width'			=> '90px',
  			'is_system'		=> true,
  			'renderer'		=> 'stationen/adminhtml_widget_form_renderer_grid_column_checkbox'
        ));
  	

  	
      $this->addColumn('stationskennung', array(
          'header'    	=> Mage::helper('stationen')->__('Kennung'),
          'align'     	=>'right',
          'width'     	=> '150px',
          'index'     	=> 'stationskennung', 
      	  'filter_index'=> 'stationskennung',	  	

      ));
      
     $this->addColumn('mirakel', array(
          'header'    	=> Mage::helper('stationen')->__('Mirakel ID'),
          'align'     	=>'right',
          'width'     	=> '100px',
          'index'     	=> 'mirakel_id', 
      ));

      $this->addColumn('name_station', array(
          'header'    		=> Mage::helper('stationen')->__('Name'),
          'align'     		=> 'left',
          'index'     		=> 'name_station',
      	  'filter_index'	=> 'name'
      ));
      
      
      $filter = Mage::getModel('stationen/entity_attribute_source_filter'); 
      $filter->setConfigKey('messnetz');
      $this->addColumn('messnetz', array(
          'header'    => Mage::helper('stationen')->__('Messnetz'),
          'align'     =>'left',
          'index'     => 'messnetz',
     	  'width'     => '150px',
      	  'type'      => 'options',
          'options'   => $filter->getOptionArray(),
      ));
      
     $filter->setConfigKey('styp');
     $this->addColumn('styp', array(
          'header'    => Mage::helper('stationen')->__('styp'),
          'align'     =>'left',
          'index'     => 'styp',
      	  'width'     => '150px',
          'type'      => 'options',
          'options'   => $filter->getOptionArray(),
      ));
      
      $filter->setConfigKey('ktyp');
      $this->addColumn('ktyp', array(
          'header'    => Mage::helper('stationen')->__('ktyp'),
          'align'     =>'left',
          'index'     => 'ktyp',
      	  'width'     => '150px',
          'type'      => 'options',
          'options'   => $filter->getOptionArray(),
      ));
      
      
      $this->addColumn('avail_from', array(
          'header'    	=> Mage::helper('stationen')->__('Start Date'),
          'align'     	=> 'left',
          'index'     	=> 'avail_from',
       	  'type'		=> 'date',
      	  'width'		=> '80px',
      ));
      
      $this->addColumn('avail_to', array(
          'header'    => Mage::helper('stationen')->__('End Date'),
          'align'     =>'left',
          'index'     => 'avail_to',
      	  'type'	=>'date',
      	  'width'	=> '80px',
      ));
      
     $this->addColumn('lat', array(
          'header'    => Mage::helper('stationen')->__('Latitude'),
          'align'     =>'left',
          'index'     => 'lat',
     'type'	=>'number',
     		'width'	=> '100px',
      ));
      
      $this->addColumn('lon', array(
          'header'    => Mage::helper('stationen')->__('Longitude'),
          'align'     =>'left',
          'index'     => 'lon',
      'type'	=>'number',
      		'width'	=> '100px',
      ));
      
      $this->addColumn('height', array(
          'header'    => Mage::helper('stationen')->__('Height NN'),
          'align'     =>'left',
          'index'     => 'height',
      	  'type'	=> 'number',
      		'width'	=> '80px',
      ));

	  
      $this->addColumn('station_status', array(
          'header'    => Mage::helper('stationen')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'station_status',
      	  'filter_index'     => 'status',
          'type'      => 'options',
          'options'   => Dwd_Stationen_Model_Stationen_Status::getOptionArray(),
      ));
	 
      
      $this->addColumn('dummy', array(
            'header'    	=> Mage::helper('catalog')->__('ID'),
        	'name'			=> 'dummy',
           	'is_system'		=> true,
            'index'     	=> 'station_id',
            'header_css_class'	=> 'no-display ', //header
            'column_css_class'	=> 'no-display ', //body,footer
        	'editable'          => true,
            'edit_only'         => true,
            
        ));
      
      
		$this->addExportType('*/*/exportStationenCsv', Mage::helper('stationen')->__('CSV'));
		$this->addExportType('*/*/exportStationenXml', Mage::helper('stationen')->__('XML'));
	  
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
 public function getSelectedStationen()
 {
  	
  	$res = array();
  	//$collection = Mage::getModel('stationen/stationen')->getCollection();
  	$stationen = $this->getModel()->getStationen();
  
	  	foreach($stationen as $item)
	  	{
	  		$res[$item->getId()] =  array('dummy' => $item->getId());
	  	}
  	
  	return $res;
  }

  
  	protected function _getSelectedStations()
  	{
  		$res = $this->getStationenSet();
  		if($res == null){
  			$res = array_keys( $this->getSelectedStationen());
  		}
  		return $res;
  	}
  
  
	public function getGridUrl()
    {
         return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/stationen_set/stationengrid', array('_current'=>true,'id'=>$this->getModel()->getId()));
    }
    

}