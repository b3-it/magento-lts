<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Service_Service_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Service_Service_Edit_Tab_Layer extends Mage_Adminhtml_Block_Widget_Grid
{
 
	public function __construct()
	{
		parent::__construct();
		$this->setId('ServiceLayerGrid');
		$this->setDefaultSort('layer_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	
	protected function _prepareCollection()
	{
		$service = Mage::registry('serviceservice_data');
		$collection = Mage::getModel('bkgviewer/service_layer')->getCollection();
		$collection->getSelect()->where('service_id='.intval($service->getId()));
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	
	protected function _prepareColumns()
	{
		$this->addColumn('layer_id', array(
				'header'    => Mage::helper('bkgviewer')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'id',
		));
	
		$this->addColumn('layer_title', array(
				'header'    => Mage::helper('bkgviewer')->__('Title'),
				//'align'     =>'left',
				//'width'     => '150px',
				'index'     => 'title',
		));
		$this->addColumn('layer_name', array(
				'header'    => Mage::helper('bkgviewer')->__('Name'),
				//'align'     =>'left',
				//'width'     => '150px',
				'index'     => 'name',
		));
		$this->addColumn('layer_abstract', array(
				'header'    => Mage::helper('bkgviewer')->__('Abstract'),
				//'align'     =>'left',
				//'width'     => '150px',
				'index'     => 'abstract',
		));
		$this->addColumn('layer_crs', array(
				'header'    => Mage::helper('bkgviewer')->__('Georeference'),
				//'align'     =>'left',
				//'width'     => '150px',
				'index'     => 'crs',
		));
		$this->addColumn('layer_bb_west', array(
				'header'    => Mage::helper('bkgviewer')->__('Bounding Box West'),
				//'align'     =>'left',
				//'width'     => '150px',
				'index'     => 'bb_west',
		));
		$this->addColumn('layer_bb_east', array(
				'header'    => Mage::helper('bkgviewer')->__('Bounding Box East'),
				//'align'     =>'left',
				//'width'     => '150px',
				'index'     => 'bb_east',
		));
		$this->addColumn('layer_bb_south', array(
				'header'    => Mage::helper('bkgviewer')->__('Bounding Box South'),
				//'align'     =>'left',
				//'width'     => '150px',
				'index'     => 'bb_south',
		));
		$this->addColumn('layer_bb_north', array(
				'header'    => Mage::helper('bkgviewer')->__('Bounding Box North'),
				//'align'     =>'left',
				//'width'     => '150px',
				'index'     => 'bb_north',
		));
		$this->addColumn('layer_style', array(
				'header'    => Mage::helper('bkgviewer')->__('Style'),
				//'align'     =>'left',
				//'width'     => '150px',
				'index'     => 'style',
		));
	
// 		$this->addColumn('action',
// 				array(
// 						'header'    =>  Mage::helper('bkgviewer')->__('Action'),
// 						'width'     => '100',
// 						'type'      => 'action',
// 						'getter'    => 'getId',
// 						'actions'   => array(
// 								array(
// 										'caption'   => Mage::helper('bkgviewer')->__('Edit'),
// 										'url'       => array('base'=> '*/*/edit'),
// 										'field'     => 'id'
// 								)
// 						),
// 						'filter'    => false,
// 						'sortable'  => false,
// 						'index'     => 'stores',
// 						'is_system' => true,
// 				));
	
// 		$this->addExportType('*/*/exportCsv', Mage::helper('bkgviewer')->__('CSV'));
// 		$this->addExportType('*/*/exportXml', Mage::helper('bkgviewer')->__('XML'));
	
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
		return $this->getUrl('*/*/layerGrid', $params);
	
	}
	
	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	
}
