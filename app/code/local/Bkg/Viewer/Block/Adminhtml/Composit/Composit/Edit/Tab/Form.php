<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Composit_Composit_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Composit_Composit_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);


      $composit = Mage::registry('compositcomposit_data');

      $fieldset = $form->addFieldset('navi', array('legend'=>Mage::helper('bkgviewer')->__('Composit')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Name'),
          'required'  => true,

          'name'      => 'title',
          'value'	=> $composit->getTitle() ? $composit->getTitle() : Mage::helper('bkgviewer')->__('Navigation'),
          //'onchange'  => 'onchangeTransferType()',

      ));


      $fieldset = $form->addFieldset('navi_layers', array('legend'=>Mage::helper('bkgviewer')->__('Layers available')));

      $services = Mage::getModel('bkgviewer/service_service')->getCollection();



      $fieldset->addField('service', 'select', array(
          'label'     => Mage::helper('bkgviewer')->__('Service'),
          //'required'  => true,
          //'values'    => $this->getPages(),
          'name'      => 'service',
          'value'	=> '',
          'options' => $services->getAsFormOptions(true),
          'onchange'  => 'reloadLayer()',

      ));


      $fieldset->addField('service_layers', 'select', array(
          'label'     => Mage::helper('bkgviewer')->__('Layer'),
          //'required'  => true,
          //'values'    => $this->getPages(),
          'name'      => 'service_layers',
          'value'	=> '',
          'onchange'  => 'setTitle()',

      ));

      
      $fieldset->addField('layer_title', 'text', array(
      		'label'     => Mage::helper('bkgviewer')->__('Title'),
      		//'required'  => true,
      		//'values'    => $this->getPages(),
      		'name'      => 'layer_title',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      ));
      
      $fieldset->addField('permanent', 'checkbox', array(
          'label'     => Mage::helper('bkgviewer')->__('Permanent'),
          //'required'  => true,
          //'values'    => $this->getPages(),
          'name'      => 'permanent',
          'value'	=> ''
          //'onchange'  => 'onchangeTransferType()',

      ));
      
      $fieldset->addField('is_checked', 'checkbox', array(
      		'label'     => Mage::helper('bkgviewer')->__('Checked'),
      		//'required'  => true,
      		//'values'    => $this->getPages(),
      		'name'      => 'is_checked',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      ));



//       $fieldset->addField('entity_layer', 'checkbox', array(
//           'label'     => Mage::helper('bkgviewer')->__('entity layer'),
//           //'required'  => true,
//           //'values'    => $this->getPages(),
//           'name'      => 'entity_layer',
//           'value'	=> ''
//           //'onchange'  => 'onchangeTransferType()',

//       ));

      $fieldset->addField('visual_pos', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Z-Index'),
          //'required'  => true,
          //'values'    => $this->getPages(),
          'name'      => 'visual_pos',
          'value'	=> '10'
          //'onchange'  => 'onchangeTransferType()',

      ));



      $fieldset->addField ( 'copy_cms_pages', 'button', array (
          'value' => Mage::helper ( 'bkgviewer' )->__ ( 'Insert' ),
          'name' => 'copy_cms_pages',
          'onclick' => "addPages();",
          'class'	=> 'form-button',
          'label' => Mage::helper ( 'bkgviewer' )->__ ( 'Copy selected Layer to Navigation' ),
      ) );

      $fieldset->addField ( 'use_tool', 'button', array (
          'value' => Mage::helper ( 'bkgviewer' )->__ ( 'Use' ),
          'name' => 'copy_values',
          'onclick' => "addToolLayer();",
          'class'	=> 'form-button',
          'label' => Mage::helper ( 'bkgviewer' )->__ ( 'Use selected Layer as Tool' ),
      ) );


      return parent::_prepareForm();
  }

    public function getPages()
    {
        $collection = Mage::getModel('cms/page')->getCollection();
        $res = array();
        foreach ($collection as $item)
        {
            $res[] = array('value' => $item->getPageId(),'label' => $item->getTitle());
        }
        return $res;
    }

   
}
