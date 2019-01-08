<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Resource_Master_AbstractCollection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Resource_Master_AbstractCollection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function addMasterIdFilter($master_id)
    {
        $this->getSelect()->where('master_id ='. intval($master_id));
    }
}
