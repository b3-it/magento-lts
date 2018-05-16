<?php
 /**
  *
  * @category   	B3it Messagequeue
  * @package    	b3it_mq
  * @name       	B3it_Messagequeue_Block_Adminhtml_Queue_Message_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class B3it_Messagequeue_Block_Adminhtml_Queue_Message_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('queue_messageGrid');
      $this->setDefaultSort('queue_message_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('b3it_mq/queue_message')->getCollection();
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

      $this->addColumn('ruleset_id', array(
          'header'    => Mage::helper('b3it_mq')->__('Rule'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'ruleset_id',
      ));
      $this->addColumn('owner', array(
          'header'    => Mage::helper('b3it_mq')->__('Owner'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'owner',
      ));
      $this->addColumn('text', array(
          'header'    => Mage::helper('b3it_mq')->__('Text'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'text',
      ));
      $this->addColumn('recipients', array(
          'header'    => Mage::helper('b3it_mq')->__('Recipients'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'recipients',
      ));
      $this->addColumn('created_at', array(
          'header'    => Mage::helper('b3it_mq')->__('Created At'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'created_at',
      ));
      $this->addColumn('event', array(
          'header'    => Mage::helper('b3it_mq')->__('Event'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'event',
      ));
      $this->addColumn('category', array(
          'header'    => Mage::helper('b3it_mq')->__('Category'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'category',
      ));
      $this->addColumn('processed_at', array(
          'header'    => Mage::helper('b3it_mq')->__('Processed At'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'processed_at',
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
        $this->getMassactionBlock()->setFormFieldName('queuemessage_ids');

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
