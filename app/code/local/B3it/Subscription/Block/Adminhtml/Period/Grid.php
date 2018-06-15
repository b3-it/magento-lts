<?php
 /**
  *
  * @category   	B3it
  * @package    	B3it_Subscription
  * @name       	B3it_Subscription_Block_Adminhtml_Periodntity_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class B3it_Subscription_Block_Adminhtml_Period_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('components_format_entityGrid');
      $this->setDefaultSort('components_format_entity_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('b3it_subscription/period')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('b3it_subscription')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

    /*
      
      $this->addColumn('shortname', array(
      		'header'    => Mage::helper('b3it_subscription')->__('Shortname'),
      		//'align'     =>'left',
      		'width'     => '150px',
      		'index'     => 'shortname',
      ));
      */
      $this->addColumn('name', array(
      		'header'    => Mage::helper('b3it_subscription')->__('name'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'name',
      ));
      
      $this->addColumn('period_length', array(
      		'header'    => Mage::helper('b3it_subscription')->__('Period Length'),
      		//'align'     =>'left',
      		'width'     => '150px',
      		'index'     => 'period_length',
      ));
      
      
    
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('b3it_subscription')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('b3it_subscription')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('b3it_subscription')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('b3it_subscription')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('componentsformat_entity_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('b3it_subscription')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('b3it_subscription')->__('Are you sure?')
        ));

        return $this;
    }

	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/*', $params);

    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
