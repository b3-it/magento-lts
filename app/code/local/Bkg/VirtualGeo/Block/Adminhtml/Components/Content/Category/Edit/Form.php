<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Content_Categoryentity_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Content_Category_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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

      $dataModel = Mage::registry('components_content_category_entity_data');

      $fieldset = $form->addFieldset('componentscontent_category_entity_form', array('legend'=>Mage::helper('virtualgeo')->__('Components Content Category')));

      $fieldset->addField('pos', 'text', array(
          'label'     => Mage::helper('virtualgeo')->__('Position'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'pos',
      	  'value'	=> $dataModel->getPos()
      ));

  	$fieldset->addField('label', 'text', array(
  			'label'     => Mage::helper('virtualgeo')->__('Label'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'label',
  			'value'	=> $dataModel->getLabel()
  	));

  




      return parent::_prepareForm();

  }
}
