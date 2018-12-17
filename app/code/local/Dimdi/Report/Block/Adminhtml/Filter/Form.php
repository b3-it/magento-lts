<?php
/**
 * Dimdi Report
 *
 *
 * @category   	Dimdi
 * @package    	Dimdi Report
 * @name        Dimdi_Report_Block_Adminhtml_Filter_Form
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Block_Adminhtml_Filter_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/index', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'get',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);

      
      $fieldset = $form->addFieldset('access_form', array('legend'=>Mage::helper('dimdireport')->__('Filter')));
     $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      
      $fieldset->addField('from', 'date', array(
            'name'      => 'from',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'label'     => Mage::helper('dimdireport')->__('From'),
            'title'     => Mage::helper('dimdireport')->__('From'),
            'required'  => true,
      		'class' => 'validate-datetime',
      		'value'		=> $this->getRequest()->getParam('from')
        ));

        $fieldset->addField('to', 'date', array(
            'name'      => 'to',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'label'     => Mage::helper('dimdireport')->__('To'),
            'title'     => Mage::helper('dimdireport')->__('To'),
            'required'  => true,
        	'class' => 'validate-datetime',
        	'value'		=> $this->getRequest()->getParam('to')
        ));
      
   
      
     
        
      return parent::_prepareForm();
  }
  
 	
}