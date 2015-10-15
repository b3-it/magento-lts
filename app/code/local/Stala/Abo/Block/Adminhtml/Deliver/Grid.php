<?php

class Stala_Abo_Block_Adminhtml_Deliver_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('deliverGrid');
      $this->setDefaultSort('abo_deliver_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('stalaabo/deliver')->getCollection();
      
      $shippingcompany = new Zend_Db_Expr("trim(concat(COALESCE(shipping_customer_company.value, ''),' ', COALESCE(shipping_customer_company2.value, ''), ' ', COALESCE(shipping_customer_company3.value, ''))) as shipping_company");
      $billingcompany = new Zend_Db_Expr("trim(concat(COALESCE(billing_customer_company.value, ''), ' ', COALESCE(billing_customer_company2.value, ''), ' ', COALESCE(billing_customer_company3.value, ''))) as billing_company");
      
      $shippingaddress = new Zend_Db_Expr("trim(concat(COALESCE(shipping_customer_street.value, ''), ' ', COALESCE(shipping_customer_city.value, ''), ' ', COALESCE(shipping_customer_postcode.value, ''))) as shipping_address");
      $shippingname = new Zend_Db_Expr("trim(concat(COALESCE(shipping_customer_firstname.value, ''), ' ', COALESCE(shipping_customer_lastname.value, ''))) as shipping_name");
      
      $billingaddress = new Zend_Db_Expr("trim(concat(COALESCE(billing_customer_street.value, ''), ' ', COALESCE(billing_customer_city.value, ''), ' ', COALESCE(billing_customer_postcode.value, ''))) as billing_address");
      $billingname = new Zend_Db_Expr("trim(concat(COALESCE(billing_customer_firstname.value, ''), ' ', COALESCE(billing_customer_lastname.value, ''))) as billing_name");
      
      $eav = Mage::getResourceModel('eav/entity_attribute');
      
      $collection->getSelect()
      	->join(array('product'=>$collection->getTable('catalog/product')),'main_table.product_id=product.entity_id','sku')
      	/*
      	//->join(array('product_name'=>'catalog_product_entity_varchar'),'product_name.entity_id=product.entity_id AND product_name.attribute_id='.$eav->getIdByCode('catalog_product','name'),array('product_name'=>'value'))	
      	->joinleft(array('customer_company'=>'customer_address_entity_varchar'),'customer_company.entity_id=contract.shipping_address_id AND customer_company.attribute_id='.$eav->getIdByCode('customer_address','company'),array('company'=>'value'))	
      	->joinleft(array('customer_firstname'=>'customer_address_entity_varchar'),'customer_firstname.entity_id=contract.shipping_address_id AND customer_firstname.attribute_id='.$eav->getIdByCode('customer_address','firstname'),array('firstname'=>'value'))
      	->joinleft(array('customer_lastname'=>'customer_address_entity_varchar'),'customer_lastname.entity_id=contract.shipping_address_id AND customer_lastname.attribute_id='.$eav->getIdByCode('customer_address','lastname'),array('lastname'=>'value'))
      	->joinleft(array('customer_street'=>'customer_address_entity_text'),'customer_street.entity_id=contract.shipping_address_id AND customer_street.attribute_id='.$eav->getIdByCode('customer_address','street'),array('street'=>'value'))
      	->joinleft(array('customer_city'=>'customer_address_entity_varchar'),'customer_city.entity_id=contract.shipping_address_id AND customer_city.attribute_id='.$eav->getIdByCode('customer_address','city'),array('city'=>'value'))
      	->joinleft(array('customer_postcode'=>'customer_address_entity_varchar'),'customer_postcode.entity_id=contract.shipping_address_id AND customer_postcode.attribute_id='.$eav->getIdByCode('customer_address','postcode'),array('postcode'=>'value'))
      	*/
      	
      	->joinleft(array('shipping_customer_company'=>'customer_address_entity_varchar'),'shipping_customer_company.entity_id=contract.shipping_address_id AND shipping_customer_company.attribute_id='.$eav->getIdByCode('customer_address','company'),array())
      	->joinleft(array('shipping_customer_company2'=>'customer_address_entity_varchar'),'shipping_customer_company2.entity_id=contract.shipping_address_id AND shipping_customer_company2.attribute_id='.$eav->getIdByCode('customer_address','company2'),array())	
      	->joinleft(array('shipping_customer_company3'=>'customer_address_entity_varchar'),'shipping_customer_company3.entity_id=contract.shipping_address_id AND shipping_customer_company3.attribute_id='.$eav->getIdByCode('customer_address','company3'),array())	
      	->joinleft(array('shipping_customer_firstname'=>'customer_address_entity_varchar'),'shipping_customer_firstname.entity_id=contract.shipping_address_id AND shipping_customer_firstname.attribute_id='.$eav->getIdByCode('customer_address','firstname'),array('shipping_firstname'=>'value'))
      	->joinleft(array('shipping_customer_lastname'=>'customer_address_entity_varchar'),'shipping_customer_lastname.entity_id=contract.shipping_address_id AND shipping_customer_lastname.attribute_id='.$eav->getIdByCode('customer_address','lastname'),array('shipping_lastname'=>'value'))
      	->joinleft(array('shipping_customer_street'=>'customer_address_entity_text'),'shipping_customer_street.entity_id=contract.shipping_address_id AND shipping_customer_street.attribute_id='.$eav->getIdByCode('customer_address','street'),array('shipping_street'=>'value'))
      	->joinleft(array('shipping_customer_city'=>'customer_address_entity_varchar'),'shipping_customer_city.entity_id=contract.shipping_address_id AND shipping_customer_city.attribute_id='.$eav->getIdByCode('customer_address','city'),array('shipping_city'=>'value'))
      	->joinleft(array('shipping_customer_postcode'=>'customer_address_entity_varchar'),'shipping_customer_postcode.entity_id=contract.shipping_address_id AND shipping_customer_postcode.attribute_id='.$eav->getIdByCode('customer_address','postcode'),array('shipping_postcode'=>'value'))
      	
      	->joinleft(array('billing_customer_company'=>'customer_address_entity_varchar'),'billing_customer_company.entity_id=contract.billing_address_id AND billing_customer_company.attribute_id='.$eav->getIdByCode('customer_address','company'),array())
      	->joinleft(array('billing_customer_company2'=>'customer_address_entity_varchar'),'billing_customer_company2.entity_id=contract.billing_address_id AND billing_customer_company2.attribute_id='.$eav->getIdByCode('customer_address','company2'),array())	
      	->joinleft(array('billing_customer_company3'=>'customer_address_entity_varchar'),'billing_customer_company3.entity_id=contract.billing_address_id AND billing_customer_company3.attribute_id='.$eav->getIdByCode('customer_address','company3'),array())	
      	->joinleft(array('billing_customer_firstname'=>'customer_address_entity_varchar'),'billing_customer_firstname.entity_id=contract.billing_address_id AND billing_customer_firstname.attribute_id='.$eav->getIdByCode('customer_address','firstname'),array('billing_firstname'=>'value'))
      	->joinleft(array('billing_customer_lastname'=>'customer_address_entity_varchar'),'billing_customer_lastname.entity_id=contract.billing_address_id AND billing_customer_lastname.attribute_id='.$eav->getIdByCode('customer_address','lastname'),array('billing_lastname'=>'value'))
      	->joinleft(array('billing_customer_street'=>'customer_address_entity_text'),'billing_customer_street.entity_id=contract.billing_address_id AND billing_customer_street.attribute_id='.$eav->getIdByCode('customer_address','street'),array('billing_street'=>'value'))
      	->joinleft(array('billing_customer_city'=>'customer_address_entity_varchar'),'billing_customer_city.entity_id=contract.billing_address_id AND billing_customer_city.attribute_id='.$eav->getIdByCode('customer_address','city'),array('billing_city'=>'value'))
      	->joinleft(array('billing_customer_postcode'=>'customer_address_entity_varchar'),'billing_customer_postcode.entity_id=contract.billing_address_id AND billing_customer_postcode.attribute_id='.$eav->getIdByCode('customer_address','postcode'),array('billing_postcode'=>'value'))
      	
      	->columns($shippingcompany)
      	->columns($billingcompany)
      	->columns($shippingaddress)
      	->columns($shippingname)
      	->columns($billingaddress)
      	->columns($billingname)
      	//->columns('abo_deliver_id as deliver_id')
      	
      	->where('is_deleted=0')
      	->distinct()
      	
      	;
      
      $this->setCollection($collection);
 //	die($collection->getSelect()->__toString());
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  /*
      $this->addColumn('abo_deliver_id', array(
          'header'    => Mage::helper('stalaabo')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'abo_deliver_id',
      ));
*/
      $this->addColumn('sku', array(
          'header'    => Mage::helper('stalaabo')->__('Sku'),
          'align'     =>'left',
      	  'width'     => '150px',
          'index'     => 'sku',
      ));
      
	  $this->addColumn('contract_qty', array(
          'header'    => Mage::helper('stalaabo')->__('Qty'),
          'align'     => 'left',
      	  'width'     => '30px',
	  	  'type' 	  => 'number',	
          'index'     => 'contract_qty',
      ));

     $this->addColumn('customer_id', array(
          'header'    => Mage::helper('stalaabo')->__('Customer Id'),
          'align'     => 'left',
      	  'width'     => '30px',
	  	  'type' 	  => 'number',	
          'index'     => 'customer_id',
      ));

      /*
     $this->addColumn('company', array(
          'header'    => Mage::helper('stalaabo')->__('Company'),
          'align'     =>'left',
     	  //'width'     => '150px',
          'index'     => 'company',
      'filter_index'=> 'customer_company.value',
      ));

      
    $this->addColumn('firstname', array(
          'header'    => Mage::helper('stalaabo')->__('First Name'),
          'align'     =>'left',
    	  'width'     => '150px',
          'index'     => 'firstname',
     'filter_index'=> 'customer_firstname.value',
      ));
      
      
     $this->addColumn('lastname', array(
          'header'    => Mage::helper('stalaabo')->__('Last Name'),
          'align'     =>'left',
     	  'width'     => '150px',
          'index'     => 'lastname',
      'filter_index'=> 'customer_lastname.value',
      ));
      
      $this->addColumn('street', array(
          'header'    => Mage::helper('stalaabo')->__('Street'),
          'align'     =>'left',
     	  'width'     => '150px',
          'index'     => 'street',
      	  'filter_index'=> 'customer_street.value',
      ));
      
      $this->addColumn('city', array(
          'header'    => Mage::helper('stalaabo')->__('City'),
          'align'     =>'left',
     	  'width'     => '120px',
          'index'     => 'city',
       'filter_index'=> 'customer_city.value',
      ));
      
      $this->addColumn('postcode', array(
          'header'    => Mage::helper('stalaabo')->__('Postcode'),
          'align'     =>'left',
     	  'width'     => '30px',
          'index'     => 'postcode',
       'filter_index'=> 'customer_postcode.value',
      ));
      
      */
      
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
    	  'filter_index'=> "concat(COALESCE(billing_customer_firstname.value, ''),' ', COALESCE(billing_customer_lastname.value, ''))",
      ));
      
      
     $this->addColumn('billing_address', array(
          'header'    => Mage::helper('stalaabo')->__('Billing Address'),
          'align'     =>'left',
     	  'width'     => '150px',
          'index'     => 'billing_address',
     	  'filter_index'=> "concat(COALESCE(billing_customer_street.value, ''), ' ', COALESCE(billing_customer_city.value, ''), ' ', COALESCE(billing_customer_postcode.value, ''))",
      ));
      
      
      
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('stalaabo')->__('Action'),
                'width'     => '50',
                'type'      => 'action',
                'getter'    => 'getAboContractId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('stalaabo')->__('View'),
                        'url'       => array('base'=> '/adminhtml/stalaabo_contract/edit','params'=>array('origin'=>'deliver')),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('stalaabo')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('stalaabo')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('abo_deliver_id');
        $this->getMassactionBlock()->setFormFieldName('abo_deliver_id');

        $this->getMassactionBlock()->addItem('shipping', array(
             'label'    => Mage::helper('stalaabo')->__('Shipping'),
             'url'      => $this->getUrl('adminhtml/stalaabo_deliverpost/'),
        	// 'complete' =>  "setLocation('".$this->getUrl('*/*/*')."');", 
        	//'useajax'	=> true,	
        	//'onclick'	=> 'setLocation()'
             //'confirm'  => Mage::helper('stalaabo')->__('Are you sure?')
        ));
        
        return $this;
    }

    public function getGridUrl()
    {
    	 return $this->getUrl('*/*/grid');
    }
    
  public function getRowUrl($row)
  {
      return $this->getUrl('adminhtml/stalaabo_contract/edit', array('id' => $row->getAboContractId(),'origin'=>'deliver'));
  }
  

}