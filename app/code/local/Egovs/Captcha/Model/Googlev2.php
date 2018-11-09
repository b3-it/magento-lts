<?php
/**
 * Created by PhpStorm.
 * User: Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * Date: 23.10.2018
 *
 */

/**
 * Class Egovs_Captcha_Model_Googlev2
 *
 * @category  Egovs
 * @package   Egovs_Captcha
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Model_Googlev2 extends Egovs_Captcha_Model_Abstract
    implements Mage_Captcha_Model_Interface
{
    const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct($params) {
        parent::__construct($params);

        $this->generate();
    }

    /**
     * Generates captcha
     *
     * @return void
     */
    public function generate() {
        $this->getSession()->setData($this->_getFormIdKey('captcha'),
            array('expires' => time() + $this->getTimeout())
        );
    }

    /**
     * Checks whether word entered by user corresponds to the one generated by generate()
     *
     * @param array $post
     *
     * @return void
     */
    protected function _isCorrect(array $post) {
        require_once 'Httpful/Bootstrap.php';
        \Httpful\Bootstrap::init();

        $verifyPostData = array(
            'secret' => $this->_getHelper()->escapeHtml(Mage::getStoreConfig('customer/captcha/googlecaptcha_secretkey')),
            'response' => $post['g-recaptcha-response']
        );
        $response = \Httpful\Request::post(self::VERIFY_URL)
            ->expectsJson()
            ->sendsForm()
            ->body($verifyPostData)
            ->send()
        ;

        if (!$response || $response->code != 200 || !$response->hasBody() || empty($response->body)) {
            if ($response && $response->hasBody()) {
                Mage::log("captcha::invalid:".var_dump($response->body), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
            }
            return false;
        }

        return (bool)$response->body->success;
    }

    /**
     * Get Block Name
     *
     * @return string
     */
    public function getBlockName() {
        // TODO: Implement getBlockName() method.
    }

    public function getRequiredPostFields($controller) {
        $post = array();

        if (!$controller) {
            return $post;
        }
        $post['g-recaptcha-response'] = $controller->getRequest()->getPost('g-recaptcha-response');

        return $post;
    }
}
