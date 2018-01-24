<?php
 /**
  *
  * @category   	Bkg Tollpolicy
  * @package    	Bkg_Tollpolicy
  * @name       	Bkg_Tollpolicy_Block_Adminhtml_Tollcategory_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Tollpolicy_Block_Adminhtml_Tollcategory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('toll_categoryGrid');
      $this->setDefaultSort('toll_category_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkg_tollpolicy/tollcategory')->getCollection();
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
//       $this->addColumn('customer_group_id', array(
//           'header'    => Mage::helper('bkg_tollpolicy')->__('Customer Group'),
//           //'align'     =>'left',
//           //'width'     => '150px',
//           'index'     => 'customer_group_id',
//       ));

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
        $this->getMassactionBlock()->setFormFieldName('toll_category_ids');

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
