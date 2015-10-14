<?php

class Dwd_Stationen_Block_Adminhtml_Stationen_Edit_Tab_Set_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_model = null;
  public function __construct()
  {
      parent::__construct();
      $this->setId('setGrid');
      $this->setDefaultSort('set_id');
      $this->setDefaultDir('ASC');
      //$this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
  
  }

  protected function _prepareCollection()
  {
  	  //$model = Mage::registry('stationen_data');
      $collection = Mage::getModel('stationen/set')->getCollection();
      $collection->addAttributeToSelect('*')
     
      		;
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

	protected function _addColumnFilterToCollection($column) {
		if ($this->getCollection()) {
			if ($column->getId() == 'in_set') 
			{
				$sets = $this->_getSelectedSets();
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
  
  

  
  
  //ermitteln der verbunenen Sets
 public function getSelectedSets()
 {
  	
 	$this->_model = Mage::registry('stationen_data');
  	if(!$this->_model)
  	{
  		$id = $this->getRequest()->getParam('id');
  		$this->_model  = Mage::getModel('stationen/stationen')->load($id);
  	}
  	$res = array();
  	$collection = Mage::getModel('stationen/set')->getCollection();
  	$collection->getSelect()
  		->distinct()
  		->join(array('relation'=>'stationen_set_relation'),"set_id = entity_id AND stationen_id='".$this->_model->getId()."'",array());
	
  	foreach($collection->getItems() as $item)
  	{
  		$res[$item->getId()] = array('dummy' => $item->getId());
  	}

  	return $res;
 	
 
  }

  
  	protected function _getSelectedSets()
  	{
  		$res = $this->getStationenSet();
  		if($res == null){
  			$res = array_keys( $this->getSelectedSets());
  		}
  		return $res;
  	}
  
  
  
  protected function _afterLoadCollection()
    {
        foreach($this->getCollection()->getItems() as $item)
        {
        	$item->setNameSet($item->getName());
        	$item->setSetId($item->getEntityId());
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
	        'values'    	=> $this->_getSelectedSets(),
	        'align'     	=> 'center',
//     		'filter_index' 	=> '`catalog/product`.entity_id',
	        'index'     	=> 'entity_id',
	        'width'			=> '90px'
        ));
  	
      $this->addColumn('entity_id', array(
          'header'    => Mage::helper('stationen')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'entity_id',
      ));

      $this->addColumn('name_set', array(
          'header'    => Mage::helper('stationen')->__('Name'),
          'align'     =>'left',
          'index'     => 'name_set',
      	  'filter_index' => 'name'	
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
      
		
		$this->addExportType('stationen/adminhtml_set/exportCsv', Mage::helper('stationen')->__('CSV'));
		$this->addExportType('stationen/adminhtml_set/exportXml', Mage::helper('stationen')->__('XML'));
	  
      return parent::_prepareColumns();
  }

	public function getGridUrl()
    {
         return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/stationen_stationen/setgrid', array('_current'=>true));
    }
    
 

}