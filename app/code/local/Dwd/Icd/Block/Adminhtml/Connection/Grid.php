<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Connection_Grid
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Connection_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('connectionGrid');
      $this->setDefaultSort('connection_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('dwd_icd/connection')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('icd_connection_id', array(
          'header'    => Mage::helper('dwd_icd')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('dwd_icd')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      
      $this->addColumn('url', array(
      		'header'    => Mage::helper('dwd_icd')->__('URL'),
      		'align'     =>'left',
      		'index'     => 'url',
      ));
      
      $this->addColumn('user', array(
      		'header'    => Mage::helper('dwd_icd')->__('User'),
      		'align'     =>'left',
      		'index'     => 'user',
      		'width'     => '150px',      
      		
      ));
      
      $this->addColumn('created_time', array(
      		'header'    => Mage::helper('dwd_icd')->__('Created'),
      		'align'     =>'left',
      		'index'     => 'created_time',
      		'type'	=> 'date',
      		'width'     => '80px',
      ));
      
      
      $this->addColumn('update_time', array(
      		'header'    => Mage::helper('dwd_icd')->__('Update'),
      		'align'     =>'left',
      		'index'     => 'update_time',
      		'type'	=> 'date',
      		'width'     => '80px',
      ));
      


		
		$this->addExportType('*/*/exportCsv', Mage::helper('dwd_icd')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('dwd_icd')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}