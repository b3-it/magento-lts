<?php
/**
 * Widget Block für Namen eines Customers
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Frank Fochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Customer_Widget_Name extends Mage_Customer_Block_Widget_Name
{
    private $_method = 'register';
    private $_helper = null;

    public function _construct() {
        parent::_construct();

        // default template location
        $this->setTemplate('customer/widget/name.phtml');

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
     * Abfrage, ob ein bestimmtes Feld für Benutzerdaten pflicht ist
     *
     * @param string $key               Feldname
     *
     * @return bool
     */
    public function isFieldRequired($key)
    {
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
    public function isFieldVisible($key)
    {
        if ( $this->_helper !== false ) {
            return ($this->_helper->isFieldVisible($key, $this->_method));
        }
        else {
            return false;
        }

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
        $class = '';

        if ( $this->_helper !== false ) {
            if ( $this->_helper->isFieldVisible($key, $this->_method) ) {
                if ( $this->_helper->isFieldRequired($key, $this->_method) ) {
                    $class = 'required-entry';
                }
            }
        }

        return $class;
    }

    /**
     * setzt die aktuelle Controller-Method (Register, Checkout, ...)
     */
    public function setMethod($method)
    {
        $this->_method = $method;
        return $this;
    }

    /**
     * Wenn ein Benutzerfeld ein Pflichtfeld ist,
     * so wird im HTML das Markier-Element benötigt
     *
     * @param string $name               Feldname
     *
     * @return string
     */
    public function getFieldRequiredHtml($name)
    {
        if ($this->isFieldRequired($name)) {
            return '<span class="required">*</span>';
        }
        return '';
    }

    public function isPrefixRequired()
    {
        return parent::isPrefixRequired() && $this->isFieldRequired('prefix');
    }

    /**
     * Retrieve academic_titel drop-down options
     *
     * @return array|bool
     */
    public function getAcademicTitleOptions($store = null)
    {
        $prefixOptions = $this->helper('customer')->getAcademicTitleOptions($store);

        if ($this->getObject() && !empty($prefixOptions)) {
            $oldPrefix = $this->escapeHtml(trim($this->getObject()->getPrefix()));
            $prefixOptions[$oldPrefix] = $oldPrefix;
        }
        return $prefixOptions;
    }

}
