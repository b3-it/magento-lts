<?php

class Egovs_B2b_Model_System_Config_Source_Customergroup
{

    protected $_options;


    const HIDE_NOTHING = -1;

    /**
     * Kundengruppen für system
     * @return array
     */
    public function toOptionArray()
    {
        if (is_null($this->_options)) {
            $this->_options = array();

            $collection = Mage::getResourceModel('customer/group_collection')->load();
                $this->_options[] = array(
                    'value' => Egovs_B2b_Model_System_Config_Source_Customergroup::HIDE_NOTHING,
                    'label' => Mage::helper('egovs_b2b')->__('-- NONE --')
                );
                foreach ($collection as $group) {
                    /* @var $group Mage_Customer_Model_Group */
                    $this->_options[] = array(
                        'value' => $group->getId(),
                        'label' => $group->getCode(),
                    );
                }

        }
        return $this->_options;
    }
}
