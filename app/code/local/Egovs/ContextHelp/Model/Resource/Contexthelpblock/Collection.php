<?php
/**
 *
 * @category   	Egovs ContextHelp
 * @package    	Egovs_ContextHelp
 * @name       	Egovs_ContextHelp_Model_Resource_Contexthelp_block_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Model_Resource_Contexthelpblock_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('contexthelp/contexthelpblock');
    }
}
