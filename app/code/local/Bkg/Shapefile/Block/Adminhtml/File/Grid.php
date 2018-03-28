<?php
 /**
  *
  * @category   	Bkg Shapefile
  * @package    	bkg_Shapefile
  * @name       	Bkg_Shapefile_Block_Adminhtml_File_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Shapefile_Block_Adminhtml_File_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
//      $this->setId('unitGrid');
//      $this->setDefaultSort('unit_id');
//      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('bkg_shapefile/file')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $helper = Mage::helper('bkg_shapefile');

      /**
       * @var Mage_Customer_Model_Resource_Customer_Collection $customer
       */
      $customer = Mage::getModel("customer/customer")->getCollection();
      $options = array();
      
      foreach ($customer->getItems() as $id => $c) {
          /**
           * @var Mage_Customer_Model_Customer $c
           */
          
          $options [$id]= strval($id) . ": " . $c->getEmail();
      }
      
      $this->addColumn('id', array(
          'header'    => $helper->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('name', array(
          'header'    => $helper->__('Name'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'name',
      ));
      $this->addColumn('customer_id', array(
          'header'    => $helper->__('Customer'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'customer_id',
          'type'      => 'options',
          'options'    => $options
      ));
      
      /**
       * @var Bkg_VirtualGeo_Model_Resource_Components_Georef_Collection $georef
       */
      $georef = Mage::getModel('virtualgeo/components_georef')->getCollection();
      
      $this->addColumn('georef_id', array(
          'header'    => $helper->__('Georef'),
          'type'      => 'options',
          'index'     => 'georef_id',
          'options'    => $georef->toOptionHash()
          
      ));
      
    $this->addColumn('action',
        array(
            'header'    =>  $helper->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => $helper->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
    ));

		//$this->addExportType('*/*/exportCsv', Mage::helper('bkg_⁬shapefile')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('bkg_⁬shapefile')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');

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
