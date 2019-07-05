<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Model_Kassenbuch_Journal_items
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Model_Kassenbuch_Journalitems extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('gka_barkasse/kassenbuch_journalitems');
    }
    
    public function setNumber()
    {
    	$this->getResource()->setNumber($this->getId(),$this->getJournalId());
    }
    
    protected function _afterSave()
    {
    	if($this->getNumber() == 0){
    		$this->setNumber();
    	}
    	 
    	parent::_afterSave();
    }
}