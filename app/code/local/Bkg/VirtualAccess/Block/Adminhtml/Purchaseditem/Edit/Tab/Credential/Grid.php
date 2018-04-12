<?php

class Bkg_VirtualAccess_Block_Adminhtml_Purchaseditem_Edit_Tab_Credential_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	private $_model = null;
	
	
	
  public function __construct()
  {
      parent::__construct();
      $this->setId('produktesetGrid');
      $this->setDefaultSort('product_id');
      $this->setDefaultDir('ASC');
      //$this->setSaveParametersInSession(true);
      $this->setUseAjax(true);

  }

  protected function _prepareCollection()
  {
  	  $id = intval($this->getRequest()->getParam('id'));  	
      $collection = Mage::getModel('virtualaccess/purchased_credential')->getCollection();
      //$collection->addAttributeToSelect('*');
      $collection->getSelect()

      	->where('purchased_item_id='.$id);
      	
 
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
  

  
  

 
   
    
  protected function _prepareColumns()
  {
	  $this->addColumn('uuid', array(
          'header'    => Mage::helper('virtualaccess')->__('UUID'),
          'align'     =>'right',
          'width'     => '150px',
          'index'     => 'uuid',
      ));

      $this->addColumn('username', array(
          'header'    => Mage::helper('virtualaccess')->__('username'),
          'align'     =>'left',
          'index'     => 'username',
      ));

      $this->addColumn('password', array(
          'header'    => Mage::helper('virtualaccess')->__('password'),
          'align'     =>'left',
          'index'     => 'password',
      ));

      $this->addColumn('ip', array(
          'header'    => Mage::helper('virtualaccess')->__('ip'),
          'align'     =>'left',
          'index'     => 'ip',
      ));
      

      
 

	  
      return parent::_prepareColumns();
  }

 
	public function getGridUrl()
    {
         return $this->getUrl('*/virtualaccess_credential/purchasedgrid', array('id'=>intval($this->getRequest()->getParam('id'))));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getCredentialId()));
    }
 

}