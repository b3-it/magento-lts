<?php
 /**
  *
  * @category   	Gka Barkasse
  * @package    	Gka_Barkasse
  * @name       	Gka_Barkasse_Model_Resource_Kassenbuch_Journalitems
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Barkasse_Model_Resource_Kassenbuch_Journalitems extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('gka_barkasse/kassenbuch_journal_items', 'id');
    }
    
    
    public function setNumber($id,$journalId)
    {
    	$write   = $this->_getWriteAdapter();
    	$table = $this->getTable('gka_barkasse/kassenbuch_journal_items');
    	$expr = new Zend_Db_Expr('(SELECT t.max_number from (SELECT max(number)+1 as max_number from '.$table.' WHERE journal_id='.$journalId.' ) t)');
    	$write->update($table, array('number' => $expr),'id = '.$id);
    }
    
    
}
