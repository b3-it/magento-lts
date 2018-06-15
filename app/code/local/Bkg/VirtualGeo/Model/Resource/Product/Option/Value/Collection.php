<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:07
 */

/**
 * Class Bkg_VirtualGeo_Model_Resource_Product_Option_Value_Collection
 *
 * @see Mage_Catalog_Model_Resource_Product_Option_Collection
 */
class Bkg_VirtualGeo_Model_Resource_Product_Option_Value_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected $_componentType = null;

    /**
     * Init model and resource model
     *
     */
    protected function _construct()
    {
        $this->_init('virtualgeo/product_option_value');
    }

    /**
     * Adds name attributes to result
     *
     * @param int $storeId
     * @return self
     */
    public function getValues($storeId)
    {
        $this->addTitleToResult($storeId);

        return $this;
    }

    /**
     * Add name to result
     *
     * @param int $storeId
     * @return Mage_Catalog_Model_Resource_Product_Option_Collection
     */
    public function addTitleToResult($storeId)
    {
        $components = array(
            Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_GEOREF => 'georef',
            Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_FORMAT => 'format',
            Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_RESOLUTION => 'resolution',
            Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_STRUCTURE => 'structure',
            Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_CONTENT => 'content',
        );

        $productOptionTitleTable = $this->getTable("virtualgeo/components_{$components[$this->getComponentType()]}_label");
        $adapter = $this->getConnection();
        $nameExpr = $adapter->getCheckSql(
            'store_option_name.name IS NULL',
            'default_option_name.name',
            'store_option_name.name'
        );

        $this->getSelect()
            ->joinLeft(array('default_option_name' => $productOptionTitleTable),
                'default_option_name.entity_id = main_table.entity_id AND '
                . $adapter->quoteInto('default_option_name.store_id = ?', Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID) . ' AND '
                . $adapter->quoteInto('main_table.component_type = ?', intval($this->getComponentType())),
                array('default_name' => 'name'))
            ->joinLeft(
                array('store_option_name' => $productOptionTitleTable),
                'store_option_name.entity_id = main_table.entity_id AND '
                . $adapter->quoteInto('store_option_name.store_id = ?', $storeId),
                array(
                    'store_name' => 'name',
                    'name' => $nameExpr
                )
            )->where('default_option_name.store_id = ?', Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
    }

    public function addComponentTypeFilter($componentType) {
        $this->setComponentType($componentType);
        $this->addFieldToFilter('component_type', $this->getComponentType());
    }

    public function setComponentType($componentType) {
        $this->_componentType = intval($componentType);
    }

    public function getComponentType() {
        return $this->_componentType;
    }

    /**
     * Add option filter
     *
     * @param array $optionIds
     * @param int $storeId
     * @return Mage_Catalog_Model_Resource_Product_Option_Value_Collection
     */
    public function getValuesByOption($optionIds, $storeId = null)
    {
        if (!is_array($optionIds)) {
            $optionIds = array($optionIds);
        }

        return $this->addFieldToFilter('main_table.id', array('in' => $optionIds));
    }
}