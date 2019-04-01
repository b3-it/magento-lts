<?php
class Egovs_Base_Model_Observer
{
    private $_demoPath = 'design/head/demonotice';
    private $_checkUrlForTest = array(
                                    'b3-it.local',
                                    'testshop.org',
                                    'eshop-test'
                                );

    /**
     * Prüfen, ein ein Teil des Hostnamens auf ein Test-System hinweist
     * und wenn dies der Fall ist, wird der Demo-Hinweis aktiviert und angezeigt
     *
     * @access public
     */
    public function checkShopState()
    {
        $_currHost = parse_url(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB), PHP_URL_HOST);

        foreach( $this->_checkUrlForTest AS $_host ) {
            // Prüfen, ob es ein Test-System ist .... (DSGVO)
            if ( stripos($_currHost, $_host) !== false ) {
                if ( !Mage::getStoreConfig($this->_demoPath) ) {
                    $_config = Mage::getConfig();

                    $_config->saveConfig($this->_demoPath, '1');
                    $_config->reinit();
                    Mage::app()->reinitStores();
                }
            }
        }
    }

    /**
     * Text der Ausgabeseite nach Abkürzungen durchsuchen und diese mit ABBR-Tag versehen
     *
     * @param $observer   \Mage_Core_Model_Observer
     * @access public
     */
    public function replaceTemplateAbbr($observer) {
        if (!$observer->hasFront()) {
            return;
        }

        /** @var \Mage_Core_Controller_Varien_Front $front */
        $front = $observer->getFront();

        foreach ($front->getResponse()->getHeaders() as $header) {
            if (isset($header['name']) && strtolower($header['name']) !== 'content-type') {
                continue;
            }

            if (isset($header['value']) && strpos(strtolower($header['value']), 'text/html') === false) {
                return;
            }
        }
        $html = $front->getResponse()->getBody();

        $html = Mage::helper('egovsbase')->replaceTemplateAbbr($html);
        $front->getResponse()->setBody($html);
    }


    /**
     * Überprüfung, ob statische URL für Mediathek benutzt wird
     *
     * @param $observer    \Mage_Core_Model_Observer
     * @return null
     * @access public
     */
    public function mediaCheckIsUsingStaticUrlsAllowed($observer) {
        $controller = Mage::app()->getFrontController()->getAction();
        if (!$controller || !$controller instanceof Egovs_Base_Adminhtml_Cms_Wysiwyg_MediaController) {
            return;
        }
        $result = $observer->getResult();
        $result->isAllowed = true;
    }
}
