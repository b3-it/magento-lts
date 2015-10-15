<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Dwd
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Dwd_Abomigration_Block_Adminhtml_Abomigration_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abomigration_form', array('legend'=>Mage::helper('abomigration')->__('Details')));
     
      $helper = Mage::helper('abomigration');
      
      $fieldset->addField('website_id', 'select', array(
      		'name'     => 'website_id',
      		'title'    => $helper->__('Website'),
      		'label'    => $helper->__('Website'),
      		'required' => true,
      		'values'   => Mage::getSingleton('adminhtml/system_config_source_website')->toOptionArray()
      ));
      
      $fieldset->addField('store_id', 'select', array(
      		'name'     => 'store_id',
      		'title'    => $helper->__('Store'),
      		'label'    => $helper->__('Store'),
      		'required' => true,
      		'values'   => Mage::getSingleton('adminhtml/system_config_source_store')->toOptionArray()
      ));
    
      $customer = Mage::getModel('customer/customer')->load($this->getSessionData('customer_id'));

      if($customer->getId())
      {
		  $fieldset->addField('customer_id', 'text', array(
	          'label'     => $helper->__('Customer Id'),
	          'class'     => 'readonly',
	          'readonly'  => true,
	          'name'      => 'customer_id',
	      ));	
	
			
			$addresses = $customer->getAddresses();
					
			$adroptions= array();
			$adroptions[] = array('value'=>0,'label'=>'');
			foreach($addresses as $adr)
			{
				$name = $adr->getPrefix().' '.$adr->getFirstname().' '.$adr->getLastname() .' '.implode(" ",$adr->getStreet()).' '.$adr->getCity().' '.$adr->getPostcode();
				$name = trim($name);
				$adroptions[] = array('value'=>$adr->getId(),'label'=>$name);
			}
			
     		
		$fieldset->addField('address_id', 'select', array(
          'label'     => $helper->__('Address'),
          'class'     => 'readonly',
          'readonly'  => true,
          'name'      => 'address_id',
		  'values' => $adroptions,
      ));	

  	}	
  	else 
  	{
		$fieldset->addField('create_customer', 'select', array(
          'label'     => $helper->__('Create Customer'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
          'name'      => 'create_customer',
      	));
  	}	
			
		$fieldset->addField('firstname', 'text', array(
          'label'     => $helper->__('Firstname'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'firstname',
      ));		
		$fieldset->addField('lastname', 'text', array(
          'label'     => $helper->__('Lastname'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'lastname',
      ));		
		$fieldset->addField('company1', 'text', array(
          'label'     => $helper->__('Company 1'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'company1',
      ));		
		$fieldset->addField('company2', 'text', array(
          'label'     => $helper->__('Company 2'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'company2',
      ));		
		$fieldset->addField('street', 'text', array(
          'label'     => $helper->__('Street'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'street',
      ));	

		$fieldset->addField('telephone', 'text', array(
				'label'     => $helper->__('Telephone'),
				//'class'     => 'readonly',
				//'readonly'  => true,
				'name'      => 'telephone',
		));
		
		$fieldset->addField('city', 'text', array(
          'label'     => $helper->__('City'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'city',
      ));		
		$fieldset->addField('postcode', 'text', array(
          'label'     => $helper->__('Postcode'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'postcode',
      ));		
		$fieldset->addField('country', 'text', array(
          'label'     => $helper->__('Country'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'country',
      ));		
		$fieldset->addField('email', 'text', array(
          'label'     => $helper->__('Email'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'email',
      ));		
		
			
		
	 $field = $fieldset->addField('pwd_shop', 'text', array(
          'label'     => $helper->__('Password Shop'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'pwd_shop',
	 	  'style' => 'width:150px !important;'	,
	 	  'after_element_html'	 => $this->getHtmlNewPwdButton($this->getSessionData('email'), 'pwd_shop')
      ));	

	
			
		$fieldset->addField('username_ldap', 'text', array(
          'label'     => $helper->__('Username Ldap'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'username_ldap',
      ));		
	
		$fieldset->addField('pwd_ldap', 'text', array(
				'label'     => $helper->__('Password Ldap'),
				//'class'     => 'readonly',
				//'readonly'  => true,
				'name'      => 'pwd_ldap',
				'style' => 'width:150px !important;'	,
				'after_element_html'	 => $this->getHtmlNewPwdButton($this->getSessionData('username_ldap'), 'pwd_ldap')
		));
     	
		 $fieldset->addField('product_id', 'select', array(
            'name'     => 'product_id',
            'title'    => $helper->__('Product'),
            'label'    => $helper->__('Product'),
            'required' => true,
            'values'   => Mage::getSingleton('abomigration/system_config_source_products')->toOptionHashArray()
        	));	
		 
		
		$collection = Mage::getModel('stationen/stationen')->getCollection();
		$stationen = array();
		$stationen[] = array('value'=>0, 'label'=> '');
		foreach($collection->getItems() as $st)
		{
			$stationen[] = array('value'=>$st->getId(), 'label'=> $st->getStationskennung());
		}
		
		
		$fieldset->addField('station1', 'select', array(
          'label'     => $helper->__('Station 1'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'station1',
		  'values'   => $stationen,
      ));		
		$fieldset->addField('station2', 'select', array(
          'label'     => $helper->__('Station 2'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'station2',
		'values'   => $stationen,
      ));		
		$fieldset->addField('station3', 'select', array(
          'label'     => $helper->__('Station 3'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'station3',
		'values'   => $stationen,
      ));		
			
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$fieldset->addField('period_end', 'date', array(
          'label'     => $helper->__('Period End'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'period_end',
				'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
				'class'     => 'readonly',
				'readonly'  => true,
				'format'       => $dateFormatIso,
				'image'  => $this->getSkinUrl('images/grid-cal.gif'),

      ));		
		$fieldset->addField('customer_informed', 'date', array(
          'label'     => $helper->__('Customer informed'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'customer_informed',
		  'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
			'class'     => 'readonly',
			'readonly'  => true,
			'format'       => $dateFormatIso,
			'image'  => $this->getSkinUrl('images/grid-cal.gif'),
      ));		
		
		$fieldset->addField('error', 'select', array(
          'label'     => $helper->__('Error'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'error',
		 'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
      ));		
		$fieldset->addField('error_text', 'text', array(
          'label'     => $helper->__('Error Text'),
          //'class'     => 'readonly',
          //'readonly'  => true,
          'name'      => 'error_text',
      ));
      if ( Mage::getSingleton('adminhtml/session')->getAbomigrationData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAbomigrationData());
          Mage::getSingleton('adminhtml/session')->setAbomigrationData(null);
      } elseif ( Mage::registry('abomigration_data') ) {
          $form->setValues(Mage::registry('abomigration_data')->getData());
      }
      return parent::_prepareForm();
  }
  
  
  protected function getSessionData($key = null)
  {
  	$res = null;
  	if ( Mage::getSingleton('adminhtml/session')->getAbomigrationData() )
  	{
  		$res = Mage::getSingleton('adminhtml/session')->getAbomigrationData();
  		
  	} elseif ( Mage::registry('abomigration_data') ) {
  		$res =  Mage::registry('abomigration_data')->getData();
  	}
  	
  	
  	if($res && $key)
  	{
  		if(isset ($res[$key]))
  		{
  			return $res[$key];
  		}
  	}
  	
  	return $res;
  }
  
  
  protected function getHtmlNewPwdButton($user, $html_id)
  {
  	
  		$url = $this->getUrl('/*/pwd');
  		$html = '<button type="button" onclick="new Ajax.Request( \''.$url.'\', { method: \'get\', onSuccess: update'.$html_id.'  });">Neu</button>';
  		$html .= '<script> function update'.$html_id.'(response){ $(\''.$html_id.'\').value=response.responseText;} </script>';
  		
  		
  		return $html;
  }
  
}