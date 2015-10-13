<?php

class Egovs_Informationservice_Block_Adminhtml_Request_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('request_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('informationservice')->__('Information Service'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('request_section', array(
          'label'     => Mage::helper('informationservice')->__('Request'),
          'title'     => Mage::helper('informationservice')->__('Request Information'),
          'content'   => $this->getLayout()->createBlock('informationservice/adminhtml_request_edit_tab_request')->toHtml(),
      ));

	$data = Mage::registry('request_data');
	
	if(isset($data['request']['status']))
	{
		$data = $data['request']['status'];
	}
	else $data = 0;
	
	if(($data != Egovs_Informationservice_Model_Status::STATUS_CLOSED) && ($data != Egovs_Informationservice_Model_Status::STATUS_CANCELED) )
	{
      $this->addTab('task_section', array(
          'label'     => Mage::helper('informationservice')->__('Task'),
          'title'     => Mage::helper('informationservice')->__('Task Information'),
          'content'   => $this->getLayout()->createBlock('informationservice/adminhtml_request_edit_tab_task')->toHtml(),
      ));
	} 
     $this->addTab('history_section', array(
          'label'     => Mage::helper('informationservice')->__('History'),
          'title'     => Mage::helper('informationservice')->__('History Information'),
          'content'   => $this->getLayout()->createBlock('informationservice/adminhtml_request_edit_tab_grid')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}