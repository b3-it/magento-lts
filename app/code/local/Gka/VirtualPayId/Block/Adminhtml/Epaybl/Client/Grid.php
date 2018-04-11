<?php
 /**
  *
  * @category   	Gka Virtualpayid
  * @package    	Gka_VirtualPayId
  * @name       	Gka_VirtualPayId_Block_Adminhtml_Epaybl_Client_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_VirtualPayId_Block_Adminhtml_Epaybl_Client_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('epaybl_clientGrid');
      $this->setDefaultSort('epaybl_client_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('virtualpayid/epaybl_client')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('virtualpayid')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('virtualpayid')->__('Title'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'title',
      ));
      $this->addColumn('client', array(
          'header'    => Mage::helper('virtualpayid')->__('Client'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'client',
      ));
      
      $this->addColumn('pay_operator', array(
      		'header'    => Mage::helper('virtualpayid')->__('Pay Operator'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'pay_operator',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('virtualpayid')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('virtualpayid')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('virtualpayid')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('virtualpayid')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('epayblclient_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('virtualpayid')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('virtualpayid')->__('Are you sure?')
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
