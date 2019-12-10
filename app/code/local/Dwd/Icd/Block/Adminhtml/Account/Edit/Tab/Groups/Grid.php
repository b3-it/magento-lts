<?php

class Dwd_Icd_Block_Adminhtml_Account_Edit_Tab_Groups_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	
	
	
  public function __construct()
  {
      parent::__construct();
      $this->setId('icdgroupsGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(false);
      $this->setUseAjax(true);
      $this->setIdFieldName('entity_id');
      
    
      
  }

  protected function _prepareCollection()
  {
  		$id     = $this->getRequest()->getParam('id');
      $collection = Mage::getModel('dwd_icd/account_groups')->getCollection();
      $collection->getSelect()->where('account_id=?',intval($id));
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
  
 
  
    
  protected function _prepareColumns()
  {
  	
      $this->addColumn('id', array(
          'header'    	=> Mage::helper('dwd_icd')->__('Id'),
          //'align'     	=>'right',
          'width'     	=> '50px',
          'index'     	=> 'id', 
      	  'filter_index'=> 'id',	  	

      ));
      
      $this->addColumn('created_time', array(
      		'header'    	=> Mage::helper('dwd_icd')->__('Timestamp'),
      		//'align'     	=>'right',
      		'width'     	=> '150px',
      		'index'     	=> 'created_time',
      
      ));
      
      $this->addColumn('count', array(
      		'header'    	=> Mage::helper('dwd_icd')->__('Count'),
      		//'align'     	=>'right',
      		'width'     	=> '150px',
      		'index'     	=> 'count',
      
      ));
      
      $this->addColumn('application', array(
      		'header'    	=> Mage::helper('dwd_icd')->__('Application'),
      		//'align'     	=>'right',
      		//'width'     	=> '150px',
      		'index'     	=> 'application',
      
      ));
      


      
 
      return parent::_prepareColumns();
  }

   
  public function getGridUrl()
  {
  		$id     = $this->getRequest()->getParam('id');
  		return $this->getUrl('adminhtml/icd_account/groupsgrid', array('_current'=>true,'id'=> $id));
  }
  
	
 

}