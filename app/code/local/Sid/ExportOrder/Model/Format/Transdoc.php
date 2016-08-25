<?php
/**
 * Sid ExportOrder_Format
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Format_Model_Transdoc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Transdoc extends Sid_ExportOrder_Model_Format
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/format_transdoc');
    }
    
    public function processOrder($order)
    {
    	 
    }
}
