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
class Bkg_License_Block_Adminhtml_Test_Search extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bkg_license';
        $this->_controller = 'adminhtml_test';
        $this->_mode = 'search';

        $this->_updateButton('save', 'label', Mage::helper('bkg_license')->__('Create Copy License'));
        $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/license_test/index') . '\');');
         
        $this->_removeButton('delete');
        //$this->_removeButton('back');
        $this->_removeButton('reset');


        
     
    }

    public function getHeaderText()
    {
       return Mage::helper('bkg_license')->__('License');
    }
    
    


}
