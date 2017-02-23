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

class Bkg_Viewer_Block_Adminhtml_Service_Service_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/import', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      
      $form->setUseContainer(true);
      $this->setForm($form);
      
      $fieldset = $form->addFieldset('navi_form', array('legend'=>Mage::helper('bkgviewer')->__('WMS Information')));
      $fieldset->addField('url', 'text', array(
      		'label'     => Mage::helper('bkgviewer')->__('Url'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'url',
      		'value'	=> 'http://localhost.local/bestand_niedersachsen_wms.xml',
      		'note'	=> 'getCapabilities'
      ));
    
 
      
      
      return parent::_prepareForm();
  }
}