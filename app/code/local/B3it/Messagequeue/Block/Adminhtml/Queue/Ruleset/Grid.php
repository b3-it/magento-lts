<?php
 /**
  *
  * @category   	B3it Messagequeue
  * @package    	b3it_mq
  * @name       	B3it_Messagequeue_Block_Adminhtml_Queue_Ruleset_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class B3it_Messagequeue_Block_Adminhtml_Queue_Ruleset_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('queue_rulesetGrid');
      $this->setDefaultSort('queue_ruleset_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('b3it_mq/queue_ruleset')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('b3it_mq')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('b3it_mq')->__('Name'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'name',
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('b3it_mq')->__('Status'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'status',
      ));
      $this->addColumn('category', array(
          'header'    => Mage::helper('b3it_mq')->__('Category'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'category',
      ));
      $this->addColumn('recipients', array(
          'header'    => Mage::helper('b3it_mq')->__('Recipients'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'recipients',
      ));
      $this->addColumn('owner', array(
          'header'    => Mage::helper('b3it_mq')->__('Owner'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'owner',
      ));
      $this->addColumn('template', array(
          'header'    => Mage::helper('b3it_mq')->__('Template'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'template',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('b3it_mq')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('b3it_mq')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('b3it_mq')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('b3it_mq')->__('XML'));
    $this->addExportType('*/*/exportExcel', Mage::helper('b3it_mq')->__('XML (Excel)'));
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('queueruleset_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('b3it_mq')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('b3it_mq')->__('Are you sure?')
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
