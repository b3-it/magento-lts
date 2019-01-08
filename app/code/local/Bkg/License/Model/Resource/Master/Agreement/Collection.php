<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Resource_Agreement_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Resource_Master_Agreement_Collection extends Bkg_License_Model_Resource_Master_AbstractCollection
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_license/master_agreement');
    }
}
