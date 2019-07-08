<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Helper_Data
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function sendEmail($template, $storeId = 0, Mage_Sales_Model_Quote $quote = null)
    {
        /**
         * Break if Quote is missing
         */
        if($quote == null){
            return $this;
        }

        /**
         * Get TemplateId with Name or as Number
         */
        if (is_numeric($template)) {
            $templateId = $template;
            unset($template);
        } else {
            $templateId = Mage::getStoreConfig($template, $storeId);
        }

        $sender = [];
        $sender['name'] = Mage::getStoreConfig("eventmanager/participation_agreement_email/sender_name", $storeId);
        $sender['email'] = Mage::getStoreConfig("eventmanager/participation_agreement_email/sender_email_address", $storeId);

        if (strlen($sender['name']) < 2) {
            $sender['name'] = Mage::getStoreConfig('trans_email/ident_general/name', $storeId);
        }

        if (strlen($sender['email']) < 2) {
            $sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email', $storeId);
        }

        /** @var Mage_Core_Model_Email_Info $emailInfo */
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo($quote->getCustomerEmail(), $quote->getCustomerFirstname() . ' ' . $quote->getCustomerMiddlename() . ' ' . $quote->getCustomerLastname());

        /** @var Mage_Core_Model_Translate $translate */
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);

        /** @var Egovs_Base_Model_Core_Email_Template_Mailer $mailer */
        $mailer = Mage::getModel('egovsbase/core_email_mailer');
        $mailer->addEmailInfo($emailInfo);
        $mailer->setSender($sender);
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams([]);

        try {
            /** @var Egovs_Base_Model_Core_Email_Queue $emailQueue */
            $emailQueue = Mage::getModel('egovsbase/core_email_queue');
            $emailQueue->setEntityId($participant->getId())
                ->setEntityType('participant')
                ->setEventType('participation_certificate')
                ->setIsForceCheck(true);

            $mailer->setQueue($emailQueue)->send();
        } catch (Exception $ex) {
            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
            Mage::logException($ex);
        }

        return $this;
    }
}
