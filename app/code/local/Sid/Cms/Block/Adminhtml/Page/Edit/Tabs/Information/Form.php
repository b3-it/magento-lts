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

class Sid_Cms_Block_Adminhtml_Page_Edit_Tabs_Information_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
  	$form = new Varien_Data_Form(array(
  			'id' => 'edit_form',
  			'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
  			'method' => 'post',
  			'enctype' => 'multipart/form-data')
  			);
  	
  
  	$form->setUseContainer(true);
  	$this->setForm($form);
  	
      
      $fieldset = $form->addFieldset('information_form', array('legend'=>Mage::helper('sidcms')->__('Email Settings')));
      $opt = array();
      $opt[] = array('label'=>'none','value'=>'none');
      $opt[] = array('label'=>'none1','value'=>'none1');
      $opt[] = array('label'=>'none1','value'=>'none1');
      
      $fieldset->addField('upinfo_send_mode','radios', array(
      		'label'    => Mage::helper('adminhtml')->__('Send'),
      		'type'      => 'radio',
      		//'html_name' => 'roles[]',
      		'values'    => Sid_Cms_Model_SendMode::getAllOptions(),
      		//'align'     => 'center',
      		'value'     => 'none',
      		'name'      => 'send[mode]',
      		'onclick' =>'switch_mode();' 
      ));
      
      
      $fieldset->addField('upinfo_customergroups_send', 'multiselect', array(
      		'label'     => Mage::helper('sidcms')->__('Send to Customer Groups'),
      		//'required'  => true,
      		'values'    => $this->_getCustomerGroup(),
      		'name'      => 'send[customergroup]',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      		));
      
      
      $fieldset->addField('upinfo_title', 'text', array(
      		'label'     => Mage::helper('infoletter')->__('Name'),
      		//'class'     => 'required-entry',
      		//'required'  => !$readonly,
      		'name'      => 'send[title]',
      		//'readonly' => $readonly,
      		//'disabled' => $readonly,
      ));
      
      $fieldset->addField('upinfo_sender_name', 'text', array(
      		'label'     => Mage::helper('infoletter')->__('Sender Name'),
      		//'class'     => 'required-entry',
      		//'required'  => !$readonly,
      		'name'      => 'send[sender_name]',
      		//'readonly' => $readonly,
      		//'disabled' => $readonly,
      ));
      
      $fieldset->addField('upinfo_sender_email', 'text', array(
      		'label'     => Mage::helper('infoletter')->__('Sender Email'),
      		//'class'     => 'required-entry',
      		//'required'  => !$readonly,
      		'name'      => 'send[sender_email]',
      		//'readonly' => $readonly,
      		//'disabled' => $readonly,
      ));
      
      $fieldset->addField('upinfo_message_subject', 'text', array(
      		'label'     => Mage::helper('infoletter')->__('Subject'),
      		//'class'     => 'required-entry',
      		//'required'  => !$readonly,
      		'name'      => 'send[message_subject]',
      		//'readonly' => $readonly,
      		//'disabled' => $readonly,
      ));
      
      $value = Mage::getModel('core/store')->getCollection()->toOptionArray();
      $value[] = array('value'=>0,'label'=>Mage::helper('infoletter')->__('All'));
      $stores = new Varien_Object(array('values' => $value));
      Mage::dispatchEvent('egovs_adminhtlm_block_stores_load', array('stores' => $stores));
      $value = $stores->getValues();
      $fieldset->addField('upinfo_store_id', 'select', array(
      		'label'     => Mage::helper('infoletter')->__('Store'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		//'readonly' => $readonly,
      		//'disabled' => $readonly,
      		'name'      => 'send[store_id]',
      		'values'	 => $value,
      ));
      
    
      
      
      
      $widgetFilters = array('is_email_compatible' => 1);
      $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('widget_filters' => $widgetFilters));
       
      $wysiwygConfig->setEnabled(true);
      
      $wysiwygConfig->setAddWidgets(false);
      $wysiwygConfig->setAddVariables(true);
      $wysiwygConfig->setAddImages(false);
      
      $fieldset->addField('upinfo_message_body', 'editor', array(
      		'name'      => 'send[message_body]',
      		'label'     => Mage::helper('infoletter')->__('Message Body Html'),
      		'title'     => Mage::helper('infoletter')->__('Message Body Html'),
      		//'required'  => !$readonly,
      		'state'     => 'html',
      		'style'     => 'height:36em;',
      		'value'     => $this->getMessageBody(),
      		'config'    => $wysiwygConfig,
      		//'use_container' =>false,
      		//'readonly' => $readonly,
      		//'disabled' => $readonly,
      ));
      
      $fieldset->addField('upinfo_message_body_plain', 'editor', array(
      		'name'      => 'send[message_body_plain]',
      		'label'     => Mage::helper('infoletter')->__('Message Body Plain'),
      		'title'     => Mage::helper('infoletter')->__('Message Body Plain'),
      		//'required'  => true,
      		//'state'     => 'html',
      		'style'     => 'height:36em;',
      		'value'     => $this->getMessageBodyPlain(),
      		//'config'    => $wysiwygConfig,
      		//'use_container' =>false,
      		//'readonly' => $readonly,
      		//'disabled' => $readonly,
      ));
      
      
      return parent::_prepareForm();
  }
  
  private function _getCustomerGroup()
  {
  	$collection = Mage::getResourceModel('customer/group_collection')->load();
  
  	$res = array();
  		
  	foreach($collection as $item){
  		$res[] = array('value'=>$item->getId(),'label'=>$item->getCustomerGroupCode());
  	}
  		
  	return $res;
  }
  
  private function getMessageBody()
  {
  		return "";
  }
  
  private function getMessageBodyPlain()
  {
  		return "";
  }
  
  protected function _afterToHtml($html)
  {
  	$js = " <script> 
  			$('upinfo_send_mode0').onclick = switch_mode0;
  			$('upinfo_send_mode1').onclick = switch_mode1;
  			$('upinfo_send_mode2').onclick = switch_mode2;
  			
  			function switch_mode0() {
  			  	var elements = ['upinfo_customergroups_send','upinfo_title','upinfo_sender_name','upinfo_sender_email','upinfo_message_subject','upinfo_message_body'];
  				toogleEnabled(false);
  				elements.each(function(data){
  					toogleRequire(data, false);
  				});
  			}
  			
  			function switch_mode1() {
  				toogleEnabled(true);
  			  	var elements = ['upinfo_customergroups_send','upinfo_title','upinfo_sender_name','upinfo_sender_email','upinfo_message_subject','upinfo_message_body'];
  				elements.each(function(data){
  					toogleRequire(data, true);
  				});
  			}
  			
  			function switch_mode2() {
  				toogleEnabled(true);
  			  	var elements = ['upinfo_title','upinfo_sender_name','upinfo_sender_email','upinfo_message_subject','upinfo_message_body'];
  				toogleRequire('upinfo_customergroups_send', false);
  				elements.each(function(data){
  					toogleRequire(data, true);
  				});
  			}
  			
  			function toogleEnabled(enabled)
  			{
  				var elements = ['toggleupinfo_message_body','upinfo_store_id','upinfo_customergroups_send','upinfo_title','upinfo_sender_name','upinfo_sender_email','upinfo_message_subject','upinfo_message_body','upinfo_message_body_plain'];
	  			if(!enabled){
	  				elements.each(function(element){
	  					$(element).disable();
  						$(element).addClassName('disabled');
	  				});
	  			}else{
	  				elements.each(function(element){
	  					$(element).enable();
  						$(element).removeClassName('disabled');
	  				});
  				}
  			}
  			
  			function toogleRequire(element, required)
  			{
  				var text = '<span class=\"required\"> *</span>';
  				if(required){
  					$(element).addClassName('required-entry');
  					var elem = $$('label[for=\"'+element+'\"]');
  					var inner = elem.first().innerHTML;
  					inner = inner.replace(text,'');
  					elem.first().update(inner + text);
  				}
  				else{
  					$(element).removeClassName('required-entry');
  					var elem = $$('label[for=\"'+element+'\"]');
  					var inner = elem.first().innerHTML;
  					inner = inner.replace(text,'');
  					elem.first().update(inner);
  				}
  			}
  			toogleEnabled(false);
  			</script>";
  	
  	return $html . $js;
  }
}