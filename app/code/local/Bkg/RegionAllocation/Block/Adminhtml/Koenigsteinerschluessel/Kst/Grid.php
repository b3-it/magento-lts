<?php
 /**
  *
  * @category   	Bkg Regionallocation
  * @package    	Bkg_Regionallocation
  * @name       	Bkg_Regionallocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_RegionAllocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('koenigsteinerschluessel_kstGrid');
      $this->setDefaultSort('koenigsteinerschluessel_kst_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
  	
      $collection = Mage::getModel('regionallocation/koenigsteinerschluessel_kst')->getCollection();
      $expr = new Zend_Db_Expr('(SELECT sum(portion) as total_portions, kst_id FROM '.$collection->getTable('regionallocation/koenigsteinerschluessel_kst_value').' GROUP BY kst_id)');
      $collection->getSelect()
     	->join(array('werte'=>$expr) ,'werte.kst_id=main_table.id','total_portions');
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

      $this->addColumn('name', array(
          'header'    => Mage::helper('regionallocation')->__('Name'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'name',
      ));
      
      $statuses = Mage::getSingleton('regionallocation/koenigsteinerschluessel_status')->getOptionArray();
      
      $this->addColumn('active', array(
          'header'    => Mage::helper('regionallocation')->__('Active'),
          //'align'     =>'left',
          'width'     => '150px',
          'index'     => 'active',
      	  'type'      => 'options',
          'options'   => $statuses
      ));
      
      $this->addColumn('active_from', array(
          'header'    => Mage::helper('regionallocation')->__('Active From'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'active_from',
      	'type' => 'date'
      ));
      /*
      $this->addColumn('active_to', array(
          'header'    => Mage::helper('regionallocation')->__('Active To'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'active_to',
      ));
*/
      $this->addColumn('total_portions', array(
      		'header'    => Mage::helper('regionallocation')->__('Total Portions'),
      		'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'total_portions',
      		'sortable' => false,
      		'filter' => false
      ));
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('regionallocation')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('regionallocation')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
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

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('koenigsteinerschluesselkst_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('regionallocation')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('regionallocation')->__('Are you sure?')
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
