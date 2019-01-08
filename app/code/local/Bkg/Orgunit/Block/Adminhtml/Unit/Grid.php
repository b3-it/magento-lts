<?php
 /**
  *
  * @category   	Bkg Orgunit
  * @package    	Bkg_Orgunit
  * @name       	Bkg_Orgunit_Block_Adminhtml_Unit_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Orgunit_Block_Adminhtml_Unit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('unitGrid');
      $this->setDefaultSort('unit_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkg_orgunit/unit')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('bkg_orgunit')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('shortname', array(
          'header'    => Mage::helper('bkg_orgunit')->__('Kurzname'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'shortname',
      ));
      $this->addColumn('name', array(
          'header'    => Mage::helper('bkg_orgunit')->__('Name'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'name',
      ));
      $this->addColumn('line', array(
          'header'    => Mage::helper('bkg_orgunit')->__('Branche'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'line',
      ));
      $this->addColumn('note', array(
          'header'    => Mage::helper('bkg_orgunit')->__('Bemerkung'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'note',
      ));
      
      
      $collection = Mage::getModel('bkg_orgunit/unit')->getCollection();
      $orgs = array();
      
      foreach($collection as $item)
      {
      	  $orgs[$item->getId()] = $item->getShortname();
      }
      
      $this->addColumn('parent_id', array(
          'header'    => Mage::helper('bkg_orgunit')->__('Übergeordnete Organisation'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'parent_id',
      		'type' => 'options',
      		'options'=>$orgs
      ));

     
      
      
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('bkg_orgunit')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('bkg_orgunit')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('bkg_orgunit')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('bkg_orgunit')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('unit_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('bkg_orgunit')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('bkg_orgunit')->__('Are you sure?')
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
