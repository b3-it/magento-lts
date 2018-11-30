<?php

class Bkg_Orgunit_Model_Unit_Address_Form extends Mage_Eav_Model_Form
{
    /**
     * Current module pathname
     *
     * @var string
     */
    protected $_moduleName = 'bkg_orgunit';

    /**
     * Current EAV entity type code
     *
     * @var string
     */
    protected $_entityTypeCode = 'bkg_orgunit';

    /**
     * Get EAV Entity Form Attribute Collection for Customer
     * exclude 'created_at'
     *
     * @return Mage_Customer_Model_Resource_Form_Attribute_Collection
     */
    protected function _getFormAttributeCollection()
    {
        return parent::_getFormAttributeCollection()
            ->addFieldToFilter('attribute_code', array('neq' => 'created_at'));
    }
}
