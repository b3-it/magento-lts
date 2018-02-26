<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Agreement
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Master_Agreement extends Bkg_License_Model_Master_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_license/master_agreement');
    }
}