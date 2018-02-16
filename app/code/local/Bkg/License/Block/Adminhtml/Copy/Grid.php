<?php
 /**
  *
  * @category   	Bkg License
  * @package    	Bkg_License
  * @name       	Bkg_License_Block_Adminhtml_Copy_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_License_Block_Adminhtml_Copy_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
      $collection = Mage::getModel('bkg_license/copy')->getCollection();
      $product = new Zend_Db_Expr("(SELECT mpr.copy_id as copy_id, GROUP_CONCAT(sku SEPARATOR '; ')  as product_sku FROM {$collection->getTable('bkg_license/copy_product')} AS mpr
      JOIN  {$collection->getTable('catalog/product')} AS pr ON pr.entity_id=mpr.product_id GROUP BY(copy_id))");
      $collection->getSelect()
      ->joinleft(array('product'=>$product),'product.copy_id=main_table.id');
      
      //die($collection->getSelect()->__toString());
      
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
      
      
      $this->addColumn('ident', array(
      		'header'    => Mage::helper('bkg_license')->__('Number of License'),
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
      $this->addColumn('active', array(
      		'header'    => Mage::helper('bkg_license')->__('Active'),
      		//'align'     =>'left',
      		'width'     => '50px',
      		'index'     => 'active',
      		'type'      => 'options',
      		'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
      ));
      $this->addColumn('date_from', array(
      		'header'    => Mage::helper('bkg_license')->__('Anfangsdatum'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'date_from',
      		'type' => 'date'
      ));
      $this->addColumn('date_to', array(
      		'header'    => Mage::helper('bkg_license')->__('Enddatum'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'date_to',
      		'type' => 'date'
      ));
     
      $this->addColumn('type', array(
      		'header'    => Mage::helper('bkg_license')->__('Type of License'),
      		//'align'     =>'left',
      		'width'     => '50px',
      		'index'     => 'type',
      		'type' => 'options',
      		'options'=>Bkg_License_Model_Type::getOptionArray()
      ));
      
      $this->addColumn('product', array(
      		'header'    => Mage::helper('bkg_license')->__('Product'),
      		//'align'     =>'left',
      		//'width'     => '50px',
      		'index'     => 'product_sku',
      		
      ));
      
/*
      $this->addColumn('usetypeoption_id', array(
          'header'    => Mage::helper('bkg_license')->__('Type Of Use'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'usetypeoption_id',
      ));
      $this->addColumn('customergroup_id', array(
          'header'    => Mage::helper('bkg_license')->__('Customer Group'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'customergroup_id',
      ));
    
      */
      $this->addColumn('reuse', array(
          'header'    => Mage::helper('bkg_license')->__('Reuse'),
          //'align'     =>'left',
          'width'     => '50px',
          'index'     => 'reuse',
      		'type'      => 'options',
      		'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
      ));


//       $this->addColumn('consternation_check', array(
//           'header'    => Mage::helper('bkg_license')->__('Check Consternation'),
//           //'align'     =>'left',
//           //'width'     => '150px',
//           'index'     => 'consternation_check',
//       ));

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
        $this->getMassactionBlock()->setFormFieldName('copyentity_ids');

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
