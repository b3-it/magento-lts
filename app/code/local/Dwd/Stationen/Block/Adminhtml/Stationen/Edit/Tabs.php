<?php

class Dwd_Stationen_Block_Adminhtml_Stationen_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('stationen_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('stationen')->__('Stations Information'));
      
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('stationen')->__('Stations'),
          'title'     => Mage::helper('stationen')->__('Stations'),
          'content'   => $this->getLayout()->createBlock('stationen/adminhtml_stationen_edit_tab_form')->toHtml(),
      ));
      
     //Sets und Ableitungen brauchen die id
     $model = Mage::registry('stationen_data'); 
     $storeId = intval($this->getRequest()->getParam('store'));
     if($model->getId() && ($model->getStatus() == Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE) && ($storeId == 0))
     {
     
	     $this->addTab('set_section', array(
	          'label'     => Mage::helper('stationen')->__('Sets'),
	          'title'     => Mage::helper('stationen')->__('Sets'),
	       	   'url'   =>  $this->getUrl('*/stationen_stationen/set',array('_current'=>true)),
     	  	  'class'  => 'ajax',
	          'content'   => $this->getLayout()->createBlock('stationen/adminhtml_stationen_edit_tab_set')->toHtml(),
	      ));
	      
     }
     $this->_updateActiveTab();
     return parent::_beforeToHtml();
  }
  protected function _updateActiveTab()
    {
    	
        $tabId = $this->getRequest()->getParam('tab');
        if( $tabId ) {
            //$tabId = preg_replace("#{$this->getId()}_#", '', $tabId);
            if($tabId) {
                $this->setActiveTab($tabId);
            }
        }
    }
}