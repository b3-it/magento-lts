<?php

class Dwd_Stationen_Block_Adminhtml_Derivation_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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

      $form->setUseContainer(true);
      $this->setForm($form);
      $fieldset = $form->addFieldset('derivation_form', array('legend'=>Mage::helper('stationen')->__('Derivation information')));
     
      $data = $this->getFormData();
      
      
      
      $fieldset->addField('parent_id', 'hidden', array(
          'name'      => 'parent_id',
      ));
      
     $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('stationen')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
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

	  
        $categoriesField = $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('stationen')->__('Category'),
          'name'      => 'category_id',
          'values'    => Mage::helper('stationen')->getCategoriesAsOptionArray(),
      ));
      if ($categoriesField) {
	  	$categoriesField->setRenderer(
	  			$this->getLayout()->createBlock('informationservice/adminhtml_widget_form_renderer_fieldset_selectlevels')
	  	);		
      }
	  
      $fieldset->addField('lon', 'text', array(
          'label'     => Mage::helper('stationen')->__('Longitude'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'lon',
      ));
      
	  $fieldset->addField('lat', 'text', array(
          'label'     => Mage::helper('stationen')->__('Latitude'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'lat',
      ));
      

  
     $fieldset->addField('height', 'text', array(
          'label'     => Mage::helper('stationen')->__('Height NN'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'height',
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
      
      
     $form->setValues($this->getFormData());
      
      return parent::_prepareForm();
  }
  
  public function getFormData()
  {
  		$res = array();
  		if ( Mage::getSingleton('adminhtml/session')->getStationenData() )
	      {
	          $res = Mage::getSingleton('adminhtml/session')->getStationenData();
	          Mage::getSingleton('adminhtml/session')->setStationenData(null);
	      } elseif ( Mage::registry('derivation_data') ) {
	          $res = Mage::registry('derivation_data')->getData();
	      }
	      
	      return $res;
  }
  
}