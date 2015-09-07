<?php

class Slpb_Verteiler_Block_Adminhtml_Verteiler_Edit_Tab_Customer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_model = null;
	
    public function __construct()
    {
        parent::__construct();
        $this->setId('customerGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('group_id')
            ->addAttributeToSelect('company')
            ->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
            ->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
            ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
            ->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
            ->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left')
            ->joinAttribute('billing_company1', 'customer_address/company', 'default_billing', null, 'left')
            ->joinAttribute('billing_company2', 'customer_address/company2', 'default_billing', null, 'left')
            ->joinAttribute('billing_company3', 'customer_address/company3', 'default_billing', null, 'left')
        
        	->addExpressionAttributeToSelect('full_company',
        		'CONCAT({{billing_company1}}, " ", {{billing_company2}}," ",{{billing_company3}})',
        		array('billing_company1', 'billing_company2','billing_company3'))
        		;
        
        
        
//die($collection->getSelect()->__toString());
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _addColumnFilterToCollection($column) {
		if ($this->getCollection()) {
			if ($column->getId() == 'in_set') 
			{
				$sets = $this->_getSelectedCustomer();
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
  
  
    protected function _prepareColumns()
    {
    	
    	$this->addColumn('in_set', array(
	        'header_css_class' => 'a-center',
	        'type'      	=> 'checkbox',
	        'name'      	=> 'in_set',
  	   		//'field_name'	=> 'in_set',
  	   		'filter'		=> 'verteiler/adminhtml_widget_grid_column_filter_checkbox',
	        'values'    	=> $this->_getSelectedCustomer(),
	        'align'     	=> 'center',
//     		'filter_index' 	=> '`catalog/product`.entity_id',
	        'index'     	=> 'entity_id',
	        'width'			=> '90px'
        ));
    	
    	
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('customer')->__('ID'),
            'width'     => '50px',
            'index'     => 'entity_id',
            'type'  => 'number',
        ));
        /*$this->addColumn('firstname', array(
            'header'    => Mage::helper('customer')->__('First Name'),
            'index'     => 'firstname'
        ));
        $this->addColumn('lastname', array(
            'header'    => Mage::helper('customer')->__('Last Name'),
            'index'     => 'lastname'
        ));*/
        $this->addColumn('namecustomer', array(
            'header'    => Mage::helper('customer')->__('Name'),
            'index'     => 'name'
        ));
        
        $this->addColumn('full_company', array(
        		'header'    => Mage::helper('customer')->__('Company'),
        		'index'     => 'full_company'
        ));
                
        $this->addColumn('email', array(
            'header'    => Mage::helper('customer')->__('Email'),
            'width'     => '150',
            'index'     => 'email'
        ));

        $groups = Mage::getResourceModel('customer/group_collection')
            ->addFieldToFilter('customer_group_id', array('gt'=> 0))
            ->load()
            ->toOptionHash();

        $this->addColumn('group', array(
            'header'    =>  Mage::helper('customer')->__('Group'),
            'width'     =>  '100',
            'index'     =>  'group_id',
            'type'      =>  'options',
            'options'   =>  $groups,
        ));

        $this->addColumn('Telephone', array(
            'header'    => Mage::helper('customer')->__('Telephone'),
            'width'     => '100',
            'index'     => 'billing_telephone'
        ));

        $this->addColumn('billing_postcode', array(
            'header'    => Mage::helper('customer')->__('ZIP'),
            'width'     => '90',
            'index'     => 'billing_postcode',
        ));

        $this->addColumn('billing_country_id', array(
            'header'    => Mage::helper('customer')->__('Country'),
            'width'     => '100',
            'type'      => 'country',
            'index'     => 'billing_country_id',
        ));

        $this->addColumn('billing_region', array(
            'header'    => Mage::helper('customer')->__('State/Province'),
            'width'     => '100',
            'index'     => 'billing_region',
        ));
        
        
        if (!Mage::app()->isSingleStoreMode()) {
        	$this->addColumn('website_id', array(
        			'header'    => Mage::helper('customer')->__('Website'),
        			'align'     => 'center',
        			'width'     => '80px',
        			'type'      => 'options',
        			'options'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(true),
        			'index'     => 'website_id',
        	));
        }

        
       $this->addColumn('dummy', array(
                            'name'      => 'dummy',
                            'width'     => '0px',
                            'index'     => 'verteiler_id', //es sollen die Product IDs drin stehen
                            'renderer'		=> 'verteiler/adminhtml_widget_grid_column_renderer_hidden',
                            'filter'		=> 'verteiler/adminhtml_widget_grid_column_filter_hidden',
                            'header_css_class'	=> 'no-display ', //header
                            'column_css_class'	=> 'no-display ', //body,footer
        ));
        
  

        $this->addExportType('*/*/exportCsv', Mage::helper('customer')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('customer')->__('XML'));
        return parent::_prepareColumns();
    }



    public function xgetGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=> true));
    }

    public function getGridUrl()
    {
         //return $this->getUrl('stationen/adminhtml_set/stationengrid',array('id'=>$this->getModel()->getId()));
         return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('adminhtml/slpbverteiler_verteiler/customergrid', array('_current'=>true,'id'=>$this->getModel()->getId()));
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
    

 public function getSelectedCustomer()
 {
  	
  	$res = array();
  	
  	$customers = $this->getModel()->getCustomers();
  
  	if(count($customers) > 0)
  	{
	  	foreach($customers as $item)
	  	{
	  		$res[$item->getCustomerId()] =  array('dummy' => $item->getCustomerId());
	  	}
  	}
 // var_dump($res);	
  	return $res;
  }

 private function getModel()
  {
  	if($this->_model == null)
  	{
	  	$this->_model = Mage::registry('verteiler_data');
	  	if(!$this->_model)
	  	{
	  		$id = $this->getRequest()->getParam('id');
	  		$this->_model  = Mage::getModel('verteiler/verteiler')->load($id);
	  	}
  	}
  	return $this->_model;
  }
  
  	protected function _getSelectedCustomer()
  	{
  		$res = $this->getCustomerSet();
  		if($res == null){
  			$res = array_keys( $this->getSelectedCustomer());
  		}
  		return $res;
  	}
  	
 	protected function _afterLoadCollection()
    {
    	
    	//umbenennen wegen namensgleicheiten
        foreach($this->getCollection()->getItems() as $item)
        {
        	$item->setNameCustomer($item->getName());
       
        	
        }
        return $this;
    }
}