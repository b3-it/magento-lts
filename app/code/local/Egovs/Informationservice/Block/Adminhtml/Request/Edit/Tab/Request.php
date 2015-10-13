<?php

class Egovs_Informationservice_Block_Adminhtml_Request_Edit_Tab_Request extends Mage_Adminhtml_Block_Widget_Form
{
	private $_createProduct = false;
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $data = Mage::registry('request_data');
      
      $fieldset = $form->addFieldset('customer_request_form', array('legend'=>Mage::helper('informationservice')->__('Customer Information')));
      
      //kundeninfos suchen
      $customer = Mage::getModel('customer/customer')
            ->load($data['request']['customer_id']);

		$isclosed = false;
      //falls neuer datansatz 
      if(!isset($data['request']['request_id']))
      {
      		$data['request']['replay_email'] = $customer->getEmail();
      }      
	  else 
	  {
			$status = $data['request']['status'];
			if(($status == Egovs_Informationservice_Model_Status::STATUS_CLOSED) || 
				($status == Egovs_Informationservice_Model_Status::STATUS_CANCELED)){
					$isclosed = true;
				}
 
	  }	
      
 
      
       $fieldset->addField('customer_id', 'hidden', array(
	          'name'      => 'request[customer_id]',
       		  //'value'	=> $customer->getId(),
	      ));
      
            
      $data['request']['customername']  = $customer->getName();     
      
     $addresses = $customer->getAddresses();
     if((count($addresses) == 0) && (!isset($data['request']['request_id'])))
     {
     	Mage::throwException(Mage::helper('informationservice')->__("Please create a customer address first."));
     }
      
      
      $adroptions= array();
      foreach($addresses as $adr)
      {
      	$name = $adr->getPrefix().' '.$adr->getFirstname().' '.$adr->getLastname() .' '.implode(" ",$adr->getStreet()).' '.$adr->getTelephone();
      	$name = trim($name);
      	$adroptions[] = array('value'=>$adr->getId(),'label'=>$name);
      }
      
      $fieldset->addField('customername', 'text', array(
          'label'     => Mage::helper('informationservice')->__('Customer Name'),
          'class'     => 'required-entry',
          'readonly'  => true,
      	  'disabled' => true,
          'class'	 => 'readonly',
          'name'      => "request[customername]",
      ));
    
      $fieldset->addField('address_id', 'select', array(
          'label'     => Mage::helper('informationservice')->__('Customer Address'),
          'name'      => 'request[address_id]',
          'values'    => $adroptions,
      	  'readonly'  => $isclosed,
           'disabled' => $isclosed,
          )
      );
      
     $fieldset->addField('replay_email', 'text', array(
          'label'     => Mage::helper('informationservice')->__('Customer E-Mail'),
          'class'     => 'required-entry',
          //'readonly'  => $isclosed,
          'disabled' => $isclosed,
          'name'      => "request[replay_email]",
      ));
      
      
      
      $fieldset = $form->addFieldset('content_request_form', array('legend'=>Mage::helper('informationservice')->__('Content Information')));

