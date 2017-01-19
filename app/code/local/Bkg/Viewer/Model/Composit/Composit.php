<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Composit_Composit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Model_Composit_Composit extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/composit_composit');
    }
    
    public function getLayers()
    {
    	$collection = Mage::getModel('bkgviewer/composit_layer')->getCollection;
    	$collection->getSelect()->where('composit_id = '.$this->getId());
    	
    	return $collection->getItems();
    }
}
