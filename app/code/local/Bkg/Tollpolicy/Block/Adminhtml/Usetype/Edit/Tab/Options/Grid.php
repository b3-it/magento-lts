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
class Bkg_Tollpolicy_Block_Adminhtml_Usetype_Edit_Tab_Options_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_useId = 0;
  public function __construct()
  {
      parent::__construct();
      $this->setId('use_options_entityGrid');
      $this->setDefaultSort('use_options_entity_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->_useId = intval(Mage::registry('use_type_entity_data')->getId());
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkg_tollpolicy/useoptions')->getCollection();



      $collection->getSelect()
         ->where('use_type_id=?',$this->_useId)
           ;
//die($collection->getSelect()->__toString());
          $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('options_id', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      
      $this->addColumn('options_name', array(
      		'header'    => Mage::helper('bkg_tollpolicy')->__('Name'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'name',
      ));
      
      $this->addColumn('options_code', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('Code'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'code',
      ));
     
      $this->addColumn('options_userdefined', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('userdefined'),
          //'align'     =>'left',
          'width'     => '100px',
          'index'     => 'userdefined',
      ));
      $this->addColumn('options_is_default', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('is Default'),
          //'align'     =>'left',
          'width'     => '100px',
          'index'     => 'is_default',
      		'type'      => 'options',
      		'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
      ));
      $this->addColumn('options_is_calculable', array(
          'header'    => Mage::helper('bkg_tollpolicy')->__('is Calculable'),
          //'align'     =>'left',
          'width'     => '100px',
          'index'     => 'is_calculable',
      		'type'      => 'options',
      		'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
      ));



        $this->addColumn('options_action',
            array(
                'header'    =>  Mage::helper('bkg_tollpolicy')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('bkg_tollpolicy')->__('Edit'),
                        'url'       => array('base'=> '*/tollpolicy_useoptions/edit',array('useid'=>$this->_useId)),
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
      return $this->getUrl('*/tollpolicy_useoptions/edit', array('id' => $row->getId(),'useid'=>$this->_useId ));
  }

}
