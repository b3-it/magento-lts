<?php

/**
 * @category       B3it Solr
 * @package        B3it_Solr
 * @name           B3it_Solr_Helper_Data
 * @author         Holger Kögel <h.koegel@b3-it.de>
 * @copyright      Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license        http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Query variable name
     */
    const QUERY_VAR_NAME = 'q';

    /**
     * Retrieve HTML escaped search query
     *
     * @return string
     */
    public function getEscapedQueryText()
    {
        return $this->escapeHtml($this->getQueryText());
    }

    /**
     * @param $data
     * @return bool
     */
    public function toIndex($data)
    {
        $client = new B3it_Solr_Model_Webservice_Solr();

        $doc = new B3it_Solr_Model_Webservice_Input_Document();
        foreach ($data as $d) {
            $doc->addField($d['field'], $d['value']);
        }
        return $client->addDocument($doc);
    }

    /**
     * Retrieve result page url and set "secure" param to avoid confirm
     * message when we submit form from secure page to insecure
     *
     * @param string $query
     * @return  string
     */
    public function getResultUrl($query = null)
    {
        return $this->_getUrl('b3it_solr/search/index', array(
            '_query' => ['q' => $query],
            '_secure' => $this->_getApp()->getFrontController()->getRequest()->isSecure()
        ));
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getSuggestUrl()
    {
        return $this->_getUrl('b3it_solr/search/suggest', array(
            '_secure' => $this->_getApp()->getStore()->isCurrentlySecure()
        ));
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getFacetUrl()
    {
        return $this->_getUrl('b3it_solr/facet/facet', array(
            '_secure' => $this->_getApp()->getStore()->isCurrentlySecure()
        ));
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getSolrIndexUrl()
    {
        /** @var Mage_Adminhtml_Model_Url $UrlSingleton */
        $UrlSingleton = Mage::getSingleton('adminhtml/url');

        return $this->_getUrl('adminhtml/solr/reIndex', array(
            '_secure' => $this->_getApp()->getStore()->isCurrentlySecure(),
            Mage_Adminhtml_Model_Url::SECRET_KEY_PARAM_NAME => $UrlSingleton->getSecretKey('solr', 'reIndex')
        ));
    }


    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getSolrClearUrl()
    {
        /** @var Mage_Adminhtml_Model_Url $UrlSingleton */
        $UrlSingleton = Mage::getSingleton('adminhtml/url');

        return $this->_getUrl('adminhtml/solr/clear', array(
            '_secure' => $this->_getApp()->getStore()->isCurrentlySecure(),
            Mage_Adminhtml_Model_Url::SECRET_KEY_PARAM_NAME => $UrlSingleton->getSecretKey('solr', 'clear')
        ));
    }

    /**
     * Retrieve search query text
     *
     * @return string
     */
    public function getQueryText()
    {
        if (!isset($this->_queryText)) {
            $this->_queryText = $this->_getRequest()->getParam($this->getQueryParamName());
            if ($this->_queryText === null) {
                $this->_queryText = '';
            } else {
                /* @var $stringHelper Mage_Core_Helper_String */
                $stringHelper = Mage::helper('core/string');
                $this->_queryText = is_array($this->_queryText) ? ''
                    : $stringHelper->cleanString(trim($this->_queryText));

                $maxQueryLength = $this->getMaxQueryLength();
                if ($maxQueryLength !== '' && $stringHelper->strlen($this->_queryText) > $maxQueryLength) {
                    $this->_queryText = $stringHelper->substr($this->_queryText, 0, $maxQueryLength);
                }
            }
        }
        return $this->_queryText;
    }

    /**
     * Retrieve maximum query length
     *
     * @param mixed $store
     * @return int|string
     */
    public function getMaxQueryLength($store = null)
    {
        return Mage::getStoreConfig('solr_general/search_options/max_query_length', $store);
    }

    public function getQueryParamName()
    {
        return self::QUERY_VAR_NAME;
    }

    /**
     * Get App
     *
     * @return Mage_Core_Model_App
     */
    protected function _getApp()
    {
        return Mage::app();
    }

    /**
     * Get Facets
     *
     * @return array
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getFacetConfiguration()
    {
        $config = Mage::getStoreConfig('solr_general/search_options/facets', mage::app()->getStore()->getId());
        if ($config) {
            $config = unserialize($config);
            if (is_array($config)) {
                return $config;
            }
        }

        return [];
    }

    /**
     * @param $attribute
     * @return string
     * @throws Mage_Core_Exception
     */
    public function getDynamicField($attribute)
    {
        if ($attribute == 'type') {
            return '';
        }

        if (is_string($attribute)) {
            /** @var Mage_Catalog_Model_Entity_Attribute $eavModel */
            $eavModel = Mage::getModel('eav/entity_attribute');
            $attribute = $eavModel->loadByCode(Mage_Catalog_Model_Product::ENTITY, $attribute);
        }

        if (!empty($attribute['backend_type']) && !empty($attribute['frontend_input'])) {

            $type = $attribute['backend_type'];
            $input = $attribute['frontend_input'];

            if ($input == 'select' || $input == 'boolean' || $input == 'text') {
                return '_string';
            }

            if ($type == 'decimal') {
                return '_decimal';
            }

            if ($input == 'date') {
                return '_date';
            }

            if ($input == 'textarea' || $input == 'multiselect') {
                return '_text';
            }

            return '_UNIDENTIFIED_string';
        }

        return '_empty';
    }

    /**
     * @return mixed|string
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function _getAdminEmail()
    {
        $email = Mage::getStoreConfig('solr_security/solr_connection/email_adress', mage::app()->getStore()->getId());
        if (trim($email) !== '') {
            return $email;
        }
        return '';
    }

    /**
     * @return mixed|string
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function _getSenderEmail()
    {
        $email = Mage::getStoreConfig('solr_security/solr_connection/email_sender', mage::app()->getStore()->getId());
        if (trim($email) !== '') {
            return $email;
        }
        return '';
    }

    /**
     * @return mixed|string
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function _getSenderName()
    {
        $name = Mage::getStoreConfig('solr_security/solr_connection/email_sender_name', mage::app()->getStore()->getId());
        if (trim($name) !== '') {
            return $name;
        }
        return '';
    }

    /**
     * @param $body
     * @param string $subject
     * @throws Mage_Core_Model_Store_Exception
     */
    public function sendMailToAdmin($body, $subject = 'Solr Fehler - Verbindungstest')
    {
        if ($body != '') {
            /** @var Mage_Core_Model_Email $mail */
            $mail = Mage::getModel('core/email');
            $mailTo = $this->_getAdminEmail();
            $shopName = Mage::getStoreConfig('general/imprint/shop_name');
            $body = sprintf("Shop Name: %s\nWebsite: %s\n\n%s", $shopName, Mage::getBaseUrl(), $body);

            $mail->setBody($body);
            $mail->setToEmail($mailTo);

            $sender = array();
            $sender['name'] = $this->_getSenderName();
            $sender['email'] = $this->_getSenderEmail();

            if (strlen($sender['name']) < 2) {
                Mage::log('Solr Server Connection Test::Email send-name in configuration not defined', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            }

            if (strlen($sender['email']) < 2) {
                Mage::log('Solr Server Connection Test::Email send-email in configuration not defined', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            }

            $mail->setFromEmail($sender['email']);
            $mail->setFromName($sender['name']);


            $mail->setSubject($subject);
            try {
                $mail->send();
            } catch (Exception $ex) {
                $error = ('Unable to send email.');

                if (isset($ex)) {
                    Mage::log($error . ": {$ex->getTraceAsString()}", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
                } else {
                    Mage::log($error, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
                }
            }
        }
    }
}
