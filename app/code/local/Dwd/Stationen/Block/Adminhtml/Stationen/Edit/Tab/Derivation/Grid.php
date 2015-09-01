<?php

class Dwd_Stationen_Block_Adminhtml_Stationen_Edit_Tab_Derivation_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_model = null;
  public function __construct()
  {
      parent::__construct();
      $this->setId('derivationGrid');
      //$this->setDefaultSort('set_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);

  }

  protected function _prepareCollection()
  {
  	 
  	$this->_model = Mage::registry('stationen_data');
  	if(!$this->_model)
  	{
  		$id = $this->getRequest()->getParam('id');
  		$this->_model  = Mage::getModel('stationen/stationen')->load($id);
  	}
      $collection = Mage::getModel('stationen/derivation')->getCollection();
      $collection->addAttributeToSelect('*')
      		->getSelect()
      		->where('parent_id='. $this->_model->getId())
      		//->columns(array('name_derivat'=>'name'))
      		;
      
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

 	protected function _afterLoadCollection()
    {
        foreach($this->getCollection()->getItems() as $item)
        {
        	$item->setNameDerivat($item->getName());
        }
        return $this;
    }
  
  protected function _prepareColumns()
  {
  	/*
      $this->addColumn('entity_id', array(
          'header'    => Mage::helper('stationen')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'entity_id',
      ));
*/
      $this->addColumn('name_derivat', array(
          'header'    => Mage::helper('stationen')->__('Name'),
          'align'     =>'left',
          'index'     => 'name_derivat',
      	'filter_index' => 'name'
      ));


       $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('stationen')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('stationen')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('stationen/adminhtml_derivation/exportCsv', Mage::helper('stationen')->__('CSV'));
		$this->addExportType('stationen/adminhtml_derivation/exportXml', Mage::helper('stationen')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('set_id');
        $this->getMassactionBlock()->setFormFieldName('set');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('stationen')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('stationen')->__('Are you sure?')
        ));

       
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/stationen_derivation/edit', array('id' => $row->getId()));
  }
  
	public function getGridUrl()
    {
         return $this->getUrl('*/stationen_derivation/grid',array('id'=>$this->_model->getId()));
    }

}