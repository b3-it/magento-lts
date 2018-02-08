<?php
 /**
  *
  * @category   	Bkg License
  * @package    	Bkg_License
  * @name       	Bkg_License_Block_Adminhtml_Master_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_License_Block_Adminhtml_Master_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('entityGrid');
      $this->setDefaultSort('entity_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkg_license/master')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('bkg_license')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('usetypeoption_id', array(
          'header'    => Mage::helper('bkg_license')->__('Nutzungsart'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'usetypeoption_id',
      ));
      $this->addColumn('customergroup_id', array(
          'header'    => Mage::helper('bkg_license')->__('Kundengruppe'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'customergroup_id',
      ));
      $this->addColumn('type', array(
          'header'    => Mage::helper('bkg_license')->__('Lizenztyp'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'type',
      ));
      $this->addColumn('reuse', array(
          'header'    => Mage::helper('bkg_license')->__('Nchnutzung'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'reuse',
      ));
      $this->addColumn('ident', array(
          'header'    => Mage::helper('bkg_license')->__('Lizenznummer'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'ident',
      ));
      $this->addColumn('name', array(
          'header'    => Mage::helper('bkg_license')->__('Name'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'name',
      ));
      $this->addColumn('date_from', array(
          'header'    => Mage::helper('bkg_license')->__('Anfangsdatum'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'date_from',
      ));
      $this->addColumn('date_to', array(
          'header'    => Mage::helper('bkg_license')->__('Enddatum'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'date_to',
      ));
      $this->addColumn('active', array(
          'header'    => Mage::helper('bkg_license')->__('Aktiv'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'active',
      ));
      $this->addColumn('consternation_check', array(
          'header'    => Mage::helper('bkg_license')->__('Betroffenheit prüfen'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'consternation_check',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('bkg_license')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('bkg_license')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('bkg_license')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('bkg_license')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('entity_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('bkg_license')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('bkg_license')->__('Are you sure?')
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
