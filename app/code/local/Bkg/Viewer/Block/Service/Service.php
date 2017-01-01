<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Service
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Service extends Mage_Core_Model_Abstract
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getService()
     {
        if (!$this->hasData('service')) {
            $this->setData('service', Mage::registry('service'));
        }
        return $this->getData('service');

    }
}
