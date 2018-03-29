<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name       	Bkg_Regionallocation_Block_Adminhtml_Koenigsteinerschluessel_Kstvalue_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_RegionAllocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tab_Kstvalue_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'regionallocation';
        $this->_controller = 'adminhtml_koenigsteinerschluessel_kst_edit_tab_kstvalue';

        $this->_updateButton('save', 'label', Mage::helper('regionallocation')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('regionallocation')->__('Delete Item'));

        $id = intval($this->getRequest()->getParam('id'));
        
        $url = $this->getUrl('*/regionallocation_koenigsteinerschluessel_kstvalue/save',array('id'=>$id));
       // $url = "setLocation('".$url."');";
        //$this->_updateButton('save','onclick',$url );
        
      //  $this->setFormActionUrl($url);
        
        
        $url = $this->getUrl('*/regionallocation_koenigsteinerschluessel_kstvalue/delete',array('id'=>$id));
        $url = "setLocation('".$url."');";
        $this->_updateButton('delete','onclick',$url );
    
    }

    public function getHeaderText()
    {
        if( Mage::registry('koenigsteinerschluesselkst_value_data') && Mage::registry('koenigsteinerschluesselkst_value_data')->getId() ) {
            return Mage::helper('regionallocation')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('koenigsteinerschluesselkst_value_data')->getId()));
        } else {
            return Mage::helper('regionallocation')->__('Add Item');
        }
    }


}
