<?php
/**
 * Sid Import
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Import
 * @name       	Sid_Import_Block_Adminhtml_Import_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Import_Block_Adminhtml_Import_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

private $showProducts = false;
    
public function getShowProducts() 
{
  return $this->showProducts;
}

public function setShowProducts($value) 
{
  $this->showProducts = $value;
}
	
	
	
  public function __construct()
  {
      parent::__construct();
      $this->setId('import_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sidimport')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sidimport')->__('Item Information'),
          'title'     => Mage::helper('sidimport')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('sidimport/adminhtml_import_edit_tab_form')->toHtml(),
      ));
      
    
      if($this->showProducts){
      	
      	$this->addTab('form_section1', array(
      			'label'     => Mage::helper('sidimport')->__('Product Information'),
      			'title'     => Mage::helper('sidimport')->__('Product Information'),
      			'content'   => $this->getLayout()->createBlock('sidimport/adminhtml_import_edit_tab_grid')->toHtml(),
      	));
      	
      	$this->setActiveTab('form_section1');
      }
      
     
      return parent::_beforeToHtml();
  }
  
  
 
  
}