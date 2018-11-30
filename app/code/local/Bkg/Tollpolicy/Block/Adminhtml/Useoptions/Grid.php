<?php
 /**
  *
  * @category   	Bkg Tollpolicy
  * @package    	Bkg_Tollpolicy
  * @name       	Bkg_Tollpolicy_Block_Adminhtml_Useoptionsentity_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Tollpolicy_Block_Adminhtml_Useoptions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('use_options_entityGrid');
      $this->setDefaultSort('use_options_entity_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkg_tollpolicy/useoptions')->getCollection();

      $collection->getSelect()
          ->join(array('usetype'=>$collection->getTable('bkg_tollpolicy/use_type_entity')),'usetype.id= main_table.use_type_id',array('toll_id'))
          ->joinleft(array('usetype_label'=>$collection->getTable('bkg_tollpolicy/use_type_label')),'usetype.id= usetype_label.entity_id',array('usetype_label'=>'name'))
          ;
//die($collection->getSelect()->__toString());
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

      
      $this->addColumn('name', array(
      		'header'    => Mage::helper('bkg_tollpolicy')->__('Name'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'name',
      ));
      
      $this->addColumn('code', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('Code'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'code',
      ));
     
      $this->addColumn('userdefined', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('userdefined'),
          //'align'     =>'left',
          'width'     => '100px',
          'index'     => 'userdefined',
      ));
      $this->addColumn('is_default', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('is Default'),
          //'align'     =>'left',
          'width'     => '100px',
          'index'     => 'is_default',
      		'type'      => 'options',
      		'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
      ));
      $this->addColumn('is_calculable', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('is Calculable'),
          //'align'     =>'left',
          'width'     => '100px',
          'index'     => 'is_calculable',
      		'type'      => 'options',
      		'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
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


      $values = Mage::getModel('bkg_tollpolicy/usetype')->getCollection()->toOptionHash();
      $this->addColumn('use_type_id', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('Type of Use'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'usetype_label',
      	//	'type'      => 'options',
      //		'options'   => $values
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
        $this->getMassactionBlock()->setFormFieldName('use_options_entity_ids');

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
