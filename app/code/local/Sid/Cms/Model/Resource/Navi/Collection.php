<?php
/**
 * Sid Cms
 *
 *
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Model_Resource_Navi_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Model_Resource_Navi_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sidcms/navi');
    }
}
