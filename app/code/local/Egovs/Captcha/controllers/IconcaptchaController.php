<?php
/**
 * Class Egovs_Captcha_IconcaptchaController
 *
 * @category  Egovs
 * @package   Egovs_Captcha_IconcaptchaController
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_IconcaptchaController extends Mage_Core_Controller_Front_Action
{
    private $_hashLength = 48;

    /**
     * Loading 3rd party library
     */
    private function _loadClasses()
    {
        require_once(Mage::getBaseDir('lib') . '/Iconcaptcha/captcha-session.class.php');
        require_once(Mage::getBaseDir('lib') . '/Iconcaptcha/captcha.class.php');
    }

    private function _initIconcaptcha()
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

    /**
     * AJAX action
     *
     * @return null
     */
    public function indexAction()
    {
        $this->_loadClasses();
        $this->_initIconcaptcha();

        $_themes = array('light', 'dark');

        $_post_rT  = $this->getRequest()->getPost('rT');   // Request-Type (1: Image-Hash; 2: User-Choise)
        $_post_cID = $this->getRequest()->getPost('cID');  // Captcha-ID on Page
        $_post_tM  = $this->getRequest()->getPost('tM');   // selected Theme
        $_post_pC  = $this->getRequest()->getPost('pC');   // Capcha-Hash

        if( is_numeric($_post_rT) && is_numeric($_post_cID) ) {
            $_post_rT = intval($_post_rT);
            switch( (int)$_post_rT ) {
                case 1: // Requesting the image hashes
                    $_captcha_theme = ( is_numeric($_post_tM) && in_array($_post_tM, $_themes) ? $_themes : $_themes[0] );

                    // Echo the JSON encoded array
                    header('Content-type: application/json');
                    echo IconCaptcha::getCaptchaData($_captcha_theme, $_post_cID);
                    exit;
                case 2: // Setting the user's choice
                    if(IconCaptcha::setSelectedAnswer($_post_cID, $_post_pC)) {
                        header('HTTP/1.0 200 OK');
                        exit;
                    }
                default:
                    break;
            }
        }

        // HTTP GET - Requesting the actual image.
        $_get_hash = $this->getRequest()->get('hash');
        $_get_cid  = $this->getRequest()->get('cid');

        if ( (strlen($_get_hash) === $this->_hashLength) && is_numeric($_get_cid) ) {
            IconCaptcha::getIconFromHash($_get_hash, $_get_cid);
            exit;
        }

        header('HTTP/1.1 400 Bad Request');
        exit;
    }
}