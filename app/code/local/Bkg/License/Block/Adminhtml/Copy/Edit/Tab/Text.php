<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Text
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Text  extends Mage_Adminhtml_Block_Widget_Form
{
	
	protected function _prepareLayout()
	{
		parent::_prepareLayout();
		$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);

	}
	
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('entity_form', array('legend'=>Mage::helper('bkg_license')->__('Text Information')));

      $form->setHtmlIdPrefix('text_');
      
      $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
       
      $wysiwygConfig->setEnabled(true);
      
      $wysiwygConfig->setAddWidgets(false);
      $wysiwygConfig->setAddVariables(true);
      $wysiwygConfig->setAddImages(false);

        $templateField = $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'style'     => 'height:36em;',
            //'required'  => true,
            'config'    => $wysiwygConfig,
            'value' => Mage::registry('entity_data')->getContent()
        ));
  }
   
}
