<?php
 /**
  *
  * @category   	Bkg
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Regionallocation_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Regionallocation_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('components_regionallocationGrid');
      $this->setDefaultSort('components_regionallocation_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkg_virtualGeo/components_regionallocation')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('bkg_virtualGeo')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('parent_id', array(
          'header'    => Mage::helper('bkg_virtualGeo')->__('Parent Id'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'parent_id',
      ));
      $this->addColumn('rap_id', array(
          'header'    => Mage::helper('bkg_virtualGeo')->__(''),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'rap_id',
      ));
      $this->addColumn('fee', array(
          'header'    => Mage::helper('bkg_virtualGeo')->__(''),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'fee',
      ));
      $this->addColumn('usage', array(
          'header'    => Mage::helper('bkg_virtualGeo')->__(''),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'usage',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('bkg_virtualGeo')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('bkg_virtualGeo')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('bkg_virtualGeo')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('bkg_virtualGeo')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('componentsregionallocation_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('bkg_virtualGeo')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('bkg_virtualGeo')->__('Are you sure?')
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
