<?php
/**
 *
 * @category   	Bkg Shapefile
 * @package    	Bkg_Shapefile
 * @name       	Bkg_Viewer_Block_ServiceService
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Shapefile_Block_Adminhtml_File extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        //var_dump($this);
        $this->_controller = 'adminhtml_file';
        $this->_blockGroup = 'bkg_shapefile';
        $this->_headerText = Mage::helper('bkg_shapefile')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('bkg_shapefile')->__('Add Item');
        parent::__construct();
    }
}