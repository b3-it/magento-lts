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
    protected $_eventbunlde_order_item  = null;
    protected $_lecture_order_items  = null;

    public function getSignatureImage()
    {
        return Mage::helper('eventmanager')->getSignaturePath() . DS . $this->getEvent()->getSignatureFilename();
    }

    /**
     * gibt das OrderItem des Eventbundles zurück
     * @return Mage_Core_Model_Abstract|null
     */
    public function getEventbundleOrderItem()
    {
        if($this->_eventbunlde_order_item == null) {
            $id = 0;
            if ($this->getParticipant()) {
                $id = $this->getParticipant()->getOrderItemId();
            }
            $this->_eventbunlde_order_item = Mage::getModel('sales/order_item')->load($id);
        }
        return $this->_eventbunlde_order_item;
    }

    /**
     * gibt alle Teilveranstaltungen zurück die in der Teilnahmebestätigung erscheinen sollen
     * @return array|null
     */
    public function getLectureOrderItems()
    {
        if($this->_lecture_order_items == null) {
            $this->_lecture_order_items = array();
            $id = 0;
            if ($this->getParticipant()) {
                $id = $this->getParticipant()->getOrderItemId();
            }
            $collection = Mage::getModel('sales/order_item')->getCollection();
            $collection->getSelect()
                    ->where('parent_item_id = ?',$id)
                    ->where('use4_participation_certificate = 1');

            foreach($collection->getItems() as $item)
            {
                $this->_lecture_order_items[] = $item;
            }

        }
        return $this->_lecture_order_items;
    }

}
