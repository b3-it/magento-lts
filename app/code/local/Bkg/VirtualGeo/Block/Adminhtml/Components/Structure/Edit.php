<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Structureentity_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Structure_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'virtualgeo';
        $this->_controller = 'adminhtml_components_structure';

        $this->_updateButton('save', 'label', Mage::helper('virtualgeo')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('virtualgeo')->__('Delete Item'));


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
				    \$j('#layer_id option').remove();
				    \$j.each(data, function(){
				        \$j('#layer_id').append(new Option(this.name,this.value));
					})
        		})	
				
			}	
        				
        	function toogleLayer()
			{
        		if(\$j('#show_layer').is(':checked'))
        		{
        			\$j('#service').show();
        			\$j('#layer_id').show();
        		}
        		else
        		{
        			\$j('#service').hide();
        			\$j('#layer_id').hide();
        		}
			}
        				
        				toogleLayer();
        ";
        
    }

    public function getHeaderText()
    {
        if( Mage::registry('componentsstructure_entity_data') && Mage::registry('componentsstructure_entity_data')->getId() ) {
            return Mage::helper('virtualgeo')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('componentsstructure_entity_data')->getId()));
        } else {
            return Mage::helper('virtualgeo')->__('Add Item');
        }
    }


}
