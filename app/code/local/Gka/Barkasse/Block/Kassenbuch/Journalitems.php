<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_Kassenbuch_Journalitems
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Kassenbuch_Journalitems extends Mage_Core_Block_Template
{
  	public function _prepareLayout()
    {
  		return parent::_prepareLayout();
    }

     public function getBackUrl()
     {
     	return $this->getUrl('gka_barkasse/kassenbuch_journal/index');
     }
}
