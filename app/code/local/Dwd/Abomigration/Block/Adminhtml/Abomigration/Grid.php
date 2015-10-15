<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Dwd
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Dwd_Abomigration_Block_Adminhtml_Abomigration_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('abomigrationGrid');
      $this->setDefaultSort('abomigration_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('abomigration/abomigration')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  
	protected function _addColumnFilterToCollection($column) {
		if ($this->getCollection()) {
			if ($column->getId() == 'customer_informed_bool') 
			{
					            
	            if ($column->getFilter()->getValue()== '1') {
	                $this->getCollection()->getSelect()->where('customer_informed is not null');
	            }
	            else if ($column->getFilter()->getValue()== '0')
	            {
                    $this->getCollection()->getSelect()->where('customer_informed is null');
                
            	}
				return $this;
			}
			
		}

		return parent::_addColumnFilterToCollection($column);
	}
  
  protected function _prepareColumns()
  {
  	$helper = Mage::helper('abomigration');
      $this->addColumn('abomigration_id', array(
          'header'    => Mage::helper('abomigration')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'abomigration_id',
      ));

		$this->addColumn('customer_id', array(
				'header'    => $helper->__('Customer ID'),
				'align'     =>'left',
				'index'     => 'customer_id',
				'width'     => '150px',
		));
		$this->addColumn('address_id', array(
				'header'    => $helper->__('Address Id'),
				'align'     =>'left',
				'index'     => 'address_id',
				'width'     => '150px',
		));
		
		$yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
		$yesno = array();
		foreach ($yn as $n)
		{
			$yesno[$n['value']] = $n['label'];
		}
		
		
		$this->addColumn('create_customer', array(
				'header'    => $helper->__('Create Customer'),
				'align'     =>'left',
				'index'     => 'create_customer',
				'width'     => '150px',
				'type'      => 'options',
          		'options'   => $yesno
		));
		
		$this->addColumn('firstname', array(
				'header'    => $helper->__('firstname'),
				'align'     =>'left',
				'index'     => 'firstname',
				'width'     => '150px',
		));
		$this->addColumn('lastname', array(
				'header'    => $helper->__('lastname'),
				'align'     =>'left',
				'index'     => 'lastname',
				'width'     => '150px',
		));
		$this->addColumn('company1', array(
				'header'    => $helper->__('Company1'),
				'align'     =>'left',
				'index'     => 'company1',
				'width'     => '150px',
		));
		$this->addColumn('company2', array(
				'header'    => $helper->__('Company2'),
				'align'     =>'left',
				'index'     => 'company2',
				'width'     => '150px',
		));
		$this->addColumn('street', array(
				'header'    => $helper->__('Street'),
				'align'     =>'left',
				'index'     => 'street',
				'width'     => '150px',
		));
		
		$this->addColumn('telephone', array(
				'header'    => $helper->__('Telephone'),
				'align'     =>'left',
				'index'     => 'telephone',
				'width'     => '150px',
		));
		
		$this->addColumn('city', array(
				'header'    => $helper->__('City'),
				'align'     =>'left',
				'index'     => 'city',
				'width'     => '150px',
		));
		$this->addColumn('postcode', array(
				'header'    => $helper->__('Postcode'),
				'align'     =>'left',
				'index'     => 'postcode',
				'width'     => '150px',
		));
		$this->addColumn('country', array(
				'header'    => $helper->__('Country'),
				'align'     =>'left',
				'index'     => 'country',
				'width'     => '150px',
		));
		$this->addColumn('email', array(
				'header'    => $helper->__('Email'),
				'align'     =>'left',
				'index'     => 'email',
				'width'     => '150px',
		));
		
		$this->addColumn('pwd_shop', array(
				'header'    => $helper->__('Password Shop'),
				'align'     =>'left',
				'index'     => 'pwd_shop',
				'width'     => '150px',
				
		));
		
		$this->addColumn('pwd_shop_is_safe', array(
				'header'    => $helper->__('Password Shop is safe'),
				'align'     =>'left',
				'index'     => 'pwd_shop_is_safe',
				'width'     => '150px',
				'type'      => 'options',
				'options'   => $yesno
		));
		
		$this->addColumn('username_ldap', array(
				'header'    => $helper->__('Username Ldap'),
				'align'     =>'left',
				'index'     => 'username_ldap',
				'width'     => '150px',
		));
		
		$this->addColumn('pwd_ldap', array(
				'header'    => $helper->__('Password Ldap'),
				'align'     =>'left',
				'index'     => 'pwd_ldap',
				'width'     => '150px',
		));
		
		$this->addColumn('pwd_ldap_is_safe', array(
				'header'    => $helper->__('Password Ldap is safe'),
				'align'     =>'left',
				'index'     => 'pwd_ldap_is_safe',
				'width'     => '150px',
				'type'      => 'options',
				'options'   => $yesno
		));
		
		
		$this->addColumn('product_id', array(
				'header'    => $helper->__('Product'),
				'align'     =>'left',
				'index'     => 'product_id',
				'width'     => '150px',
				'type'		=> 'options',
				'options'	=> Mage::getSingleton('abomigration/system_config_source_products')->toOptionArray()
		));
		
		$collection= Mage::getModel('periode/periode')->getCollection();
		$perioden = array();
		foreach ($collection->getItems() as $p)
		{
			$perioden[$p->getId()] = $p->getLabel();
		}
		
		$this->addColumn('period_id', array(
				'header'    => $helper->__('Periode'),
				'align'     =>'left',
				'index'     => 'period_id',
				'width'     => '150px',
				'type'		=> 'options',
				'options'	=> $perioden,
		));
		
		
 		$collection = Mage::getModel('stationen/stationen')->getCollection();
		$stationen = array();
		foreach($collection->getItems() as $st)
		{
			$stationen[$st->getId()] = $st->getStationskennung();
		}
		
		$this->addColumn('station1', array(
				'header'    => $helper->__('Station 1'),
				'align'     =>'left',
				'index'     => 'station1',
				'width'     => '150px',
				'type'      => 'options',
				'options'   => $stationen
		));
		
		$this->addColumn('station2', array(
				'header'    => $helper->__('Station 2'),
				'align'     =>'left',
				'index'     => 'station2',
				'width'     => '150px',
				'type'      => 'options',
				'options'   => $stationen
		));
		
		$this->addColumn('station3', array(
				'header'    => $helper->__('Station 3'),
				'align'     =>'left',
				'index'     => 'station3',
				'width'     => '150px',
				'type'      => 'options',
				'options'   => $stationen
		));
		
		$this->addColumn('period_end', array(
				'header'    => $helper->__('Period End'),
				'align'     =>'left',
				'index'     => 'period_end',
				'width'     => '150px',
				'type'		=> 'date'
		));
		$this->addColumn('customer_informed', array(
				'header'    => $helper->__('Customer informed at'),
				'align'     =>'left',
				'index'     => 'customer_informed',
				'width'     => '150px',
				'type'		=> 'date'
		));
		
		$this->addColumn('customer_informed_bool', array(
				'header'    => $helper->__('Customer informed'),
				'align'     =>'left',
				'index'     => 'customer_informed_bool',
				'width'     => '100px',
				'type'      => 'options',
				'options'   => $yesno
		));
		/*
		$this->addColumn('created_time', array(
				'header'    => $helper->__('created_time'),
				'align'     =>'left',
				'index'     => 'created_time',
				'width'     => '150px',
		));
		$this->addColumn('update_time', array(
				'header'    => $helper->__('update_time'),
				'align'     =>'left',
				'index'     => 'update_time',
				'width'     => '150px',
		));
		*/
		
		$this->addColumn('order_id', array(
				'header'    => $helper->__('Order Id'),
				'align'     =>'left',
				'index'     => 'order_id',
				'width'     => '150px',
		));
		
		$this->addColumn('error', array(
				'header'    => $helper->__('Error'),
				'align'     =>'left',
				'index'     => 'error',
				'width'     => '150px',
				'type'		=> 'options',
				'options' 	=> $yesno,
		));
		
		$this->addColumn('error_text', array(
				'header'    => $helper->__('Error Text'),
				'align'     =>'left',
				'index'     => 'error_text',
				'width'     => '150px',
		));

		/*
      $this->addColumn('status', array(
          'header'    => Mage::helper('abomigration')->__('Status'),
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
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('abomigration')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('abomigration')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('abomigration')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('abomigration')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('abomigration_id');
        $this->getMassactionBlock()->setFormFieldName('abomigration');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('abomigration')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('abomigration')->__('Delete: Are you sure?')
        ));
        
        $this->getMassactionBlock()->addItem('inform', array(
        		'label'    => Mage::helper('abomigration')->__('Customer informed'),
        		'url'      => $this->getUrl('*/*/massInform'),
        		
        ));
        
        $this->getMassactionBlock()->addItem('create', array(
        		'label'    => Mage::helper('abomigration')->__('Create Customer Account'),
        		'url'      => $this->getUrl('*/*/massCreate'),
        
        ));

      
        return $this;
    }

    
    protected function _afterLoadCollection()
    {
    	foreach ($this->getCollection()->getItems() as $item)
    	{
    		$b = $item->getData('customer_informed');
    		if($b != null)
    		{
    			$item->setData('customer_informed_bool', 1);
    		}else {
    			$item->setData('customer_informed_bool', 0);
    		}
    		
    	}
    }   
    
  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}