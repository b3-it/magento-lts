<?php
 /**
  *
  * @category   	Bkg
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Storageentity_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Storage_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('components_storage_entityGrid');
      $this->setDefaultSort('components_storage_entity_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('virtualgeo/components_storage')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('virtualgeo')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('code', array(
          'header'    => Mage::helper('virtualgeo')->__('Code'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'code',
      ));
      
      $this->addColumn('shortname', array(
      		'header'    => Mage::helper('virtualgeo')->__('Shortname'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'shortname',
      ));
      
      $this->addColumn('name', array(
      		'header'    => Mage::helper('virtualgeo')->__('name'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'name',
      ));
      
      $this->addColumn('description', array(
      		'header'    => Mage::helper('virtualgeo')->__('Description'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'description',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('virtualgeo')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('virtualgeo')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('virtualgeo')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('virtualgeo')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('componentsstorage_entity_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('virtualgeo')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('virtualgeo')->__('Are you sure?')
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
