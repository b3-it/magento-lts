<?php
/**
 * Sid_Cms Navi
 *
 *
 * @category   	Sid_Cms
 * @package    	Sid_Cms_Navi
 * @name       	Sid_Cms_Model_Resource_Node
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Model_Resource_Node extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the navi_node_id refers to the key field in your database table.
        $this->_init('sidcms/navigation_node', 'id');
    }
}
