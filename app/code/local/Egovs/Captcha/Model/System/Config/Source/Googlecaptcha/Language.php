<?php
/**
 * Class Egovs_Captcha_Model_System_Config_Source_Googlecaptcha_Language
 *
 * @category  Egovs
 * @package   Egovs_Captcha_Model
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Model_System_Config_Source_Googlecaptcha_Language
{
    /**
     * Select-Options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value'=>0       , 'label'=>Mage::helper('egovscaptcha')->__('Auto-detects the user\'s language')),
            array('value'=>'ar'    , 'label'=>Mage::helper('egovscaptcha')->__('Arabic')),
            array('value'=>'af'    , 'label'=>Mage::helper('egovscaptcha')->__('Afrikaans')),
            array('value'=>'am'    , 'label'=>Mage::helper('egovscaptcha')->__('Amharic')),
            array('value'=>'hy'    , 'label'=>Mage::helper('egovscaptcha')->__('Armenian')),
            array('value'=>'az'    , 'label'=>Mage::helper('egovscaptcha')->__('Azerbaijani')),
            array('value'=>'eu'    , 'label'=>Mage::helper('egovscaptcha')->__('Basque')),
            array('value'=>'bn'    , 'label'=>Mage::helper('egovscaptcha')->__('Bengali')),
            array('value'=>'bg'    , 'label'=>Mage::helper('egovscaptcha')->__('Bulgarian')),
            array('value'=>'ca'    , 'label'=>Mage::helper('egovscaptcha')->__('Catalan')),
            array('value'=>'zh-HK' , 'label'=>Mage::helper('egovscaptcha')->__('Chinese (Hong Kong)')),
            array('value'=>'zh-CN' , 'label'=>Mage::helper('egovscaptcha')->__('Chinese (Simplified)')),
            array('value'=>'zh-TW' , 'label'=>Mage::helper('egovscaptcha')->__('Chinese (Traditional)')),
            array('value'=>'hr'    , 'label'=>Mage::helper('egovscaptcha')->__('Croatian')),
            array('value'=>'cs'    , 'label'=>Mage::helper('egovscaptcha')->__('Czech')),
            array('value'=>'da'    , 'label'=>Mage::helper('egovscaptcha')->__('Danish')),
            array('value'=>'nl'    , 'label'=>Mage::helper('egovscaptcha')->__('Dutch')),
            array('value'=>'en-GB' , 'label'=>Mage::helper('egovscaptcha')->__('English (UK)')),
            array('value'=>'en'    , 'label'=>Mage::helper('egovscaptcha')->__('English (US)')),
            array('value'=>'et'    , 'label'=>Mage::helper('egovscaptcha')->__('Estonian')),
            array('value'=>'fil'   , 'label'=>Mage::helper('egovscaptcha')->__('Filipino')),
            array('value'=>'fi'    , 'label'=>Mage::helper('egovscaptcha')->__('Finnish')),
            array('value'=>'fr'    , 'label'=>Mage::helper('egovscaptcha')->__('French')),
            array('value'=>'fr-CA' , 'label'=>Mage::helper('egovscaptcha')->__('French (Canadian)')),
            array('value'=>'gl'    , 'label'=>Mage::helper('egovscaptcha')->__('Galician')),
            array('value'=>'ka'    , 'label'=>Mage::helper('egovscaptcha')->__('Georgian')),
            array('value'=>'de'    , 'label'=>Mage::helper('egovscaptcha')->__('German')),
            array('value'=>'de-AT' , 'label'=>Mage::helper('egovscaptcha')->__('German (Austria)')),
            array('value'=>'de-CH' , 'label'=>Mage::helper('egovscaptcha')->__('German (Switzerland)')),
            array('value'=>'el'    , 'label'=>Mage::helper('egovscaptcha')->__('Greek')),
            array('value'=>'gu'    , 'label'=>Mage::helper('egovscaptcha')->__('Gujarati')),
            array('value'=>'iw'    , 'label'=>Mage::helper('egovscaptcha')->__('Hebrew')),
            array('value'=>'hi'    , 'label'=>Mage::helper('egovscaptcha')->__('Hindi')),
            array('value'=>'hu'    , 'label'=>Mage::helper('egovscaptcha')->__('Hungarain')),
            array('value'=>'is'    , 'label'=>Mage::helper('egovscaptcha')->__('Icelandic')),
            array('value'=>'id'    , 'label'=>Mage::helper('egovscaptcha')->__('Indonesian')),
            array('value'=>'it'    , 'label'=>Mage::helper('egovscaptcha')->__('Italian')),
            array('value'=>'ja'    , 'label'=>Mage::helper('egovscaptcha')->__('Japanese')),
            array('value'=>'kn'    , 'label'=>Mage::helper('egovscaptcha')->__('Kannada')),
            array('value'=>'ko'    , 'label'=>Mage::helper('egovscaptcha')->__('Korean')),
            array('value'=>'lo'    , 'label'=>Mage::helper('egovscaptcha')->__('Laothian')),
            array('value'=>'lv'    , 'label'=>Mage::helper('egovscaptcha')->__('Latvian')),
            array('value'=>'lt'    , 'label'=>Mage::helper('egovscaptcha')->__('Lithuanian')),
            array('value'=>'ms'    , 'label'=>Mage::helper('egovscaptcha')->__('Malay')),
            array('value'=>'ml'    , 'label'=>Mage::helper('egovscaptcha')->__('Malayalam')),
            array('value'=>'mr'    , 'label'=>Mage::helper('egovscaptcha')->__('Marathi')),
            array('value'=>'mn'    , 'label'=>Mage::helper('egovscaptcha')->__('Mongolian')),
            array('value'=>'no'    , 'label'=>Mage::helper('egovscaptcha')->__('Norwegian')),
            array('value'=>'fa'    , 'label'=>Mage::helper('egovscaptcha')->__('Persian')),
            array('value'=>'pl'    , 'label'=>Mage::helper('egovscaptcha')->__('Polish')),
            array('value'=>'pt'    , 'label'=>Mage::helper('egovscaptcha')->__('Portuguese')),
            array('value'=>'pt-BR' , 'label'=>Mage::helper('egovscaptcha')->__('Portuguese (Brazil)')),
            array('value'=>'pt-PT' , 'label'=>Mage::helper('egovscaptcha')->__('Portuguese (Portugal)')),
            array('value'=>'ro'    , 'label'=>Mage::helper('egovscaptcha')->__('Romanian')),
            array('value'=>'ru'    , 'label'=>Mage::helper('egovscaptcha')->__('Russian')),
            array('value'=>'sr'    , 'label'=>Mage::helper('egovscaptcha')->__('Serbian')),
            array('value'=>'si'    , 'label'=>Mage::helper('egovscaptcha')->__('Sinhalese')),
            array('value'=>'sk'    , 'label'=>Mage::helper('egovscaptcha')->__('Slovak')),
            array('value'=>'sl'    , 'label'=>Mage::helper('egovscaptcha')->__('Slovenian')),
            array('value'=>'es'    , 'label'=>Mage::helper('egovscaptcha')->__('Spanish')),
            array('value'=>'es-419', 'label'=>Mage::helper('egovscaptcha')->__('Spanish (Latin America)')),
            array('value'=>'sw'    , 'label'=>Mage::helper('egovscaptcha')->__('Swahili')),
            array('value'=>'sv'    , 'label'=>Mage::helper('egovscaptcha')->__('Swedish')),
            array('value'=>'ta'    , 'label'=>Mage::helper('egovscaptcha')->__('Tamil')),
            array('value'=>'te'    , 'label'=>Mage::helper('egovscaptcha')->__('Telugu')),
            array('value'=>'th'    , 'label'=>Mage::helper('egovscaptcha')->__('Thai')),
            array('value'=>'tr'    , 'label'=>Mage::helper('egovscaptcha')->__('Turkish')),
            array('value'=>'uk'    , 'label'=>Mage::helper('egovscaptcha')->__('Ukrainian')),
            array('value'=>'ur'    , 'label'=>Mage::helper('egovscaptcha')->__('Urdu')),
            array('value'=>'vi'    , 'label'=>Mage::helper('egovscaptcha')->__('Vietnamese')),
            array('value'=>'zu'    , 'label'=>Mage::helper('egovscaptcha')->__('Zulu')),
        );
    }

}