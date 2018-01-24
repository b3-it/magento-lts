<?php
 /**
  *
  * @category   	Bkg Tollpolicy
  * @package    	Bkg_Tollpolicy
  * @name       	Bkg_Tollpolicy_Model_Resource_Tollentity
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Tollpolicy_Model_Resource_Toll extends Bkg_Tollpolicy_Model_Resource_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('bkg_tollpolicy/toll_entity', 'id');
    }
}
