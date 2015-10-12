<?php

class Slpb_Extstock_Block_Adminhtml_Stock_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


	
	public function __construct($attributes)
	{
		parent::__construct();
		$this->setId('extstockGrid');
		//$this->setDefaultSort('date_ordered');
		$this->setDefaultDir('DESC');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);

	}

  
	

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('extstock/stock_collection');
		$this->setCollection($collection);
		return parent::_prepareCollection();		
	}
	
	protected function _prepareColumns()
	{
		$this->addColumn('stock_id', array(
	          'header'  => Mage::helper('extstock')->__('ID'),
	          'align'   =>'right',
	          'width'   => '30px',
			  'type'	=> 'text',
	          'index'   => 'stock_id',
			  
			));
		
		$this->addColumn('name', array(
	          'header'  => Mage::helper('extstock')->__('Name'),
	          //'align'   =>'right',
	          //'width'   => '30px',
			  'type'	=> 'text',
	          'index'   => 'name',
			  
			));
		
		$this->addColumn('type', array(
	          'header'  => Mage::helper('extstock')->__('Typ'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'options',
			  'options' => Slpb_Extstock_Model_Stock::getTypeOptionsArray(),
	          'index'   => 'type',
			  
			));
	
		$this->addColumn('action',
            array(
                'header'    => Mage::helper('catalog')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('catalog')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit',
                            //'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                //'index'     => 'stores',
        ));	

		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{

		return $this;
	}

	public function getThisUrl($action)
	{
		return 'extstock/adminhtml_stock/'.$action;
	}
	
	/**
	 * Wichtig für Ajax
	 */ 
	public function getGridUrl()
    {
        return $this->getUrl('adminhtml/extstock_stock/grid', array('_current'=>true));
    }

    //damit kann nicht auf die Zeile geklickt werden!
    //weil dort das popup nicht funktioniert
	public function getRowUrl($row)
	{
		
		//return "popWin('".$this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()))."', 'windth=800,height=700,resizable=1,scrollbars=1');return false;";
		
		//if($this->_isStockMode())
		{
			return $this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()));
		}
		return "";
	}


}