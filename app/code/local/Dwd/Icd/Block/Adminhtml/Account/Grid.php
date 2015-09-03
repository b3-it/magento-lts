<?php
/**
 * Dwd Icd
 *
 *
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Account_Grid
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Account_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('accountGrid');
		$this->setDefaultSort('account_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('dwd_icd/account')->getCollection();
		$collection
		->getSelect()
		->join(array('customer'=>'customer_entity'),'entity_id=customer_id',array('email'=>'email'))
		->join(array('connection'=>'icd_connection'),'connection.id=connection_id',array('connetionname'=>'title'));
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('id', array(
				'header'    => Mage::helper('dwd_icd')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'id',
				'filter_index' => 'main_table.id'
		));

		$this->addColumn('email', array(
				'header'    => Mage::helper('dwd_icd')->__('Email'),
				'align'     =>'left',
				'width'     => '180px',
				'index'     => 'email',
		));

		$this->addColumn('login', array(
				'header'    => Mage::helper('dwd_icd')->__('Login Name'),
				'align'     =>'left',
				'width'     => '180px',
				'index'     => 'login',
		));


		$this->addColumn('connetionname', array(
				'header'    => Mage::helper('dwd_icd')->__('Connection'),
				'align'     =>'left',
				'width'     => '100px',
				'index'     => 'connetionname',
		));

		$this->addColumn('is_shareable', array(
				'header'    => Mage::helper('dwd_icd')->__('Is Shareable'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'is_shareable',
				'type'	=> 'options',
				'options' => array('0'=>Mage::helper('dwd_icd')->__('No'),'1'=>Mage::helper('dwd_icd')->__('Yes'))
		));

		$this->addColumn('status', array(
				'header'    => Mage::helper('dwd_icd')->__('Status'),
				'align'     =>'left',
				'width'     => '80px',
				'index'     => 'status',
				'type'	=> 'options',
				'options' => Dwd_Icd_Model_AccountStatus::getOptionArray(),
				'filter_index' =>'main_table.status'
		));

		$this->addColumn('sync_status', array(
				'header'    => Mage::helper('dwd_icd')->__('Synchronization'),
				'align'     =>'left',
				'width'     => '100px',
				'index'     => 'sync_status',
				'type'	=> 'options',
				'options' => Dwd_Icd_Model_Syncstatus::getOptionArray()
		));


		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$this->addColumn('created_time', array(
				'header'    => Mage::helper('dwd_icd')->__('Created'),
				'align'     =>'left',
				'type'		=> 'date',
				'format'	=> $dateFormatIso,
				'width'     => '80px',
				'index'     => 'created_time',
		));
		 
		$this->addColumn('update_time', array(
				'header'    => Mage::helper('dwd_icd')->__('Updated'),
				'align'     =>'left',
				'type'	=> 'date',
				'format'	=> $dateFormatIso,
				'width'     => '80px',
				'index'     => 'update_time',
		));
		 
		$this->addColumn('error', array(
				'header'    => Mage::helper('dwd_icd')->__('Message'),
				'align'     =>'left',
				'index'     => 'error',
		));
		 
		$this->addColumn('action',
				array(
						'header'    =>  Mage::helper('dwd_icd')->__('Action'),
						'width'     => '140',
						'type'      => 'action',
						'getter'    => 'getId',
						'actions'   => array(
								array(
										'caption'   => Mage::helper('sales')->__('Synchronization'),
										'url'       => array('base'=> 'dwd_icd/adminhtml_account/sync'),
										'field'     => 'id'
								)
						),
						'filter'    => false,
						'sortable'  => false,
						'index'     => 'stores',
						'is_system' => true,
				));

		/*
		 $this->addColumn('action',
		 		array(
		 				'header'    =>  Mage::helper('dwd_icd')->__('Action'),
		 				'width'     => '100',
		 				'type'      => 'action',
		 				'getter'    => 'getId',
		 				'actions'   => array(
		 						array(
		 								'caption'   => Mage::helper('dwd_icd')->__('Edit'),
		 								'url'       => array('base'=> '././edit'),
		 								'field'     => 'id'
		 						)
		 				),
		 				'filter'    => false,
		 				'sortable'  => false,
		 				'index'     => 'stores',
		 				'is_system' => true,
		 		));
		*/
		$this->addExportType('*/*/exportCsv', Mage::helper('dwd_icd')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('dwd_icd')->__('XML'));
		 
		return parent::_prepareColumns();
	}



	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}

}