<?php
/**
 *
 * Visitors reports Model
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Sales_Pbc extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('extreport/sales_pbc');
    } 

}