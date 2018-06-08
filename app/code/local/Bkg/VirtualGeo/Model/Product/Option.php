<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:08
 */

class Bkg_VirtualGeo_Model_Product_Option extends Mage_Catalog_Model_Product_Option
{

    protected static $_componentTypes = array(
        Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_GEOREF => 'GeoRef',
        Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_FORMAT => 'Format',
        Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_RESOLUTION => 'Resolution',
        Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_STRUCTURE => 'Structure',
        Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_CONTENT => 'Content'
    );

    /**
     * Constructor
     */
    protected function _construct()
    {
        //Darf nicht aufgerufen werden!
        //$this->_init('catalog/product_option');
    }

    /**
     *
     * @return int
     * @throws Varien_Exception
     */
    public function getId() {
        return $this->getComponentType();
    }

    public function getType() {
        switch ($this->getComponentType()) {
            case Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_CONTENT:
                return Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX;
            case Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_GEOREF:
            case Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_FORMAT:
            case Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_RESOLUTION:
            case Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_STRUCTURE:
            default:
                return Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO;
        }
    }

    public function getIsRequire() {
        return true;
    }

    public static function createOptionInstances() {
        $options = array();

        foreach (self::$_componentTypes as $ct => $title) {
            $componentType = self::createOptionInstanceById($ct);

            if (!is_null($componentType)) {
                $options[] = $componentType;
            }
        }

        return $options;
    }

    public static function createOptionInstanceById($id) {
        $id = intval($id);
        $componentType = NULL;
        if (isset(self::$_componentTypes[$id])) {
            $componentType = new Bkg_VirtualGeo_Model_Product_Option();
            $componentType->setComponentType($id);
            $componentType->setTitle(Mage::helper('virtualgeo')->__(self::$_componentTypes[$id]));
        }

        return $componentType;
    }

    public static function getOptionById($id) {
        return self::createOptionInstanceById($id);
    }

    public function addValuesByProduct($product, $storeId = NULL) {
        if ($product instanceof Mage_Catalog_Model_Product) {
            $productId = $product->getId();
        } elseif (is_numeric($product)) {
            $productId = intval($product);
        } else {
            return $this;
        }

        $values = Mage::getModel('virtualgeo/product_option_value')->getCollection();
        $values->addFieldToFilter('product_id', $productId);
        $values->addComponentTypeFilter($this->getComponentType());

        foreach ($values->getValues(Mage::app()->getStore($storeId)->getId()) as $value) {
            $this->addValue($value);
        }

        return $this;
    }

    public function groupFactory($type) {
        if ($this->getProduct()) {
            $this->addValuesByProduct($this->getProduct());
        }
        return parent::groupFactory($type);
    }

    /**
     * Get collection of values by given option ids
     *
     * @param array $optionIds
     * @param int $store_id
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Attribute
     */
    public function getOptionValuesByOptionId($optionIds, $store_id)
    {
        $collection = Mage::getModel('virtualgeo/product_option_value')
            ->getValuesByOption($optionIds, $this->getId(), $store_id);

        return $collection;
    }
}