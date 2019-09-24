<?php

class B3it_Maintenance_Block_Adminhtml_Offline_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('maintenance');
		$this->setDefaultSort('id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		 
		$exp = new Zend_Db_Expr('(SELECT increment_id from sales_flat_order where sales_flat_order.entity_id=main_table.first_order_id) as first_order_increment_id');
		 
		$collection = Mage::getModel('maintenance/offline')->getCollection();
		
		$expr = new Zend_Db_Expr('datediff(on_time,off_time)');
		$exprH = new Zend_Db_Expr('hour(timediff(on_time,off_time))');
		$collection->getSelect()->columns(array('duration'=>$expr));
		$collection->getSelect()->columns(array('dhours'=>$exprH));
		
		//die($collection->getSelect()->__toString());
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('id', array(
				'header'    => Mage::helper('b3it_maintenance')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'id',
		));


		
		 $this->addColumn('website', array(
		 		'header'    => Mage::helper('b3it_maintenance')->__('Website'),
		 		'align'     =>'left',
		 		'index'     => 'website',
		 		'width'     => '50px',
		 ));

		 $this->addColumn('store', array(
		 		'header'    => Mage::helper('b3it_maintenance')->__('Store'),
		 		'align'     =>'left',
		 		'index'     => 'store',
		 		'width'     => '50px',
		 ));
		 
		 $this->addColumn('off_time', array(
		 		'header'    => Mage::helper('b3it_maintenance')->__('Off Time'),
		 		'align'     =>'left',
		 		'index'     => 'off_time',
		 		'width'     => '150px',
		 ));
		 
		 $this->addColumn('on_time', array(
		 		'header'    => Mage::helper('b3it_maintenance')->__('On Time'),
		 		'align'     =>'left',
		 		'index'     => 'on_time',
		 		'width'     => '150px',
		 ));
		 
		 $this->addColumn('dhours', array(
		 		'header'    => Mage::helper('b3it_maintenance')->__('Duration Hours'),
		 		'align'     =>'left',
		 		'index'     => 'dhours',
		 		'width'     => '150px',
		 ));
		 
		 $this->addColumn('duration', array(
		 		'header'    => Mage::helper('b3it_maintenance')->__('Duration Days'),
		 		'align'     =>'left',
		 		'index'     => 'duration',
		 		'width'     => '150px',
		 ));

        $this->addColumn('user', array(
            'header'    => Mage::helper('b3it_maintenance')->__('User'),
            'align'     =>'left',
            'index'     => 'user',
            'width'     => '150px',
        ));
		
	
		 
		return parent::_prepareColumns();
	}

	

	

}