<?php
/**
 * Register Block für Customer
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Frank Fochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Customer_Form_Register extends Mage_Customer_Block_Form_Register
{
    private $_method = 'register';
    private $_helper = null;

    public function _construct() {
        parent::_construct();

        // Helper setzen
        $this->setHelper();
    }

    /**
     * aktuellen Helper setzen
     */
    private function setHelper()
    {
        try {
            $this->_helper = Mage::helper('egovsbase/config');
        } catch (Exception $e) {
        }

        if (is_null($this->_helper)) {
            return false;
        }
    }

    /**
     * Wenn ein Benutzerfeld ein Pflichtfeld ist,
     * so wird im HTML das Markier-Element benötigt
     *
     * @param string $name               Feldname
     *
     * @return string
     */
    public function getFieldRequiredHtml($name) {
        if($this->isFieldRequired($name, $this->_method)) {
            return '<span class="required">*</span>';
        }
        return '';
    }

    /**
     * Abfrage, ob ein bestimmtes Feld für Benutzerdaten pflicht ist
     *
     * @param string $key               Feldname
     *
     * @return bool
     */
    public function isFieldRequired($key) {
        if ( $this->_helper !== false ) {
            return ($this->_helper->isFieldRequired($key, $this->_method));
        }
        else {
            return false;
        }
    }

    /**
     * Abfrage, ob ein bestimmtes Feld für Benutzerdaten sichtbar ist
     *
     * @param string $key               Feldname
     *
     * @return bool
     */
    public function isFieldVisible($key) {
        if ( $this->_helper !== false ) {
            return ($this->_helper->isFieldVisible($key, $this->_method));
        }
        else {
            return false;
        }
    }
    
    /**
     * Zusätzliche Firmenfelder anzeigen
     * 
     * @return boolean
     */
    public function isAdditionalCompanyVisible() {
    	$key = 'customer/registerrequired/additionalcompany';
    	return Mage::getStoreConfigFlag($key);
    }

    /**
     * Wenn ein Benutzerfeld ein Pflichtfeld ist,
     * so wird die Validator-Klasse im HTML benötigt
     *
     * @param string $key               Feldname
     *
     * @return string
     */
    public function getValidationClass($key)
    {
        if ( $this->isFieldRequired($key, $this->_method) ) {
            return 'required-entry';
        }
        else {
            return '';
        }
    }

    public function getCountryHtmlSelect($defValue=null, $name='country_id', $id='country', $title='Country') {
        Varien_Profiler::start('TEST: '.__METHOD__);
        if (is_null($defValue)) {
            $defValue = $this->getCountryId();
        }

        $cacheKey = 'DIRECTORY_COUNTRY_SELECT_STORE_'.Mage::app()->getStore()->getCode();
        if (Mage::app()->useCache('config') && $cache = Mage::app()->loadCache($cacheKey)) {
            $options = unserialize($cache, array('allowed_classes' => false));
        } else {
            $options = $this->getCountryCollection()->toOptionArray();
            if (Mage::app()->useCache('config')) {
                Mage::app()->saveCache(serialize($options), $cacheKey, array('config'));
            }
        }

        $html = $this->getLayout()->createBlock('core/html_select')
                     ->setName($name)
                     ->setId($id)
                     ->setTitle(Mage::helper('directory')->__($title))
                     ->setClass($this->isFieldRequired($name) ? 'validate-select' : '')
                     ->setValue($defValue)
                     ->setOptions($options)
                     ->getHtml();

        Varien_Profiler::stop('TEST: '.__METHOD__);
        return $html;
    }
}
