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

    /**
     * AJAX action
     *
     * @return null
     */
    public function indexAction()
    {
        $this->_loadClasses();

        $_themes = array('light', 'dark');

        $_post_rT  = $this->getRequest()->getPost('rT');
        $_post_cID = $this->getRequest()->getPost('cID');
        $_post_tM  = $this->getRequest()->getPost('tM');
        $_post_pC  = $this->getRequest()->getPost('pC');

        if( ( !empty($_post_rT) && is_numeric($_post_rT) ) && ( !empty($_post_cID) && is_numeric($_post_cID) ) ) {
            switch( (int)$_post_rT ) {
                case 1: // Requesting the image hashes
                    $_captcha_theme = ( !empty($_post_tM) && in_array($_post_tM, $_themes) ? $_themes : $_themes[0] );

                    // Echo the JSON encoded array
                    header('Content-type: application/json');
                    echo IconCaptcha::getCaptchaData($_captcha_theme, $_post_cID);
                    exit;
                case 2: // Setting the user's choice
                    if(IconCaptcha::setSelectedAnswer($_post_cID, $_post_pC))
                    exit;
                default:
                    break;
            }
        }

        // HTTP GET - Requesting the actual image.
        $_get_hash = $this->getRequest()->get('hash');
        $_get_cid  = $this->getRequest()->get('cid');

        if ( (!empty($_get_hash) && strlen($_get_hash) === $this->_hashLength) && (!empty($_get_cid) && is_numeric($_get_cid)) ) {
            exit;
        }

        header('HTTP/1.1 400 Bad Request');
        exit;
    }
}