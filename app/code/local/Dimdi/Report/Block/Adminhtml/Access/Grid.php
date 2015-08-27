<?php
/**
 * Dimdi Report
 *
 *
 * @category   	Dimdi
 * @package    	Dimdi_Report
 * @name        Dimdi_Report_Block_Adminhtml_Access_Grid
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Block_Adminhtml_Access_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('accessGrid');
      $this->setDefaultSort('access_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('dimdireport/access')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	
      $this->addColumn('dimdireport_access_id', array(
          'header'    => Mage::helper('dimdireport')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'dimdireport_access_id',
      ));

      $this->addColumn('user', array(
          'header'    => Mage::helper('dimdireport')->__('User'),
          'align'     =>'left',
          'index'     => 'user',
      ));
      
      $this->addColumn('request_begin', array(
          'header'    => Mage::helper('dimdireport')->__('Request Begin'),
          'align'     =>'left',
          'index'     => 'request_begin',
      	  'type' => 'datetime',
      	  'width'     => '100px',
      ));
      
      $this->addColumn('request_end', array(
          'header'    => Mage::helper('dimdireport')->__('Request End'),
          'align'     => 'left',
          'index'     => 'request_end',
      	  'type' 	  => 'datetime',
      	  'width'     => '100px',
      ));

      $this->addColumn('created_time', array(
          'header'    => Mage::helper('dimdireport')->__('Date'),
          'align'     =>'left',
          'index'     => 'created_time',
      	  'type' => 'datetime',
      	  'width'     => '100px',
      ));


      $this->addColumn('type', array(
          'header'    => Mage::helper('dimdireport')->__('Type'),
          'align'     => 'left',
          'width'     => '140px',
          'index'     => 'type',
          'type'      => 'options',
          'options'   => Dimdi_Report_Model_Access_Type::getOptionArray()
      ));
	  
 
		
		$this->addExportType('*/*/exportCsv', Mage::helper('dimdireport')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('dimdireport')->__('XML'));
	  
      return parent::_prepareColumns();
  }

 

}