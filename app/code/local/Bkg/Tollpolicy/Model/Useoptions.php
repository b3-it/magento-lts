<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Model_Use_options_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Model_Useoptions extends Bkg_Tollpolicy_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_tollpolicy/useoptions');
    }
}
