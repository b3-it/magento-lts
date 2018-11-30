<?php
/**
 *
 *  Edit Formular für pdf Template
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Block_Adminhtml_Template_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        
        if (!$this->hasData('template')) {
        	$this->setTemplate('egovs/pdftemplate/form/container.phtml');
        }
        $this->_objectId = 'id';
        $this->_blockGroup = 'pdftemplate';
        $this->_controller = 'adminhtml_template';
        
        $this->_updateButton('save', 'label', Mage::helper('pdftemplate')->__('Save Template'));
        $this->_updateButton('delete', 'label', Mage::helper('pdftemplate')->__('Delete Template'));
		
        if( Mage::registry('template_data') && Mage::registry('template_data')->getId() ) 
        {
        	
        	
        	
        	/*
        	
	        $this->_addButton('preview', array(
	            'label'     => Mage::helper('adminhtml')->__('Preview'),
	            'onclick'   => 'setLocation(\'' . $this->getPreviewUrl() . '\')',
	            //'class'     => 'back',
	        	'popup' 	=> '1'
	        ), -1);
	        */
	        $this->_addButton('duplicate', array(
	            'label'     => Mage::helper('pdftemplate')->__('Duplicate'),
	            'onclick'   => 'setLocation(\'' . $this->getDublicateUrl() . '\')',
	            //'class'     => 'back',
	        	'popup' 	=> '1'
	        ), -1);
			
   		}
        
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('template_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'template_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'template_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getPreviewUrl()
    {
    	$id = "";
    	if( Mage::registry('template_data') && Mage::registry('template_data')->getId() ) 
    	{
    		$id = Mage::registry('template_data')->getId();
    	}
    	return $this->getUrl('*/*/preview',array('id'=>$id));
    }
    
   public function getDublicateUrl()
    {
    	$id = "";
    	if( Mage::registry('template_data') && Mage::registry('template_data')->getId() ) 
    	{
    		$id = Mage::registry('template_data')->getId();
    	}
    	return $this->getUrl('*/*/dublicate',array('id'=>$id));
    }
    public function getHeaderText()
    {
        if( Mage::registry('template_data') && Mage::registry('template_data')->getId() ) {
            return Mage::helper('pdftemplate')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('template_data')->getTitle()));
        } else {
            return Mage::helper('pdftemplate')->__('Add Item');
        }
    }
	
    public function canPreview()
    {
    	return Mage::registry('template_data') && Mage::registry('template_data')->getId();
    }
    
    public function getPreviewStoreHtml()
    {
    	$block = $this->getLayout()->createBlock('pdftemplate/adminhtml_template_edit_switcher');
    	$html = $block->toHtml();;
    	return $html;
    }
    
    
    /**
     * Check whether it is single store mode
     *
     * @return bool
     */
    public function isSingleStoreMode()
    {
    	if (!Mage::app()->isSingleStoreMode()) {
    		return false;
    	}
    	return true;
    }
}