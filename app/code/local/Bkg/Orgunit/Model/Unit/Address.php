<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Customer
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Customer address model
 *
 * @category   Mage
 * @package    Mage_Customer
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Bkg_Orgunit_Model_Unit_Address extends Mage_Core_Model_Abstract
{


    protected function _construct()
    {
        parent::_construct();
        $this->_init('bkg_orgunit/unit_address');
    }

    protected function _beforeDelete() {

        $this->getResource()->removeCustomerAddresses($this);



        return parent::_beforeDelete();
    }

    /**
     * Delete customer address
     *
     * @return Mage_Customer_Model_Address
     */
    public function delete()
    {
        parent::delete();
        $this->setData(array());
        return $this;
    }

    /**
     * Retrieve address entity attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = $this->getData('attributes');
        if (is_null($attributes)) {
            $attributes = $this->_getResource()
                ->loadAllAttributes($this)
                ->getAttributesByCode(); // getSortedAttributes doesn't work because of missing SetID 
            $this->setData('attributes', $attributes);
        }
        return $attributes;
    }

    public function __clone()
    {
        $this->setId(null);
    }

    /**
     * Return Entity Type instance
     *
     * @return Mage_Eav_Model_Entity_Type
     */
    public function getEntityType()
    {
        return $this->_getResource()->getEntityType();
    }

    /**
     * Return Entity Type ID
     *
     * @return int
     */
    public function getEntityTypeId()
    {
        $entityTypeId = $this->getData('entity_type_id');
        if (!$entityTypeId) {
            $entityTypeId = $this->getEntityType()->getId();
            $this->setData('entity_type_id', $entityTypeId);
        }
        return $entityTypeId;
    }

    
    /**
     * get address street
     *
     * @param   int $line address line index
     * @return  string
     */
    public function getStreet($line=0)
    {
        $street = parent::getData('street');
        if (-1 === $line) {
            return $street;
        } else {
            $arr = is_array($street) ? $street : explode("\n", $street);
            if (0 === $line || $line === null) {
                return $arr;
            } elseif (isset($arr[$line-1])) {
                return $arr[$line-1];
            } else {
                return '';
            }
        }
    }
    
    
    /**
     * set address street informa
     *
     * @param array|string $street
     * @return Bkg_Orgunit_Model_Unit_Address
     */
    public function setStreet($street)
    {
        if (is_array($street)) {
            $street = trim(implode("\n", $street));
        }
        $this->setData('street', $street);
        return $this;
    }
    
    /**
     * Create fields street1, street2, etc.
     *
     * To be used in controllers for views data
     *
     */
    public function explodeStreetAddress()
    {
        $streetLines = $this->getStreet();
        foreach ($streetLines as $i=>$line) {
            $this->setData('street'.($i+1), $line);
        }
        return $this;
    }
    
    /**
     * To be used when processing _POST
     */
    public function implodeStreetAddress()
    {
        $this->setStreet($this->getData('street'));
        return $this;
    }
    
    public function format($type) {


        switch ($type)
        {
            case 'html':
                {
                    //$data = Mage::getModel('bkg_orgunit/resource_unit_address')->load($this->getId());
                    $rows = array();
                    //$rows[] = $this->getName();
                    $rows[] = $this->getPrefix()." ".$this->getFirstname() . " " . $this->getMiddlename() ." ". $this->getLastname() . " " . $this->getSuffix();
                    $rows[] = $this->getCompany();
                    $rows[] = $this->getCompany2();
                    $rows[] = $this->getCompany3();
                    $rows[] = $this->getStreet(1);
                    $rows[] = $this->getStreet(2);
                    $rows[] = $this->getEmail();

                    $rows = array_filter($rows);
                    //die();
                    $str = implode('<br/>',$rows);
                    return $str;
                }
        }
        return "OUTPUT ADDRESS THERE";
    }
 
}
