<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Composit_Composit_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Composit_Composit_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bkgviewer';
        $this->_controller = 'adminhtml_composit_composit';

        $this->_updateButton('save', 'label', Mage::helper('bkgviewer')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('bkgviewer')->__('Delete Item'));


        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

       	$url = $this->getUrl('adminhtml/viewer_service_service/layers',array('id'=>'layer_id'));
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        		
        	function reloadLayer()
			{
        		var url = '".$url."';
				var id = \$j('#service option:selected').val();
        		url = url.replace('layer_id',id);
        		//alert(url);
        		\$j.getJSON(url, function(data) {
				    \$j('#service_layers option').remove();
				    \$j.each(data, function(){
				        \$j('#service_layers').append(new Option(this.name,this.value));
					})
        		})	
				
			}	
        	
        	function setTitle()
			{
				var data = \$j('#service_layers option:selected').text();
        		\$j('#layer_title').val(data);
			}	
        	
        	
        	
        ";
    }
    
    protected function _getLayersUrl($id)
    {
    	return $this->getUrl('adminhtml/viewer_service_service/layers',array('id'=>$id));
    }

    public function getHeaderText()
    {
        if( Mage::registry('compositcomposit_data') && Mage::registry('compositcomposit_data')->getId() ) {
            return Mage::helper('bkgviewer')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('compositcomposit_data')->getTitle()));
        } else {
            return Mage::helper('bkgviewer')->__('Add Item');
        }
    }


}
