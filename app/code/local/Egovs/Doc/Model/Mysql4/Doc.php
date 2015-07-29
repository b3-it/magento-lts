<?php
/**
 * Verwalten von Dokumenten im Webshop.
 *
 * @category	Egovs
 * @package		Egovs_Doc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Doc_Model_Mysql4_Doc extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the doc_id refers to the key field in your database table.
        $this->_init('egovs_doc/doc', 'doc_id');
    }
}