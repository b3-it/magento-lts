<?php
 /**
  *
  * @category   	Bkg Regionallocation
  * @package    	Bkg_Regionallocation
  * @name       	Bkg_Regionallocation_Block_Adminhtml_Koenigsteinerschluessel_Kstvalue_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_RegionAllocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tab_Kstvalue_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('koenigsteinerschluessel_kst_valueGrid');
      $this->setDefaultSort('koenigsteinerschluessel_kst_value_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
  	$kst =	Mage::registry('koenigsteinerschluesselkst_data');
      $collection = Mage::getModel('regionallocation/koenigsteinerschluessel_kstvalue')->getCollection();
      $collection->getSelect()->where('kst_id=?',intval($kst->getId()));
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('regionallocation')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

     
      $this->addColumn('region', array(
          'header'    => Mage::helper('regionallocation')->__('Region'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'region',
      ));
      $this->addColumn('has_tax', array(
          'header'    => Mage::helper('regionallocation')->__('Has Tax'),
          //'align'     =>'left',
          'width'     => '150px',
          'index'     => 'has_tax',
      ));
      $this->addColumn('portion', array(
          'header'    => Mage::helper('regionallocation')->__('Portion'),
          //'align'     =>'left',
          'width'     => '150px',
          'index'     => 'portion',
      ));
      $kst =	Mage::registry('koenigsteinerschluesselkst_data');
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('regionallocation')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('regionallocation')->__('Edit'),
                        'url'       => array('base'=> '*/regionallocation_koenigsteinerschluessel_kstvalue/edit','params'=>array('kst_id'=>$kst->getId())),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('regionallocation')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('regionallocation')->__('XML'));

      return parent::_prepareColumns();
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
  	$kst =	Mage::registry('koenigsteinerschluesselkst_data');
      return $this->getUrl('*/regionallocation_koenigsteinerschluessel_kstvalue/edit', array('id' => $row->getId(),'kst_id'=>$kst->getId()));
  }

}
