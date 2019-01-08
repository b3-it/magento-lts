<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Test_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bkg_license';
        $this->_controller = 'adminhtml_test';

        $this->_updateButton('save', 'label', Mage::helper('bkg_license')->__('Search License'));
        
        $this->_removeButton('delete');
        $this->_removeButton('back');
        $this->_removeButton('reset');


        $toll_url = $this->getUrl('adminhtml/license_master/toll',array('id'=>'cat_id'));
        $use_url = $this->getUrl('adminhtml/license_master/use',array('id'=>'use_id'));
        $option_url = $this->getUrl('adminhtml/license_master/option',array('id'=>'opt_id'));
        
        $this->_formScripts[] = "
        	
        	function reloadToll()
			{
        		var url = '".$toll_url."';
				var id = \$j('#tollcategory option:selected').val();
        		url = url.replace('cat_id',id);
        		
        		\$j.getJSON(url, function(data) {
				    \$j('#toll option').remove();
				    \$j.each(data, function(){
				        \$j('#toll').append(new Option(this.label,this.value));
					})
        		})	
				
			}	
   			
        	function reloadUse()
			{
        		var url = '".$use_url."';
				var id = \$j('#toll option:selected').val();
        		url = url.replace('use_id',id);
        		
        		\$j.getJSON(url, function(data) {
				    \$j('#tolluse option').remove();
				    \$j.each(data, function(){
				        \$j('#tolluse').append(new Option(this.label,this.value));
					})
        		})	
				
			}	
        				
        	function reloadUseOpt()
			{
        		var url = '".$option_url."';
				var id = \$j('#tolluse option:selected').val();
        		url = url.replace('opt_id',id);
        		
        		\$j.getJSON(url, function(data) {
				    \$j('#tolloption option').remove();
				    \$j.each(data, function(){
				        \$j('#tolloption').append(new Option(this.label,this.value));
					})
        		})	
				
			}	
        		
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'text_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'text_content');
                }
            }
		 ";
    }

    public function getHeaderText()
    {
        return Mage::helper('bkg_license')->__('Search Parameters');
    }
    
    protected function _prepareLayout()
    {
    	// Load Wysiwyg on demand and Prepare layout
    	if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled() && ($block = $this->getLayout()->getBlock('head'))) {
    		$block->setCanLoadTinyMce(true);
    	}
    	return parent::_prepareLayout();
    }


}
