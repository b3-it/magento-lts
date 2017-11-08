<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_Kassenbuch_Journal
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Kassenbuch_Journal_Prelogout extends Mage_Core_Block_Template
{
	
  	public function _prepareLayout()
    {
  		return parent::_prepareLayout();
    }

    /**
     * Retrieve customer logout url
     *
     * @return string
     */
    public function getLogoutUrl()
    {
        return $this->getUrl('customer/account/logout');
    }
    
    
    /**
     * Retrieve Journal url
     *
     * @return string
     */
    public function getJournalUrl()
    {
    	return $this->getUrl('gka_barkasse/kassenbuch_journal/index');
    }

}
