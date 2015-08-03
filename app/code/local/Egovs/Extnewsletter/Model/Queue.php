<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Egovs_Extnewsletter_Model_Queue
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extnewsletter_Model_Queue extends Mage_Newsletter_Model_Queue
{

    /**
     * Send messages to subscribers for this queue
     *
     * @param   int     $count
     * @param   array   $additionalVariables
     * @return Mage_Newsletter_Model_Queue
     */
    public function sendPerSubscriber($count=20, array $additionalVariables=array())
    {
        if($this->getQueueStatus()!=self::STATUS_SENDING
           && ($this->getQueueStatus()!=self::STATUS_NEVER && $this->getQueueStartAt())
        ) {
            return $this;
        }

        if ($this->getSubscribersCollection()->getSize() == 0) {
            $this->_finishQueue();
            return $this;
        }

        $collection = $this->getSubscribersCollection()
            ->useOnlyUnsent()
            ->showCustomerInfo()
            ->setPageSize($count)
            ->setCurPage(1)
            ->load();

        /* @var $sender Mage_Core_Model_Email_Template */
        $sender = Mage::getModel('core/email_template');
        $sender->setSenderName($this->getNewsletterSenderName())
            ->setSenderEmail($this->getNewsletterSenderEmail())
            ->setTemplateType(self::TYPE_HTML)
            ->setTemplateSubject($this->getNewsletterSubject())
            ->setTemplateText($this->getNewsletterText())
            ->setTemplateStyles($this->getNewsletterStyles())
            ->setTemplateFilter(Mage::helper('newsletter')->getTemplateProcessor());

        $issue =  Mage::getModel('extnewsletter/issue');
        foreach($collection->getItems() as $item) {
            $email = $item->getSubscriberEmail();
            $name = $item->getSubscriberFullName();

            $sender->emulateDesign($item->getStoreId());
            $successSend = $sender->send($email, $name, array('subscriber' => $item));
            $sender->revertDesign();

            if($successSend) {
                $item->received($this);
                $issue->removeSubscriberFromIssue($this->getId(), $item->getSubscriberId());
            } else {
                $problem = Mage::getModel('newsletter/problem');
                $notification = Mage::helper('newsletter')->__('Please refer to exeption.log');
                $problem->addSubscriberData($item)
                    ->addQueueData($this)
                    ->addErrorData(new Exception($notification))
                    ->save();
                $item->received($this);
            }
        }

        if(count($collection->getItems()) < $count-1 || count($collection->getItems()) == 0) {
            $this->_finishQueue();
        }
        return $this;
    }

  
}
