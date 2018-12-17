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
     * AJAX action
     *
     * @return null
     */
    public function indexAction()
    {
        /**
         * @var $captchaModel \Egovs_Captcha_Model_Icon
         */
        $captchaModel = Mage::helper('egovscaptcha')->getCaptcha($this->getRequest()->getParam('form_id', false));

        $_themes = $captchaModel->getThemes();

        $rT  = $this->getRequest()->getPost('rT');   // Request-Type (1: Image-Hash; 2: User-Choise)
        $cID = $this->getRequest()->getPost('cID');  // Captcha-ID on Page
        $tM  = $this->getRequest()->getPost('tM');   // selected Theme
        $pC  = $this->getRequest()->getPost('pC');   // Captcha-Hash

        if( is_numeric($rT) && is_numeric($cID) ) {
            $rT = (int)$rT;
            $cID = (int)$cID;
            switch( $rT ) {
                case 1: // Requesting the image hashes
                    $_theme = ( is_numeric($tM) && in_array($tM, $_themes) ? $_themes[$tM] : $_themes[0] );

                    // Echo the JSON encoded array
                    header('Content-type: application/json');
                    echo $captchaModel->getCaptchaData($_theme, $cID);
                    exit;
                case 2: // Setting the user's choice
                    $postData = compact("cID", "pC");
                    if($captchaModel->setSelectedAnswer($postData)) {
                        header('HTTP/1.0 200 OK');
                        exit;
                    }
                default:
                    break;
            }
        }

        // HTTP GET - Requesting the actual image.
        $hash = $this->getRequest()->get('hash');
        $cid  = $this->getRequest()->get('cid');

        if ( (strlen($hash) === $this->_hashLength) && is_numeric($cid) ) {
            IconCaptcha::getIconFromHash($hash, $cid);
            exit;
        }

        header('HTTP/1.1 400 Bad Request');
        exit;
    }
}