<?php
/**
 * Created by PhpStorm.
 * User: Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * Date: 23.10.2018
 *
 */

/**
 * Class Egovs_Captcha_Model_Icon
 *
 * @category  Egovs
 * @package   Egovs_Captcha
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Model_Icon extends Egovs_Captcha_Model_Abstract
    implements Mage_Captcha_Model_Interface
{
    /**
     * Generates captcha
     *
     * @return void
     */
    public function generate() {
        // TODO: Implement generate() method.
    }

    /**
     * Checks whether solution entered by user corresponds to the one generated
     *
     * @param array $post
     *
     * @return bool
     */
    protected function _isCorrect(array $post) {
        return IconCaptcha::validateSubmission($post);
    }

    /**
     * Get Block Name
     *
     * @return string
     */
    public function getBlockName() {
        // TODO: Implement getBlockName() method.
    }

    /**
     * Loading 3rd party library
     */
    protected function _loadClasses()
    {
        require_once('Iconcaptcha/captcha-session.class.php');
        require_once('Iconcaptcha/captcha.class.php');
    }

    protected function _initIconcaptcha()
    {
        // https://github.com/fabianwennink/IconCaptcha-Plugin-jQuery-PHP/blob/master/examples/ajax-form.php

        // Set the path to the captcha icons. Set it as if you were
        // currently in the PHP folder containing the captcha.class.php file.
        // ALWAYS END WITH A /
        // DEFAULT IS SET TO ../icons/
        IconCaptcha::setIconsFolderPath( Mage::getBaseDir('media') . '/iconcaptcha/icons/' );

        // Enable or disable the 'image noise' option.
        // When enabled, some nearly invisible random pixels will be added to the
        // icons. This is done to confuse bots who download the icons to compare them
        // and pick the odd one based on those results.
        // NOTE: Enabling this might cause a slight increase in CPU usage.
        IconCaptcha::setIconNoiseEnabled(true);
    }

    public function __construct($params) {
        parent::__construct($params);

        $this->_loadClasses();
        $this->_initIconcaptcha();
    }

    /**
     * @param $theme
     * @param $cID
     *
     * @return string JSON
     */
    public function getCaptchaData($theme, $cID) {
        $this->getSession()->setData($this->_getFormIdKey('captcha'),
            array('expires' => time() + $this->getTimeout())
        );
        return IconCaptcha::getCaptchaData($theme, $cID);
    }

    public function getThemes() {
        return array('light', 'dark');
    }

    /**
     * @param $post Data
     *
     * @return bool
     */
    public function setSelectedAnswer($post) {
        return IconCaptcha::setSelectedAnswer($post);
    }

    /**
     * @param $hash
     * @param $cid
     */
    public function getIconFromHash($hash, $cid) {
        IconCaptcha::getIconFromHash($hash, $cid);
    }

    public function getRequiredPostFields($controller) {
        $post = array();

        if (!$controller) {
            return $post;
        }
        $post['captcha-idhf'] = $controller->getRequest()->getPost('captcha-idhf');
        $post['captcha-hf'] = $controller->getRequest()->getPost('captcha-hf');

        return $post;
    }
}
