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
        			'class'     => 'save',
        	), -100);
        	
	        $this->_addButton('pdf', array(
	        		'label'     => Mage::helper('adminhtml')->__('Create Pdf'),
	        		'onclick'   => 'createPdfAndContinueEdit()',
	        		'class'     => 'save',
	        ), -100);
	        
	        $id = Mage::registry('entity_data')->getId();
	        $this->_addButton('newtext', array(
	        		'label'     => Mage::helper('adminhtml')->__('Process Template'),
	        		'onclick'   => 'processTextAndContinueEdit()',
	        		'class'     => 'save',
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
        	
        	function dFilter(data)
        	{
        	    alert(data);
        	    return data;
        	}
        	
        	function previewPdf()
        	{
        	
        	    var url = '{$this->getUrl('*/*/previewPdf',array('id'=>$id))}';
        		setLocation(url);
        		return;
        	    var oReq = new XMLHttpRequest();
                oReq.open(\"POST\", '{$this->getUrl('*/*/previewPdf',array('id'=>$id))}');
                oReq.onload = function(e) {
                  var arraybuffer = oReq.response; // not responseText
                  /* ... */
                }
                oReq.send();
                
        	    return;
        	
        		  \$j.ajax({
      					url: '{$this->getUrl('*/*/previewPdf',array('id'=>$id))}',
     					methode: 'post',
     					data: {'content': \$j('#text_content').val()},
     					dataType: 'text',
     					mimeType: 'application/pdf',
     					success: function(data, textStatus, jqXHR)
                                {
                                var binary = \"\";
                                var responseText = jqXHR.responseText;
                                    var responseTextLen = responseText.length;
                                  for ( i = 0; i < responseTextLen; i++ ) {
                                        binary += String.fromCharCode(responseText.charCodeAt(i) & 255)
                                    }
                                //data = btoa(binary);
                                console.log(data);
                                   // alert(data);
                                   var blob = new Blob([binary], {encoding:'UTF-8', type: 'application/pdf;charset=UTF-8' });
					        var link = document.createElement('a');
					        link.href = window.URL.createObjectURL(blob);
					        link.download = '{$this->__('Preview')}.pdf';
					
					        document.body.appendChild(link);
					
					        link.click();
					
					        document.body.removeChild(link);
					        window.URL.revokeObjectURL(link);
                                   
                                    return binary;
                                },
     					processData: false,
     					//cache: false,
     					//contents: 'application/pdf;charset=UTF-8',
      					
   				 	})
   				 	.done(function(result) {		 	
   				 	
   				 			//result = unicodeBase64Decode(result);
        					//alert(result);
        					return;
        					var blob = new Blob([result], {encoding:'UTF-8', type: 'application/pdf;charset=UTF-8' });
					        var link = document.createElement('a');
					        link.href = window.URL.createObjectURL(blob);
					        link.download = '{$this->__('Preview')}.pdf';
					
					        document.body.appendChild(link);
					
					        link.click();
					
					        document.body.removeChild(link);
					        window.URL.revokeObjectURL(link);
      				})
      				.fail(function(xhr,texterror){
      						alert(texterror);
      				});
        	
        		return;
        	
        	
        		var url = '{$this->getUrl('*/*/previewPdf',array('id'=>$id))}';
        		setLocation(url);
        		return;
        	}
        	function unicodeBase64Decode(text)
			{
			return window.atob(text);
				return decodeURIComponent(Array.prototype.map.call(window.atob(text),function(c){
					return \"%\"+(\"00\"+c.charCodeAt(0).toString(16)).slice(-2)
				}
				).join(\"\"))
			}
						
        	function switchIsOrgunit()
        	{
        		var orgunit = \$j('#is_orgunit option:selected').val();
        		if(orgunit == 0)
        		{
        			\$j('#customer').show();
        			\$j('#orgunit').hide();
        		}
        		else
        		{
        			\$j('#customer').hide();
        			\$j('#orgunit').show();
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


}
