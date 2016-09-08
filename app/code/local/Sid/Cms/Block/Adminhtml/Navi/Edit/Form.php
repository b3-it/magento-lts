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

class Sid_Cms_Block_Adminhtml_Navi_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $this->setTemplate('sid/navigation/form.phtml');
      $form->setUseContainer(true);
      $this->setForm($form);
      
      $navi = Mage::registry('navi_data');
      
      $fieldset = $form->addFieldset('navi', array('legend'=>Mage::helper('sidcms')->__('Navigation')));
      
      $fieldset->addField('title', 'text', array(
      		'label'     => Mage::helper('framecontract')->__('Title'),
      		'required'  => true,
      
      		'name'      => 'title',
      		'value'	=> $navi->getTitle() ? $navi->getTitle() : Mage::helper('framecontract')->__('Navigation'),
      		//'onchange'  => 'onchangeTransferType()',
      
      ));
      
      
      $fieldset = $form->addFieldset('navi_pages', array('legend'=>Mage::helper('sidcms')->__('Pages')));
      
      $fieldset->addField('cms_pages', 'multiselect', array(
      		'label'     => Mage::helper('sidcms')->__('Seiten'),
      		//'required'  => true,
      		'values'    => $this->getPages(),
      		'name'      => 'cms_pages',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      ));
      
      
      $fieldset->addField ( 'copy_cms_pages', 'button', array (
      		'value' => Mage::helper ( 'sidcms' )->__ ( 'Insert' ),
      		'name' => 'copy_cms_pages',
      		'onclick' => "addPages();",
      		'label' => Mage::helper ( 'sidcms' )->__ ( 'Copy selected Pages to Navigation' ),
      ) );
      
      
      $this->setChild('navigation_tree',  $this->getLayout()->createBlock('sidcms/adminhtml_navi_edit_tree'));
      
      return parent::_prepareForm();
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