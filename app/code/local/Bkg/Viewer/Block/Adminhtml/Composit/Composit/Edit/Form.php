<?php
/**
 * Sid Cms
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Block_Adminhtml_Navi_Edit_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_Viewer_Block_Adminhtml_Composit_Composit_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	
	public function xx__construct()
	{
		parent::__construct();
	
	
	
		$this->_formScripts[] = "
            function xxxsaveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
	}
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $this->setTemplate('bkg/viewer/composit/edit/form.phtml');
      $form->setUseContainer(true);
      $this->setForm($form);
      
      $composit = Mage::registry('compositcomposit_data');
      
      $fieldset = $form->addFieldset('navi', array('legend'=>Mage::helper('bkgviewer')->__('Composit')));
      
      $fieldset->addField('title', 'text', array(
      		'label'     => Mage::helper('bkgviewer')->__('Name'),
      		'required'  => true,
      
      		'name'      => 'title',
      		'value'	=> $composit->getTitle() ? $composit->getTitle() : Mage::helper('bkgviewer')->__('Navigation'),
      		//'onchange'  => 'onchangeTransferType()',
      
      ));
      
      
      $fieldset = $form->addFieldset('navi_layers', array('legend'=>Mage::helper('bkgviewer')->__('Layers available')));
      
      $services = Mage::getModel('bkgviewer/service_service')->getCollection();
      
      
      
      $fieldset->addField('service', 'select', array(
      		'label'     => Mage::helper('bkgviewer')->__('Service'),
      		//'required'  => true,
      		//'values'    => $this->getPages(),
      		'name'      => 'service',
      		'value'	=> '',
      		'options' => $services->getAsFormOptions(true),
      		'onchange'  => 'reloadLayer()',
      
      ));
      
      
      $fieldset->addField('service_layers', 'multiselect', array(
      		'label'     => Mage::helper('bkgviewer')->__('Layer'),
      		//'required'  => true,
      		//'values'    => $this->getPages(),
      		'name'      => 'service_layers',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      ));
      
      $fieldset->addField('permanent', 'checkbox', array(
      		'label'     => Mage::helper('bkgviewer')->__('permanent'),
      		//'required'  => true,
      		//'values'    => $this->getPages(),
      		'name'      => 'permanent',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      ));
      
      $fieldset->addField('betroffenheit_layer', 'checkbox', array(
      		'label'     => Mage::helper('bkgviewer')->__('betroffenheit'),
      		//'required'  => true,
      		//'values'    => $this->getPages(),
      		'name'      => 'betroffenheit_layer',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      ));
      
      $fieldset->addField('entity_layer', 'checkbox', array(
      		'label'     => Mage::helper('bkgviewer')->__('entity layer'),
      		//'required'  => true,
      		//'values'    => $this->getPages(),
      		'name'      => 'entity_layer',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      ));
     
      
      
      $fieldset->addField ( 'copy_cms_pages', 'button', array (
      		'value' => Mage::helper ( 'bkgviewer' )->__ ( 'Insert' ),
      		'name' => 'copy_cms_pages',
      		'onclick' => "addPages();",
      		'class'	=> 'form-button',
      		'label' => Mage::helper ( 'bkgviewer' )->__ ( 'Copy selected Layer to Navigation' ),
      ) );
      
     
      $this->setChild('navigation_tree',  $this->getLayout()->createBlock('bkgviewer/adminhtml_composit_composit_edit_tree'));
      
      return parent::_prepareForm();
  }
  
  protected function _afterToHtml($html)
  {
  	$html = str_replace('</form>', '<div id="hidden_navi_menu" /></form>', $html);
  	return $html;
  }
  
  public function getPages()
  {
  	$collection = Mage::getModel('cms/page')->getCollection();
  	$res = array();
  	foreach ($collection as $item)
  	{
  		$res[] = array('value' => $item->getPageId(),'label' => $item->getTitle());
  	}
  	return $res;
  }
  
  
  
}