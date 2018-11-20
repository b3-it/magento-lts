<?php
 /**
  *
  * @category   	B3it Ids
  * @package    	B3it_Ids
  * @name       	B3it_Ids_Block_Adminhtml_Dos_Url_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class B3it_Ids_Block_Adminhtml_Dos_Url_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('dos_urlGrid');
      $this->setDefaultSort('dos_url_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('b3it_ids/dos_url')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('b3it_ids')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('url', array(
          'header'    => Mage::helper('b3it_ids')->__('Url'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'url',
      ));
      $this->addColumn('delay', array(
          'header'    => Mage::helper('b3it_ids')->__('Delay'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'delay',
      ));
      $this->addColumn('action', array(
          'header'    => Mage::helper('b3it_ids')->__('Action'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'action',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('b3it_ids')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('b3it_ids')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('b3it_ids')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('b3it_ids')->__('XML'));
    $this->addExportType('*/*/exportExcel', Mage::helper('b3it_ids')->__('XML (Excel)'));
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('dosurl_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('b3it_ids')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('b3it_ids')->__('Are you sure?')
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
