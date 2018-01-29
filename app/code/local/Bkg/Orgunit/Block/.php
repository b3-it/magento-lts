<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_ extends Mage_Core_Block_Template
{
  	public function _prepareLayout()
    {
  		return parent::_prepareLayout();
    }

     public function get()
     {
        if (!$this->hasData('')) {
            $this->setData('', Mage::registry('_data'));
        }
        return $this->getData('');
    }
}
