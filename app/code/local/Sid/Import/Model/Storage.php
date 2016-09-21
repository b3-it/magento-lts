<?php
/**
 * Sid Import
 *
 *
 * @category   	Sid
 * @package    	Sid_Import
 * @name       	Sid_Import_Model_Storage
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Import_Model_Storage extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sidimport/storage');
    }
}