      $categoriesField = $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('informationservice')->__('Category'),
          'name'      => 'request[category_id]',
          'values'    => Mage::helper('informationservice')->getCategoriesAsOptionArray(),
       	  'disabled' => $isclosed,
      ));
      if ($categoriesField) {
	  	$categoriesField->setRenderer(
	  			$this->getLayout()->createBlock('informationservice/adminhtml_widget_form_renderer_fieldset_selectlevels')
	  	);		
      }
      
      
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('informationservice')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'request[title]',
      'disabled' => $isclosed,
      ));

 
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
	  $fieldset->addField('deadline_time', 'date', array(
	        'label'     => Mage::helper('informationservice')->__('Deadline'),
//	        'class'     => 'required-entry',
	        'required'  => true,
	     	'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
	        'name'      => 'request[deadline_time]',
	     	'image'  => $this->getSkinUrl('images/grid-cal.gif'),
	     	'format'       => $dateFormatIso,
	  'disabled' => $isclosed,	
		 ));
      
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'request[content]',
          'label'     => Mage::helper('informationservice')->__('Content'),
          'title'     => Mage::helper('informationservice')->__('Content'),
          'style'     => 'width:700px; height:300px;',
          'wysiwyg'   => false,
          'required'  => false,
      'disabled' => $isclosed,
      ));
      
 

     

      
      
		 
	 $fieldset = $form->addFieldset('processin_request_form', array('legend'=>Mage::helper('informationservice')->__('Processing Status')));
     
	 $status = Mage::getModel('informationservice/status');

	 $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('informationservice')->__('Status'),
          'name'      => 'request[status]',
	      'readonly'  => true,
	 	  'disabled' => true,	
          'values'    => $status->getOptionArray(),
         ));
	 
	 
     if(isset($data['request']['created_time'])) 
     {
	     $fieldset->addField('created_time', 'text', array(
	          'label'     => Mage::helper('informationservice')->__('Created At'),
	          'readonly'  => true,
	      	  'disabled' => true,
	          'name'      => 'created_time',
	      ));
     }
     
     if(!isset($data['request']['reporter_id']))
     {
     	$data['request']['reporter_id'] = Mage::getSingleton('admin/session')->getUser()->getId();
    	$fieldset->addField('reporter_id', 'hidden', array(
	         'value'	=>  Mage::getSingleton('admin/session')->getUser()->getId(),
	          'name'      => 'request[reporter_id]',
	      ));
     }
     
     $data['request']['reporter'] = Mage::helper('informationservice')->getUsername($data['request']['reporter_id']);
     
     if(isset($data['request']['reporter'])) 
     {
	     $fieldset->addField('reporter', 'text', array(
	          'label'     => Mage::helper('informationservice')->__('Reporter'),
	          'class'     => 'required-entry',
	          'readonly'  => true,
	      	  'disabled' => true,
	          'name'      => 'request[reporter]',
	      ));
     }
     
    if(isset($data['request']['owner_id']))
    {
    	 $data['request']['owner'] = Mage::helper('informationservice')->getUsername($data['request']['owner_id']);
    } 
     
    if(isset($data['request']['owner'])) 
     {
	     $fieldset->addField('owner', 'text', array(
	          'label'     => Mage::helper('informationservice')->__('Owner'),
	          'class'     => 'required-entry',
	          'readonly'  => true,
	      	  'disabled' => true,
	          'name'      => 'owner',
	      ));
     }
     else 
     {
     	 $fieldset->addField('owner_id', 'select', array(
          'label'     => Mage::helper('informationservice')->__('Owner'),
          'name'      => 'request[owner_id]',
          'values'    =>Mage::helper('informationservice')->getUsernamesAsOptionArray(),
         ));
     }

     
     $requesttype = Mage::getModel('informationservice/requesttype');
    $fieldset->addField('input_type', 'select', array(
          'label'     => Mage::helper('informationservice')->__('Request Type'),
          'name'      => 'request[input_type]',
          'values'    => $requesttype->getInputTypesAsOptionArray(),
    'disabled' => $isclosed,
         ));
         
       $fieldset->addField('output_type', 'select', array(
          'label'     => Mage::helper('informationservice')->__('Answer Type'),
          'name'      => 'request[output_type]',
          'values'    => $requesttype->getOutputTypesAsOptionArray(),
       'disabled' => $isclosed,
         ));

     

      
      
      $fieldset->addField('cost', 'text', array(
          'label'     => Mage::helper('informationservice')->__('Cost expected'),     
          'name'      => 'request[cost]',
      	  'disabled' => $isclosed,
      	  'after_element_html' => " ". Mage::helper('informationservice')->__('Time Unit'),
      ));
     
      
      
      //die bisherigen Kosten
      $data['request']['aufwand'] = 0;
      $data['request']['aufwandPreis'] = 0;
      if($this->getRequest()->getParam('id'))
      {
      		$data['request']['aufwand'] = Mage::getModel('informationservice/task')->getTotalCost($this->getRequest()->getParam('id'));
      		$fieldset->addField('aufwand', 'label', array(
	          'label'     => Mage::helper('informationservice')->__('Real Cost'),       
	          'name'      => 'aufwand',
      			'after_element_html' => " ". Mage::helper('informationservice')->__('Time Unit')
	      	));
	      	
      	
     	
      		$fieldset->addField('aufwandPreis', 'label', array(
	          'label'     => Mage::helper('informationservice')->__('Calculated Price'),       
	          'name'      => 'aufwandPreis',
      		'after_element_html' =>' Euro',
	      	));
	      	
	      	$data['request']['aufwandPreis'] = $data['request']['aufwand'] * Mage::getStoreConfig('informationservice/price/price_per_time');
      }
      
     
     $fieldset = $form->addFieldset('product_request_form', array('legend'=>Mage::helper('informationservice')->__('Result Product')));
      
     //falls es bereits ein Product gibt
     if(isset($data['request']['result_product_id'])&&(intval($data['request']['result_product_id'])!= 0))
     {
	      $fieldset->addField('result_product_id', 'hidden', array(   
	          'name'      => 'request[result_product_id]',
	      
	      ));

	     $product = Mage::getModel('catalog/product')->load($data['request']['result_product_id']); 
	      
	     $fieldset->addField('result_product_name', 'text', array(
	          'label'     => Mage::helper('informationservice')->__('Product Name'),       
	          'name'      => 'result_product_name',
	      	  'readonly'  => true,
	      	  'disabled' => true,
	      ));
	      
	     $urlModel = Mage::getModel('core/url')->setStore('default');
	     $fieldset->addField('result_product_url', 'note', array(
	          'label'     => Mage::helper('informationservice')->__('Product Url'),       
	          'name'      => 'result_product_url',
	          'text'	  => $urlModel->getUrl($product -> getUrlPath(),array('_current'=>false)),		
	      ));
	      
	     $fieldset->addField('result_product_link', 'button', array(
	          'label'     => Mage::helper('informationservice')->__('Edit Product'),       
	          'name'      => 'result_product_link',
			  'onclick'		=> "setLocation('".$this->getUrl('adminhtml/catalog_product/edit',array('id'=>$product->getId()))."')",
	      ));
	      
	   	 $data['request']['result_product_link'] = Mage::helper('informationservice')->__('Edit Product');
	     $data['request']['result_product_name'] = $product -> getName();
	     
	     //$data['request']['result_product_url'] = $urlModel->getUrl($product -> getUrlPath(),array('_current'=>false));
	      
     }
     //falls es noch kein Product gibt
     else if(!$isclosed)
     {

     	$this->_createProduct = true;
     		$fieldset->addField('result_master', 'select', array(
	          	'label'     => Mage::helper('informationservice')->__('Master Product'),       
	          	'name'      => 'request[result_master]',
     			'options'  => Mage::getModel('informationservice/requestmasterproduct')->getMasterProductsAsOptionArray(),
	      		'disabled' => $isclosed,
     			'onclick' => "selectProduct();", 	
      		));
     	
      		$fieldset->addField('result_titel', 'text', array(
	          	'label'     => Mage::helper('informationservice')->__('Title'),       
	          	'name'      => 'request[result_price]',
	      		'disabled' => $isclosed,
      		));
     	
      		
     	    $fieldset->addField('result_price', 'text', array(
	          	'label'     => Mage::helper('informationservice')->__('Price'),       
	          	'name'      => 'request[result_price]',
	      		'disabled' => $isclosed,
      		));
      
	     $fieldset->addField('result_product_link', 'button', array(
	          'value'     => Mage::helper('informationservice')->__('Create Product'),       
	          'name'      => 'result_product_link',
			  'onclick'		=> "createProduct();",
	     	 'disabled'	=> true,	
	      ));
	      
	     $data['request']['result_product_link'] = Mage::helper('informationservice')->__('Create Product');
  	}

  	 $fieldset = $form->addFieldset('order_request_form', array('legend'=>Mage::helper('informationservice')->__('Order Information')));
 
  	
     $fieldset->addField('order_increment_id', 'text', array(
          	'label'     => Mage::helper('informationservice')->__('Sales Order Id'),      
          	'name'      => 'request[order_increment_id]',
     		'disabled' => $isclosed,
      ));
      
      
      
      if ( Mage::getSingleton('adminhtml/session')->getInformationserviceData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getInformationserviceData());
          Mage::getSingleton('adminhtml/session')->setInformationserviceData(null);
      } elseif ( Mage::registry('request_data') ) {
          $form->setValues($data['request']);
      }
      
    
      return parent::_prepareForm();
  }
  
  
	protected function _afterToHtml($html)
	{	
		if($this->_createProduct)
		{
			$html .= "
			 <script type=\"text/javascript\">
            //<![CDATA[
 				function createProduct()
 				{
 					new Ajax.Updater('product_request_form', '".$this->getUrl('adminhtml/informationservice_product/create')."', {
					  parameters: { result_master: \$F('result_master'), 
					  	result_titel: \$F('result_titel'),
					  	result_price: \$F('result_price')
						}
					});
 				}
 							
 				function selectProduct()
 				{
 					$('result_product_link').enable();
 				}
            //]]>
            </script>";
		}
		
		return $html;
	}
  
}