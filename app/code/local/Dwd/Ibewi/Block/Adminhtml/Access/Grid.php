<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Block_Adminhtml_Access_Grid
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Access_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
      $collection = Mage::getModel('ibewi/access')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	
      $this->addColumn('ibewi_access_id', array(
          'header'    => Mage::helper('ibewi')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'ibewi_access_id',
      ));

      $this->addColumn('user', array(
          'header'    => Mage::helper('ibewi')->__('User'),
          'align'     =>'left',
          'index'     => 'user',
      ));
      
      $this->addColumn('request_begin', array(
          'header'    => Mage::helper('ibewi')->__('Request Begin'),
          'align'     =>'left',
          'index'     => 'request_begin',
      	  'type' => 'datetime',
      	  'width'     => '100px',
      ));
      
      $this->addColumn('request_end', array(
          'header'    => Mage::helper('ibewi')->__('Request End'),
          'align'     => 'left',
          'index'     => 'request_end',
      	  'type' 	  => 'datetime',
      	  'width'     => '100px',
      ));

      $this->addColumn('created_time', array(
          'header'    => Mage::helper('ibewi')->__('Date'),
          'align'     =>'left',
          'index'     => 'created_time',
      	  'type' => 'datetime',
      	  'width'     => '100px',
      ));


      $this->addColumn('type', array(
          'header'    => Mage::helper('ibewi')->__('Type'),
          'align'     => 'left',
          'width'     => '140px',
          'index'     => 'type',
          'type'      => 'options',
          'options'   => Dwd_Ibewi_Model_Access_Type::getOptionArray()
      ));
	  
 
		
		$this->addExportType('*/*/exportCsv', Mage::helper('ibewi')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('ibewi')->__('XML'));
	  
      return parent::_prepareColumns();
  }

 

}