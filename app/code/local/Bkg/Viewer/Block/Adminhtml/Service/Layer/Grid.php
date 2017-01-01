<?php
 /**
  *
  * @category   	Bkg Viewer
  * @package    	Bkg_Viewer
  * @name       	Bkg_Viewer_Block_Adminhtml_Service_Layer_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Viewer_Block_Adminhtml_Service_Layer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('Service\LayerGrid');
      $this->setDefaultSort('Service\Layer_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkgviewer/service_layer')->getCollection();
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
      $this->addColumn('name', array(
          'header'    => Mage::helper('bkgviewer')->__('Name'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'name',
      ));
      $this->addColumn('abstract', array(
          'header'    => Mage::helper('bkgviewer')->__('Abstract'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'abstract',
      ));
      $this->addColumn('crs', array(
          'header'    => Mage::helper('bkgviewer')->__('Georeference'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'crs',
      ));
      $this->addColumn('bb_west', array(
          'header'    => Mage::helper('bkgviewer')->__('Bounding Box West'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'bb_west',
      ));
      $this->addColumn('bb_east', array(
          'header'    => Mage::helper('bkgviewer')->__('Bounding Box East'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'bb_east',
      ));
      $this->addColumn('bb_south', array(
          'header'    => Mage::helper('bkgviewer')->__('Bounding Box South'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'bb_south',
      ));
      $this->addColumn('bb_north', array(
          'header'    => Mage::helper('bkgviewer')->__('Bounding Box North'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'bb_north',
      ));
      $this->addColumn('style', array(
          'header'    => Mage::helper('bkgviewer')->__('Style'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'style',
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
        $this->getMassactionBlock()->setFormFieldName('servicelayer_id');

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
