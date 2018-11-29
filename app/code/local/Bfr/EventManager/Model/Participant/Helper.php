<?php
/**
 * Bfr EventManager Pdf
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Participant_Helper
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Participant_Helper extends Varien_Object
{

    public function getSignatureImage()
    {
        return Mage::helper('eventmanager')->getSignaturePath() . DS . $this->getEvent()->getSignatureFilename();
    }


}
