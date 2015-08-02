<?php

class Egovs_Informationservice_Block_Adminhtml_Request_Edit_Tab_Task extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $mode = $this->getRequest()->getParam('mode');
      //edit mode
      if($mode == null)
      {
      	$this->prepareEdit($form);
      }
      //view mode
      else 
      {
      	$id = $this->getRequest()->getParam('id');
      	$task = Mage::getModel('informationservice/task')->load($id);
      	$data = $task->getData();
      	
      	$this->prepareView($form, $data);
      }
     

      return parent::_prepareForm();
  }
  
  private function prepareEdit($form)
  {
  	      $fieldset = $form->addFieldset('task_form', array('legend'=>Mage::helper('informationservice')->__('Task Description')));
     
	      $fieldset->addField('title', 'text', array(
	          'label'     => Mage::helper('informationservice')->__('Comment'),
	           'name'      => 'task[title]',
	      ));
			
		  $status = Mage::getModel('informationservice/status');
	
	      $fieldset->addField('newstatus', 'select', array(
	          'label'     => Mage::helper('informationservice')->__('New Status'),
	          'name'      => 'task[newstatus]',
	          'values'    => $status->getOptionArray(),
	         ));
	     
	      $fieldset->addField('content_id', 'editor', array(
	          'name'      => 'task[content]',
	          'label'     => Mage::helper('informationservice')->__('Content'),
	          'title'     => Mage::helper('informationservice')->__('Content'),
	          'style'     => 'width:700px; height:200px;',
	          'wysiwyg'   => false,
	      ));
	     
	    $fieldset->addField('copy_product_url', 'button', array(
	          'value'     => Mage::helper('informationservice')->__('Insert Product Url'),       
	          'name'      => 'copy_product_link',
			  'onclick'	  => "injectUrl();",
	    	  'class'  	  => 'x-hidden'	
	      ));
	      
	    $fieldset->addField('copy_product_link', 'button', array(
	          'value'     => Mage::helper('informationservice')->__('Insert Product Link'),       
	          'name'      => 'copy_product_link',
			  'onclick'	  => "injectLink();",
	    	  'class'  	  => 'x-hidden'	
	      ));
	      
	      
	      $fieldset->addField('owner_id', 'select', array(
	          'label'     => Mage::helper('informationservice')->__('New Owner'),
	          'name'      => 'task[owner_id]',
	          'values'    =>Mage::helper('informationservice')->getUsernamesAsOptionArray(),
	         ));
	    
	    if(!isset($data['user_id']))
	     {
	     	$data['user_id'] = Mage::getSingleton('admin/session')->getUser()->getId();
	    	$fieldset->addField('user_id', 'hidden', array(
		         'value'	=>  Mage::getSingleton('admin/session')->getUser()->getId(),
		          'name'      => 'task[user_id]',
		      ));
	     } 
	      
	    $fieldset->addField('cost', 'text', array(
	          'label'     => Mage::helper('informationservice')->__('Real Cost'),     
	          'name'      => 'task[cost]',
	      ));
	
	     $fieldset->addField('email_send', 'checkbox', array(
	          'label'     => Mage::helper('informationservice')->__('Send Status to Customer'),     
	          'name'      => 'task[email_send]',
	      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getInformationserviceData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getInformationserviceData());
          Mage::getSingleton('adminhtml/session')->setInformationserviceData(null);
      } elseif ( Mage::registry('task_data') ) {
          $form->setValues(Mage::registry('task_data')->getData());
      }
      $status = Mage::registry('new_task_status');
      if($status != null)
      {
      	$form->getElement('newstatus')->setValue($status);
      }
  }
  
  private function prepareView($form, $data)
  {
  	      $fieldset = $form->addFieldset('task_form', array('legend'=>Mage::helper('informationservice')->__('Item information')));
     
	      $fieldset->addField('title', 'text', array(
	          'label'     => Mage::helper('informationservice')->__('Comment'),
	           'name'      => 'task[title]',
	      
	      ));
			
		  $status = Mage::getModel('informationservice/status');
	
	      $fieldset->addField('newstatus', 'select', array(
	          'label'     => Mage::helper('informationservice')->__('New Status'),
	          'name'      => 'task[newstatus]',
	          'values'    => $status->getOptionArray(),
	         ));
	     
	      $fieldset->addField('content', 'editor', array(
	          'name'      => 'task[content]',
	          'label'     => Mage::helper('informationservice')->__('Content'),
	          'title'     => Mage::helper('informationservice')->__('Content'),
	          'style'     => 'width:700px; height:200px;',
	          'wysiwyg'   => false,
	      ));
	     
	      $fieldset->addField('owner_id', 'select', array(
	          'label'     => Mage::helper('informationservice')->__('Owner'),
	          'name'      => 'task[owner_id]',
	          'values'    =>Mage::helper('informationservice')->getUsernamesAsOptionArray(),
	         ));
	    
	    if(!isset($data['user_id']))
	     {
	     	$data['user_id'] = Mage::getSingleton('admin/session')->getUser()->getId();
	    	$fieldset->addField('user_id', 'hidden', array(
		         'value'	=>  Mage::getSingleton('admin/session')->getUser()->getId(),
		          'name'      => 'task[user_id]',
		      ));
	     } 
	      
	    $fieldset->addField('cost', 'text', array(
	          'label'     => Mage::helper('informationservice')->__('Cost'),     
	          'name'      => 'task[cost]',
	      ));
	
	     $fieldset->addField('email_send', 'checkbox', array(
	          'label'     => Mage::helper('informationservice')->__('Send Status to Customer'),     
	          'name'      => 'task[email_send]',
	      ));
	      
	       $form->setValues($data);
     
  }
  
 protected function _afterToHtml($html)
  {
  		$html .= "
			 <script type=\"text/javascript\">
            //<![CDATA[
            
            	if(\$('result_product_url') != null)
            	{
            		$('copy_product_link').removeClassName('x-hidden');
            		$('copy_product_url').removeClassName('x-hidden');
            	}
            
 				function injectLink()
 				{
 					if(\$('result_product_url') == null) return;
 					var html = '<a href=\"' + \$('result_product_url').innerHTML + '\">Link zum Artikel</a>';
 					\$('content_id').value += '\\n' + html;
 				}
 				
 				function injectUrl()
 				{
 					if(\$('result_product_url') == null) return;
 					\$('content_id').value += '\\n' + \$('result_product_url').innerHTML;
 				}
            //]]>
            </script>";
  	return $html;
  }
  
}