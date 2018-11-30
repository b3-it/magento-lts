<?php
 /**
  *
  * @category   	Bkg Tollpolicy
  * @package    	Bkg_Tollpolicy
  * @name       	Bkg_Tollpolicy_Block_Adminhtml_Usetypeentity_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Tollpolicy_Block_Adminhtml_Usetype_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('use_type_entityGrid');
      $this->setDefaultSort('use_type_entity_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
    
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkg_tollpolicy/usetype')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $values = Mage::getModel('bkg_tollpolicy/toll')->getCollection()->toOptionHash();
      $this->addColumn('toll_id', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('Toll'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'toll_id',
          'type'      => 'options',
          'options'   => $values
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('Name'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'name',
      ));
      $this->addColumn('internal', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('Internal'),
          //'align'     =>'left',
          'width'     => '100px',
          'index'     => 'internal',
          'type'      => 'options',
          'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
      ));
      
      $this->addColumn('external', array(
      		'header'    => Mage::helper('bkg_tollpolicy')->__('External'),
      		//'align'     =>'left',
      		'width'     => '100px',
      		'index'     => 'external',
      		'type'      => 'options',
      		'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
      ));
      
      $this->addColumn('active', array(
      		'header'    => Mage::helper('bkg_tollpolicy')->__('Active'),
      		//'align'     =>'left',
      		'width'     => '100px',
      		'index'     => 'active',
      		'type'      => 'options',
      		'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
      ));
//       $this->addColumn('internal', array(
//           'header'    => Mage::helper('bkg_tollpolicy')->__('internal'),
//           //'align'     =>'left',
//           //'width'     => '150px',
//           'index'     => 'internal',
//       ));
//       $this->addColumn('external', array(
//           'header'    => Mage::helper('bkg_tollpolicy')->__('external'),
//           //'align'     =>'left',
//           //'width'     => '150px',
//           'index'     => 'external',
//       ));
      $this->addColumn('code', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('Code'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'code',
      ));
     
//       $this->addColumn('is_default', array(
//           'header'    => Mage::helper('bkg_tollpolicy')->__(''),
//           //'align'     =>'left',
//           //'width'     => '150px',
//           'index'     => 'is_default',
//       ));
      

      $this->addColumn('pos', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('Pos'),
          //'align'     =>'left',
          'width'     => '100px',
          'index'     => 'pos',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('bkg_tollpolicy')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('bkg_tollpolicy')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('bkg_tollpolicy')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('bkg_tollpolicy')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('use_type_entity_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('bkg_tollpolicy')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('bkg_tollpolicy')->__('Are you sure?')
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
