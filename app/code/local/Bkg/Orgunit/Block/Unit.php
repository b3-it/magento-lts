<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_Unit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_Unit extends Mage_Core_Block_Template
{
  	public function _prepareLayout()
    {
  		return parent::_prepareLayout();
    }

     public function getUnit()
     {
        if (!$this->hasData('unit')) {
            $this->setData('unit', Mage::registry('unit_data'));
        }
        return $this->getData('unit');
    }
}
