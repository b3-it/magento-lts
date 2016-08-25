<?php
/**
 * Sid ExportOrder_Format
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Format_Model_Resource_Transdoc_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Resource_Format_Transdoc_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder_format/transdoc');
    }
}
