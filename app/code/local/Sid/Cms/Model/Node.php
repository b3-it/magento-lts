<?php
/**
 * Sid_Cms Navi
 *
 *
 * @category   	Sid_Cms
 * @package    	Sid_Cms_Navi
 * @name       	Sid_Cms_Model_Node
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Model_Node extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sidcms/node');
    }
}
