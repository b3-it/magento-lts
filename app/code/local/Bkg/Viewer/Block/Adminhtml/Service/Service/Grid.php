<?php
 /**
  *
  * @category   	Bkg Viewer
  * @package    	Bkg_Viewer
  * @name       	Bkg_Viewer_Block_Adminhtml_Service_Service_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Viewer_Block_Adminhtml_Service_Service_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('ServiceGrid');
      $this->setDefaultSort('service_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkgviewer/service_service')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('bkgviewer')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('bkgviewer')->__('Title'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'title',
      ));
      $this->addColumn('format', array(
          'header'    => Mage::helper('bkgviewer')->__('Format'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'format',
      ));
      $this->addColumn('url', array(
          'header'    => Mage::helper('bkgviewer')->__('Url'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'url',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('bkgviewer')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('bkgviewer')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('bkgviewer')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('bkgviewer')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('bkgviewer')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('bkgviewer')->__('Are you sure?')
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
