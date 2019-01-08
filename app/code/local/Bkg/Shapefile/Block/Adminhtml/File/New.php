<?php
/**
 * 
 *  Formular zum _Hinzufügen eines neuen WMS
 *  @category Egovs
 *  @package  Bkg_Shapefile
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Shapefile_Block_Adminhtml_File_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_mode = 'new';
        $this->_blockGroup = 'bkg_shapefile';
        $this->_controller = 'adminhtml_file';
        
        //$this->_updateButton('save', 'label', Mage::helper('bkgviewer')->__('Continue'));
        
		$this->removeButton('delete');	
		$this->removeButton('reset');
    }

    public function getHeaderText()
    {
        return Mage::helper('bkg_shapefile')->__('Upload Files');
    }
	
	
}