<?php

class Sid_Framecontract_Block_Adminhtml_Contract_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('contract_form', array('legend'=>Mage::helper('framecontract')->__('Contract Information')));
     
      //Falls die StoreIsolation an ist werden die möglichen Stores beschränkt
      if(Mage::helper('core')->isModuleEnabled('Egovs_Isolation')){
      	$fieldset->addField('store_id', 'select', array(
      			'label' => Mage::helper('catalog')->__('Store'),
      			'title' => Mage::helper('catalog')->__('Store'),
      			'name'  => 'store_id',
      			'value' => '',
      			'values'=> Mage::getModel('isolation/entity_attribute_source_storegroups')->getOptionArray()
      	));
      }else {
      	$tmp =$this->__getUserStoreGroups();
      	$stores = array();
      	foreach($tmp as $k => $v){
      		$stores[] = array('value'=>$k,'label' => $v);
      	}
      	
      	$fieldset->addField('store_id', 'select', array(
      			'label'     => Mage::helper('framecontract')->__('Store'),
      			'required'  => true,
      			'values'    => $stores,
      			'name'      => 'store_id',
      	));
      }
      
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      
      $fieldset->addField('contractnumber', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Number'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'contractnumber',
      ));

      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('start_date', 'date', array(
          'label'     => Mage::helper('framecontract')->__('Start Date'),
          'required'  => true,
          'name'      => 'start_date',
      	  'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
	      'image'  => $this->getSkinUrl('images/grid-cal.gif'),
	      'format'       => $dateFormatIso
	  ));
	  
	  
	  $fieldset->addField('end_date', 'date', array(
          'label'     => Mage::helper('framecontract')->__('Stop Date'),
          'required'  => true,
          'name'      => 'end_date',
	  	  'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
	      'image'  => $this->getSkinUrl('images/grid-cal.gif'),
	      'format'       => $dateFormatIso
	  ));
	  
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('framecontract')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('framecontract')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('framecontract')->__('Disabled'),
              ),
          ),
      ));
      
 	  
   
      
	  $fieldset = $form->addFieldset('vendor_form', array('legend'=>Mage::helper('framecontract')->__('Vendor Information')));
	  
	  $productCount = count(Mage::registry('contract_data')->getProductIds());
	  if($productCount > 0)
	  {
		  	$fieldset->addField('framecontract_vendor_id', 'hidden', array(
		  			'name'      => 'framecontract_vendor_id',
		  	));
		  	
		  	$fieldset->addField('framecontract_vendor_id_1', 'select', array(
		  			'label'     => Mage::helper('framecontract')->__('Vendor'),
		  			'disabled'  => true,
		  			'class'		=> 'disabled',
		  			'values'    => Mage::getModel('framecontract/vendor')->toSelectArray(),
		  			'name'      => 'framecontract_vendor_id_1',
		  	));
		  	Mage::registry('contract_data')->setData('framecontract_vendor_id_1',Mage::registry('contract_data')->getData('framecontract_vendor_id'));
	  }
	  else
	  {
		  $fieldset->addField('framecontract_vendor_id', 'select', array(
	          'label'     => Mage::helper('framecontract')->__('Vendor'),
	          'required'  => true,
		  	  'values'    => Mage::getModel('framecontract/vendor')->toSelectArray(),
	          'name'      => 'framecontract_vendor_id',
		  ));
	  }
	  
	 $fieldset->addField('operator', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Operator'),
          'required'  => false,
          'name'      => 'operator',
	  ));
	  
	  
	  $fieldset->addField('order_email', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Order EMail Address'),
          'required'  => false,
          'name'      => 'order_email',
	  ));
	  
	  
  	$fieldset = $form->addFieldset('detail_form', array('legend'=>Mage::helper('framecontract')->__('Contract Details')));
    	    
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('framecontract')->__('Content'),
          'title'     => Mage::helper('framecontract')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getFramecontractData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getFramecontractData());
          Mage::getSingleton('adminhtml/session')->setFramecontractData(null);
      } elseif ( Mage::registry('contract_data') ) {
          $form->setValues(Mage::registry('contract_data')->getData());
      }
      return parent::_prepareForm();
  }
  

  	/**
  	 * Liefert User Groups aus Store Isolation
  	 * 
  	 * @return array
  	 */
  	private function __getUserStoreGroups()
  	{
  		if (!Mage::helper('core')->isModuleEnabled('Egovs_Isolation')) {
  			$stores = Mage::getModel('adminhtml/system_config_source_store')->toOptionArray();
  			$tmp = array();
  			foreach ($stores as $store) {
  				$tmp[$store['value']] = $store['label'];
  			}
  			return $tmp;
  		}
  		
  		if( Mage::helper('isolation')->getUserIsAdmin())
  		{
  			$storeGroups = array();
  			foreach(Mage::getModel('adminhtml/system_store')->getGroupCollection()  as $storegroup)
  			{
  				$storeGroups[$storegroup->getId()] = $storegroup->getName();
  			}
  			return $storeGroups;
  		}

  		return  Mage::helper('isolation')->getUserStoreGroups();
  	}
  
}