<?php

class Dwd_Stationen_Block_Adminhtml_Stationen_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('stationen_form', array('legend'=>Mage::helper('stationen')->__('Station information')));
     
      $data = $this->getStData();
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('stationen')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
      if(isset($data['entity_id']) && ($data['entity_id'] != null))
      {
	     $fieldset->addField('stationskennung', 'text', array(
	          'label'     => Mage::helper('stationen')->__('Stationskennung'),
	          //'class'     => 'required-entry',
	          //'disabled'	  => 'true',
	     	  'class'	  => 'disabled',
	          'name'      => 'stationskennung',
	      ));
      }
      else 
      {
      	  $fieldset->addField('stationskennung', 'text', array(
	          'label'     => Mage::helper('stationen')->__('Stationskennung'),
	          'class'     => 'required-entry',
	          'required'  => true,
	          'name'      => 'stationskennung',
	      ));
      }
      
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('avail_from', 'date', array(
          'label'     => Mage::helper('stationen')->__('Start Date'),
          'required'  => true,
      	  'class'     => 'required-entry',
          'name'      => 'avail_from',
      	  'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
	      'image'  => $this->getSkinUrl('images/grid-cal.gif'),
	      'format'       => $dateFormatIso
	  ));
      
    $fieldset->addField('avail_to', 'date', array(
          'label'     => Mage::helper('stationen')->__('End Date'),
          //'required'  => true,
   		  //'class'     => 'required-entry',
          'name'      => 'avail_to',
      	  'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
	      'image'  => $this->getSkinUrl('images/grid-cal.gif'),
	      'format'       => $dateFormatIso
	  ));

	  $fieldset->addField('lat', 'text', array(
          'label'     => Mage::helper('stationen')->__('Latitude'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'lat',
      ));
	  
	  $fieldset->addField('lon', 'text', array(
          'label'     => Mage::helper('stationen')->__('Longitude'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'lon',
      ));
  
      

      

     $fieldset->addField('height', 'text', array(
          'label'     => Mage::helper('stationen')->__('Height NN'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'height',
      ));
		
      /*
      $fieldset->addField('overwrite', 'select', array(
          'label'     => Mage::helper('stationen')->__('Overwrite'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'overwrite',
          'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
      ));
      */
      
      if(isset($data['entity_id']) && ($data['entity_id'] != null))
      {  
	      $fieldset->addField('mirakel_id', 'text', array(
	          'label'     => Mage::helper('stationen')->__('Mirakel Id'),
	          'disabled'  => 'true',
	     	  'class'	  => 'disabled',
	          'name'      => 'mirakel_id',
	      ));
      }
      else 
      {
      		$fieldset->addField('mirakel_id', 'text', array(
	          'label'     => Mage::helper('stationen')->__('Mirakel Id'),
	          'class'     => 'required-entry',
          	  'required'  => true,
	          'name'      => 'mirakel_id',
	      ));
      }
      $filter = Mage::getModel('stationen/entity_attribute_source_filter'); 
      $filter->setConfigKey('messnetz');
      $fieldset->addField('messnetz', 'select', array(
          'label'     => Mage::helper('stationen')->__('Messnetz'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'messnetz',
      	  'values'  => $filter->getAllOptions()
      ));
 
      $filter->setConfigKey('styp');
      $fieldset->addField('styp', 'select', array(
          'label'     => Mage::helper('stationen')->__('styp'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'styp',
      	  'values'  => $filter->getAllOptions()
      ));
      
      
      $filter->setConfigKey('ktyp');     
      $fieldset->addField('ktyp', 'select', array(
          'label'     => Mage::helper('stationen')->__('ktyp'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'ktyp',
          'values'  => $filter->getAllOptions()
      ));
      
      $fieldset->addField('region', 'text', array(
          'label'     => Mage::helper('stationen')->__('Region'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'region',
      ));
      
      $fieldset->addField('landkreis', 'text', array(
          'label'     => Mage::helper('stationen')->__('Landkreis'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'landkreis',
      ));
      
      $fieldset->addField('gemeinde', 'text', array(
          'label'     => Mage::helper('stationen')->__('Gemeinde'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'gemeinde',
      ));
      
  
      
            $fieldset->addField('land', 'text', array(
          'label'     => Mage::helper('stationen')->__('Land'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'land',
      ));
      
      $stat = Dwd_Stationen_Model_Stationen_Status::getOptionHashArray();
      array_pop($stat);
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('stationen')->__('Status'),
          'name'      => 'status',
          'values'    => $stat,
      ));
     
      $fieldset->addField('short_description', 'editor', array(
          'name'      => 'short_description',
          'label'     => Mage::helper('stationen')->__('Short Description'),
          'title'     => Mage::helper('stationen')->__('Short Description'),
          'style'     => 'width:700px; height:200px;',
          'wysiwyg'   => false,
          //'required'  => true,
      ));
      
      $fieldset->addField('description', 'editor', array(
          'name'      => 'description',
          'label'     => Mage::helper('stationen')->__('Description'),
          'title'     => Mage::helper('stationen')->__('Description'),
          'style'     => 'width:700px; height:200px;',
          'wysiwyg'   => false,
          //'required'  => true,
      ));
     
      $form->setValues($data);
      
      return parent::_prepareForm();
  }
  
  private function getStData()
  {
  	 $res = array();
  	if ( Mage::getSingleton('adminhtml/session')->getStationenData() )
      {
          $res = Mage::getSingleton('adminhtml/session')->getStationenData();
          Mage::getSingleton('adminhtml/session')->setStationenData(null);
      } elseif ( Mage::registry('stationen_data') ) {
         $res = Mage::registry('stationen_data')->getData();
      }
      
      return $res;
  }
  
}