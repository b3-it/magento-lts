<?php
/**
 *
 * @category   	Bkg Virtualaccess
 * @package    	Bkg_Virtualaccess
 * @name       	Bkg_Virtualaccess_Model_Periodical_Abo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Periodical_Abo extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_virtualaccess/periodical_abo');
    }
}
