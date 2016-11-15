<?php
/**
 * Sid Haushalt
 *
 *
 * @category   	Sid
 * @package    	Sid_Haushalt
 * @name       	Sid_Haushalt_Model_Resource_Lg04Pool_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Haushalt_Model_Mysql4_Lg04Pool_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sidhaushalt/lg04pool');
    }
}
