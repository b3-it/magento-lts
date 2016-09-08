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

class Sid_Cms_Block_Adminhtml_Navi_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/step1', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      
      $form->setUseContainer(true);
      $this->setForm($form);
      
      $fieldset = $form->addFieldset('navi_form', array('legend'=>Mage::helper('sidcms')->__('Store information')));
      
      $field =$fieldset->addField('store_id', 'multiselect', array(
      		'name'      => 'stores[]',
      		'label'     => Mage::helper('cms')->__('Store View'),
      		'title'     => Mage::helper('cms')->__('Store View'),
      		'required'  => true,
      		'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false),
      ));
      $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
      $field->setRenderer($renderer);
      
      
      return parent::_prepareForm();
  }
}