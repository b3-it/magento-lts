<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:07
 */

class Bkg_VirtualGeo_Model_Resource_Product_Option_Collection extends Mage_Catalog_Model_Resource_Product_Option_Collection
{
    /**
     * Init model and resource model
     *
     */
    protected function _construct()
    {
        $this->_init('virtualgeo/product_option');
    }

    /**
     * Adds name attributes to result
     *
     * @param int $storeId
     * @return Mage_Catalog_Model_Resource_Product_Option_Collection
     */
    public function getOptions($storeId)
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
            'georef' => Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_GEOREF
        );

        foreach ($components as $component => $type) {
            $productOptionTitleTable = $this->getTable("virtualgeo/components_{$component}_label");
            $adapter = $this->getConnection();
            $nameExpr = $adapter->getCheckSql(
                'store_option_name.name IS NULL',
                'default_option_name.name',
                'store_option_name.name'
            );

            $this->getSelect()
                ->join(array('default_option_name' => $productOptionTitleTable),
                    'default_option_name.entity_id = main_table.entity_id AND '
                    . $adapter->quoteInto('default_option_name.store_id = ?', Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID) . ' AND '
                    . $adapter->quoteInto('main_table.component_type = ?', intval($type)),
                    array('default_name' => 'name'))
                ->joinLeft(
                    array('store_option_name' => $productOptionTitleTable),
                    'store_option_name.entity_id = main_table.entity_id AND '
                    . $adapter->quoteInto('store_option_name.store_id = ?', $storeId),
                    array(
                        'store_name' => 'name',
                        'name' => $nameExpr
                    ))
                ->where('default_option_name.store_id = ?', Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
        }
        return $this;
    }
}