<?php

class Stala_Abo_Block_Adminhtml_Contract_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
 
  
  
  public function __construct($attributes = null)
  {
  	  parent::__construct();
      $this->setId('contractGrid');
      $this->setDefaultSort('contract_id');
      $this->setDefaultDir('ASC');
      //$this->setUseAjax(true);
       
      // Falls vom customerTab aufgerufen ist die custmer_id gesetzt
      /*
       if($attributes != null)
       {
       		if(isset($attributes['customer_id']))
       		{
       			$this->setUseAjax(true);
       			$this->setCustomerId($attributes['customer_id']);
       		}
       		//$this->setUseAjax(true);
       }
    */
      $this->setSaveParametersInSession(true);
  }
  
	private function getCustomerId()
	{
		return Mage::getSingleton('adminhtml/session')->getData('customer_id');
	}
  
  
  protected function _prepareCollection()
  {
  	 $eav = Mage::getResourceModel('eav/entity_attribute');

  	  $shippingcompany = new Zend_Db_Expr("trim(concat(COALESCE(shipping_customer_company.value, ''), ' ', COALESCE(shipping_customer_company2.value, ''), ' ', COALESCE(shipping_customer_company3.value, ''))) as shipping_company");
      $billingcompany = new Zend_Db_Expr("trim(concat(COALESCE(billing_customer_company.value, ''), ' ', COALESCE(billing_customer_company2.value, ''), ' ', COALESCE(billing_customer_company3.value, ''))) as billing_company");
      
      $shippingaddress = new Zend_Db_Expr("trim(concat(COALESCE(shipping_customer_street.value, ''), ' ', COALESCE(shipping_customer_postcode.value, ''), ' ', COALESCE(shipping_customer_city.value, ''))) as shipping_address");
      $shippingname = new Zend_Db_Expr("trim(concat(COALESCE(shipping_customer_firstname.value, ''), ' ', COALESCE(shipping_customer_lastname.value, ''))) as shipping_name");
      
      $billingaddress = new Zend_Db_Expr("trim(concat(COALESCE(billing_customer_street.value, ''), ' ', COALESCE(billing_customer_postcode.value, ''), ' ', COALESCE(billing_customer_city.value, ''))) as billing_address");
      $billingname = new Zend_Db_Expr("trim(concat(COALESCE(billing_customer_firstname.value, ''), ' ', COALESCE(billing_customer_lastname.value, ''))) as billing_name");
 
  	 
      $collection = Mage::getModel('stalaabo/contract')->getCollection();
      //die($collection->getTablePrefix('customer'));
      $collection->getSelect()
      	->join(array('product'=>$collection->getTable('catalog/product')),'product.entity_id=main_table.base_product_id','sku')
      	//->join(array('customer'=>$collection->getTable('customer/entity')),'customer.entity_id=main_table.customer_id',array())
      	->join(array('product_name'=>'catalog_product_entity_varchar'),'product_name.entity_id=product.entity_id AND product_name.attribute_id='.$eav->getIdByCode('catalog_product','name'),array('product_name'=>'value'))	
      	/*
      	->joinleft(array('company'=>'customer_address_entity_varchar'),'company.entity_id=main_table.billing_address_id AND company.attribute_id='.$eav->getIdByCode('customer_address','company'),array('company'=>'value'))
      	->joinleft(array('customer_company'=>'customer_address_entity_varchar'),'customer_company.entity_id=main_table.shipping_address_id AND customer_company.attribute_id='.$eav->getIdByCode('customer_address','company'),array('address_company'=>'value'))		
      	->joinleft(array('customer_firstname'=>'customer_address_entity_varchar'),'customer_firstname.entity_id=main_table.shipping_address_id AND customer_firstname.attribute_id='.$eav->getIdByCode('customer_address','firstname'),array('firstname'=>'value'))
      	->joinleft(array('customer_lastname'=>'customer_address_entity_varchar'),'customer_lastname.entity_id=main_table.shipping_address_id AND customer_lastname.attribute_id='.$eav->getIdByCode('customer_address','lastname'),array('lastname'=>'value'))
      	->joinleft(array('customer_street'=>'customer_address_entity_text'),'customer_street.entity_id=main_table.shipping_address_id AND customer_street.attribute_id='.$eav->getIdByCode('customer_address','street'),array('street'=>'value'))
      	->joinleft(array('customer_city'=>'customer_address_entity_varchar'),'customer_city.entity_id=main_table.shipping_address_id AND customer_city.attribute_id='.$eav->getIdByCode('customer_address','city'),array('city'=>'value'))
      	->joinleft(array('customer_postcode'=>'customer_address_entity_varchar'),'customer_postcode.entity_id=main_table.shipping_address_id AND customer_postcode.attribute_id='.$eav->getIdByCode('customer_address','postcode'),array('postcode'=>'value'))
      	*/
      	
      	->joinleft(array('shipping_customer_company'=>'customer_address_entity_varchar'),'shipping_customer_company.entity_id=main_table.shipping_address_id AND shipping_customer_company.attribute_id='.$eav->getIdByCode('customer_address','company'),array())
      	->joinleft(array('shipping_customer_company2'=>'customer_address_entity_varchar'),'shipping_customer_company2.entity_id=main_table.shipping_address_id AND shipping_customer_company2.attribute_id='.$eav->getIdByCode('customer_address','company2'),array())	
      	->joinleft(array('shipping_customer_company3'=>'customer_address_entity_varchar'),'shipping_customer_company3.entity_id=main_table.shipping_address_id AND shipping_customer_company3.attribute_id='.$eav->getIdByCode('customer_address','company3'),array())	
      	->joinleft(array('shipping_customer_firstname'=>'customer_address_entity_varchar'),'shipping_customer_firstname.entity_id=main_table.shipping_address_id AND shipping_customer_firstname.attribute_id='.$eav->getIdByCode('customer_address','firstname'),array('shipping_firstname'=>'value'))
      	->joinleft(array('shipping_customer_lastname'=>'customer_address_entity_varchar'),'shipping_customer_lastname.entity_id=main_table.shipping_address_id AND shipping_customer_lastname.attribute_id='.$eav->getIdByCode('customer_address','lastname'),array('shipping_lastname'=>'value'))
      	->joinleft(array('shipping_customer_street'=>'customer_address_entity_text'),'shipping_customer_street.entity_id=main_table.shipping_address_id AND shipping_customer_street.attribute_id='.$eav->getIdByCode('customer_address','street'),array('shipping_street'=>'value'))
      	->joinleft(array('shipping_customer_city'=>'customer_address_entity_varchar'),'shipping_customer_city.entity_id=main_table.shipping_address_id AND shipping_customer_city.attribute_id='.$eav->getIdByCode('customer_address','city'),array('shipping_city'=>'value'))
      	->joinleft(array('shipping_customer_postcode'=>'customer_address_entity_varchar'),'shipping_customer_postcode.entity_id=main_table.shipping_address_id AND shipping_customer_postcode.attribute_id='.$eav->getIdByCode('customer_address','postcode'),array('shipping_postcode'=>'value'))
      	
      	->joinleft(array('billing_customer_company'=>'customer_address_entity_varchar'),'billing_customer_company.entity_id=main_table.billing_address_id AND billing_customer_company.attribute_id='.$eav->getIdByCode('customer_address','company'),array())
      	->joinleft(array('billing_customer_company2'=>'customer_address_entity_varchar'),'billing_customer_company2.entity_id=main_table.billing_address_id AND billing_customer_company2.attribute_id='.$eav->getIdByCode('customer_address','company2'),array())	
      	->joinleft(array('billing_customer_company3'=>'customer_address_entity_varchar'),'billing_customer_company3.entity_id=main_table.billing_address_id AND billing_customer_company3.attribute_id='.$eav->getIdByCode('customer_address','company3'),array())	
      	->joinleft(array('billing_customer_firstname'=>'customer_address_entity_varchar'),'billing_customer_firstname.entity_id=main_table.billing_address_id AND billing_customer_firstname.attribute_id='.$eav->getIdByCode('customer_address','firstname'),array('billing_firstname'=>'value'))
      	->joinleft(array('billing_customer_lastname'=>'customer_address_entity_varchar'),'billing_customer_lastname.entity_id=main_table.billing_address_id AND billing_customer_lastname.attribute_id='.$eav->getIdByCode('customer_address','lastname'),array('billing_lastname'=>'value'))
      	->joinleft(array('billing_customer_street'=>'customer_address_entity_text'),'billing_customer_street.entity_id=main_table.billing_address_id AND billing_customer_street.attribute_id='.$eav->getIdByCode('customer_address','street'),array('billing_street'=>'value'))
      	->joinleft(array('billing_customer_city'=>'customer_address_entity_varchar'),'billing_customer_city.entity_id=main_table.billing_address_id AND billing_customer_city.attribute_id='.$eav->getIdByCode('customer_address','city'),array('billing_city'=>'value'))
      	->joinleft(array('billing_customer_postcode'=>'customer_address_entity_varchar'),'billing_customer_postcode.entity_id=main_table.billing_address_id AND billing_customer_postcode.attribute_id='.$eav->getIdByCode('customer_address','postcode'),array('billing_postcode'=>'value'))

      	->columns($shippingcompany)
      	->columns($billingcompany)
      	->columns($shippingaddress)
      	->columns($shippingname)
      	->columns($billingaddress)
      	->columns($billingname)

      	->where('is_deleted=0')
      	->distinct()
      	;
      	
     // Falls vom customerTab aufgerufen ist die custmer_id gesetzt
      if($this->getCustomerId())
      {
      	$collection->getSelect()->where('customer_id='.$this->getCustomerId());
      }
      //die($collection->getSelect()->__toString());
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('abo_contract_id', array(
          'header'    => Mage::helper('stalaabo')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'abo_contract_id',
      ));

      $this->addColumn('sku', array(
          'header'    => Mage::helper('stalaabo')->__('sku'),
          'align'     =>'left',
      	  'width'     => '150px',
          'index'     => 'sku',
      ));
      
     $this->addColumn('product', array(
          'header'    => Mage::helper('stalaabo')->__('Product Name'),
          'align'     =>'left',
          'index'     => 'product_name',
     	  'filter_index' => 'product_name.value'
      ));
      
     $this->addColumn('qty', array(
          'header'    => Mage::helper('stalaabo')->__('Qty'),
          'align'     =>'left',
     	  'width'     => '80px',
     	  'type' 	  => 'number',	
          'index'     => 'qty',
      ));
      
     if(!$this->getCustomerId())
     {
	     $this->addColumn('customer_id', array(
	          'header'    => Mage::helper('stalaabo')->__('Customer Id'),
	          'align'     => 'left',
	      	  'width'     => '30px',
		  	  'type' 	  => 'number',	
	          'index'     => 'customer_id',
	      ));
     }
 

      
        //Shipping Colums 
     $this->addColumn('shipping_company', array(
          'header'    => Mage::helper('stalaabo')->__('Shipping Company'),
          'align'     =>'left',
     	  //'width'     => '150px',
          'index'     => 'shipping_company',
     	  'filter_index'=> "concat(COALESCE(shipping_customer_company.value, ''), ' ', COALESCE(shipping_customer_company2.value, ''), ' ', COALESCE(shipping_customer_company3.value, ''))",
      ));

      
    $this->addColumn('shipping_name', array(
          'header'    => Mage::helper('stalaabo')->__('Shipping Name'),
          'align'     =>'left',
    	  'width'     => '150px',
          'index'     => 'shipping_name',
    	  'filter_index'=> "concat(COALESCE(shipping_customer_firstname.value, ''), ' ', COALESCE(shipping_customer_lastname.value, ''))",
      ));
      
       
      $this->addColumn('shipping_address', array(
          'header'    => Mage::helper('stalaabo')->__('Shipping Address'),
          'align'     =>'left',
     	  'width'     => '150px',
          'index'     => 'shipping_address',
          'filter_index'=> "concat(COALESCE(shipping_customer_street.value, ''), ' ', COALESCE(shipping_customer_city.value, ''), ' ', COALESCE(shipping_customer_postcode.value, ''))",
      ));
      
      
      //billing Columns
      
           $this->addColumn('billing_company', array(
          'header'    => Mage::helper('stalaabo')->__('Billing Company'),
          'align'     =>'left',
     	  //'width'     => '150px',
          'index'     => 'billing_company',
     	  'filter_index'=> "concat(COALESCE(billing_customer_company.value, ''), ' ', COALESCE(billing_customer_company2.value, ''), ' ', COALESCE(billing_customer_company3.value, ''))",
      ));

      
    $this->addColumn('billing_name', array(
          'header'    => Mage::helper('stalaabo')->__('Billing Name'),
          'align'     =>'left',
    	  'width'     => '150px',
          'index'     => 'billing_name',
    	  'filter_index'=> "concat(COALESCE(billing_customer_firstname.value, ''), ' ', COALESCE(billing_customer_lastname.value, ''))",
      ));
      
      
     $this->addColumn('billing_address', array(
          'header'    => Mage::helper('stalaabo')->__('Billing Address'),
          'align'     =>'left',
     	  'width'     => '150px',
          'index'     => 'billing_address',
     	  'filter_index'=> "concat(COALESCE(billing_customer_street.value, ''), ' ', COALESCE(billing_customer_city.value,''), ' ', COALESCE(billing_customer_postcode.value, ''))",
      ));   
      
      
      
      
      
    $this->addColumn('from_date', array(
          'header'    => Mage::helper('stalaabo')->__('Date From'),
          'align'     =>'left',
     	  'width'     => '80px',
    	  'type' 	=>'date',
          'index'     => 'from_date',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('abo')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
/*
      $this->addColumn('status', array(
          'header'    => Mage::helper('abo')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	*/  
      
      
       // Falls vom customerTab aufgerufen ist die custmer_id gesetzt
       //wg. return auswerten
      if($this->getCustomerId())
      {
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('stalaabo')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('stalaabo')->__('View'),
                        'url'       => array('base'=> '/adminhtml/stalaabo_contract/edit','params'=>array('origin'=>'customer','customer_id'=>$this->getCustomerId())),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        
      }
      else 
      {
      	  $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('stalaabo')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('stalaabo')->__('View'),
                        'url'       => array('base'=> '/adminhtml/stalaabo_contract/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
      }
		
		$this->addExportType('*/*/exportCsv', Mage::helper('stalaabo')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('stalaabo')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  
    public function getGridUrl()
    {
      // Falls vom customerTab aufgerufen ist die custmer_id gesetzt
      if($this->getCustomerId())
      {
      	return $this->getUrl('adminhtml/stalaabo_contract_customer/tabGrid',array('customer_id'=>$this->getCustomerId()));
      }
      
      return $this->getCurrentUrl();
    }


  public function getRowUrl($row)
  {
  	 if($this->getCustomerId())
     {
     	return $this->getUrl('adminhtml/stalaabo_contract/edit', array('id' => $row->getId(),'origin'=>'customer','customer_id'=>$this->getCustomerId()));
     }
     
     return $this->getUrl('adminhtml/stalaabo_contract/edit', array('id' => $row->getId()));
      
  }

}