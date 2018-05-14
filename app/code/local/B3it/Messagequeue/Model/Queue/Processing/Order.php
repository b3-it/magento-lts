<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Messagequeue
 * @name       	B3it_Messagequeue_Model_Queue_Processing_Order
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Queue_Processing_Order extends Mage_Core_Model_Abstract
implements B3it_Messagequeue_Model_Queue_Processing_Interface
{
    public function preProccessing($ruleset,$message,$data)
    {
        //testen ob Regel gilt:
        foreach($ruleset->getRules() as $rule)
        {
            
        }

    }

    public function proccessing($message)
    {

    }
}
