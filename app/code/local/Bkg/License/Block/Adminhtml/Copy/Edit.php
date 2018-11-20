<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bkg_license';
        $this->_controller = 'adminhtml_copy';

        $this->_updateButton('save', 'label', Mage::helper('bkg_license')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('bkg_license')->__('Delete Item'));


        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        
        $id = Mage::registry('entity_data')->getId();
        if($id)
        {
       
        	$this->_addButton('previewpdf', array(
        			'label'     => Mage::helper('adminhtml')->__('Preview Pdf'),
        			'onclick'   => 'previewPdf(); return false;',
        			//'class'     => 'save',
        	), -100);
        	
	        $this->_addButton('pdf', array(
	        		'label'     => Mage::helper('adminhtml')->__('Create Pdf'),
	        		'onclick'   => 'createPdfAndContinueEdit()',
	        		//'class'     => 'save',
	        ), -100);
	        
	        $id = Mage::registry('entity_data')->getId();
	        $this->_addButton('newtext', array(
	        		'label'     => Mage::helper('adminhtml')->__('Process Template'),
	        		'onclick'   => 'processTextAndContinueEdit()',
	        		//'class'     => 'save',
	        ), -100);

           
        
        }
        
        
        $toll_url = $this->getUrl('adminhtml/license_master/toll',array('id'=>'cat_id'));
        $use_url = $this->getUrl('adminhtml/license_master/use',array('id'=>'use_id'));
        $option_url = $this->getUrl('adminhtml/license_master/option',array('id'=>'opt_id'));
        
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        		
        	function createPdfAndContinueEdit(){
                editForm.submit($('edit_form').action+'createPdf/edit/');
            }
        		
        	function processTextAndContinueEdit(){
                editForm.submit($('edit_form').action+'processTemplate/edit/');
            }
        	
        	
        	
        	function previewPdf()
        	{
        		\$j('#preview_pdf_content').val(\$j('#text_content').val());
        		\$j('#preview_pdf_form').submit();
        		
        	    //var url = '{$this->getUrl('*/*/previewPdf',array('id'=>$id))}';
        		//setLocation(url);
        		
        		return;
        	  
        	}
        			
        	function switchIsOrgunit()
        	{
        		var orgunit = \$j('#is_orgunit option:selected').val();
        		if(orgunit == 0)
        		{
        			\$j('#customer').show();
        			\$j('#orgunit').hide();
        			\$j('#customer').addClass(\"required-entry\");
        			\$j('#orgunit').removeClass(\"required-entry\");
        			\$j('label[for=\"customer\"]').show();
        			\$j('label[for=\"orgunit\"]').hide();
        		}
        		else
        		{
        			\$j('#customer').hide();
        			\$j('#orgunit').show();
        			\$j('#customer').removeClass(\"required-entry\");
        			\$j('#orgunit').addClass(\"required-entry\");
        			\$j('label[for=\"customer\"]').hide();
        			\$j('label[for=\"orgunit\"]').show();
        		}
        	}
        	
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
                if (tinyMCE.getInstanceById('page_template') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'text_template');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'text_template');
                }
            }
        				
        	function toogleSubscription()
			{
			    var elements = ['initial_period_length','initial_period_unit','period_length','period_unit','renewal_offset'];
        		if(\$j('#subscripe').is(':checked'))
        		{
        		    elements.forEach(function(elem)
        		    {
        		        \$j('#'+elem).parent().parent().show();
        			    \$j('#'+elem).show();
        			    \$j('#'+elem).addClass('required-entry');
        		    });
        		}
        		else
        		{
        		    elements.forEach(function(elem)
        		    {
        		        \$j('#'+elem).parent().parent().hide();
        			    \$j('#'+elem).hide();
        			    \$j('#'+elem).removeClass('required-entry');
        		    });
        		}
			}
        	toogleSubscription();
            
            switchIsOrgunit();
		 ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('entity_data') && Mage::registry('entity_data')->getId() ) {
            return Mage::helper('bkg_license')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('entity_data')->getName()));
        } else {
            return Mage::helper('bkg_license')->__('Add Item');
        }
    }
    
    protected function _prepareLayout()
    {
    	// Load Wysiwyg on demand and Prepare layout
    	if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled() && ($block = $this->getLayout()->getBlock('head'))) {
    		$block->setCanLoadTinyMce(true);
    	}
    	return parent::_prepareLayout();
    }

    protected function _toHtml()
    {
    	//dummy Form für pdf preview anhängen
    	$id = Mage::registry('entity_data')->getId();
    	$html = parent::_toHtml();
    	$html .= "<form id='preview_pdf_form' action='{$this->getUrl('*/*/previewPdf',array('id'=>$id))}' enctype='multipart/form-data' method='POST'><input name='form_key' value='{$this->getFormKey()}' type='hidden'><input id='preview_pdf_content' name='preview_pdf_content' type='hidden'/> </form>";
    	
    	return $html;
    }

}
