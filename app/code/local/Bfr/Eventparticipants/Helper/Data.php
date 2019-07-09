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
    public function sendEmail($templateConfigPath, $storeId = 0, Mage_Sales_Model_Quote_Item $item = null, $hash = null)
    {
        /**
         * Break if Item or Hash is missing
         */
        if($item == null || $hash == null){
            Mage::log('\nBfr_Eventparticipants :: Missing Item or Hash in sendMail!\n');
            return $this;
        }

        $template = Mage::getStoreConfig($templateConfigPath, $storeId);
        if($template == null){
            Mage::log('\nBfr_Eventparticipants :: Missing Template in sendMail! Check Configuration!\n');
            return $this;
        }

        $sender = [];
        $sender['name'] = Mage::getStoreConfig("eventmanager/participation_agreement_email/email_sender", $storeId);
        $sender['email'] = Mage::getStoreConfig("eventmanager/participation_agreement_email/email_address", $storeId);

        if (strlen($sender['name']) < 2) {
            $sender['name'] = Mage::getStoreConfig('trans_email/ident_general/name', $storeId);
        }

        if (strlen($sender['email']) < 2) {
            $sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email', $storeId);
        }

        /** @var Mage_Core_Model_Email_Info $emailInfo */
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo($item->getQuote()->getCustomerEmail(), $item->getQuote()->getCustomerFirstname() . ' ' . $item->getQuote()->getCustomerMiddlename() . ' ' . $item->getQuote()->getCustomerLastname());

        /** @var Mage_Core_Model_Translate $translate */
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);

        /** @var Egovs_Base_Model_Core_Email_Template_Mailer $mailer */
        $mailer = Mage::getModel('egovsbase/core_email_template_mailer');
        $mailer->addEmailInfo($emailInfo);
        $mailer->setSender($sender);
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($template);
        $mailer->setTemplateParams(['eventName' => $item->getName(), 'eventHash' => $hash, 'eventHashLink' => Mage::getBaseUrl() . '/' . $hash]);

        try {
            $emailQueue = Mage::getModel('egovsbase/core_email_queue');
            $emailQueue->setEntityId($item->getQuote()->getId())
                ->setEntityType('participant')
                ->setEventType('participation_agreement')
                ->setIsForceCheck(true);

            $mailer->setQueue($emailQueue)->send();
        } catch (Exception $ex) {
            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
            Mage::logException($ex);
        }

        return $this;
    }
}
