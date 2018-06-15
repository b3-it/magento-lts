<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 14:19
 */

class Bkg_VirtualGeo_Model_Bundle_Observer
{
    protected function _processOptions(Bkg_VirtualGeo_Model_Components_Componentproduct $geoComponent) {
        $option = Mage::getModel('virtualgeo/bundle_option');

        $optCollection = $option->getCollection();
        $optCollection->addFieldToFilter('resource', $geoComponent->getResourceName());
        $optCollection->addFieldToFilter('parent_id', $geoComponent->getProductId());

        if ($optCollection->getSize() > 0) {
            return $this;
        }

        $option->setParentId($geoComponent->getProductId());
        $option->setResource($geoComponent->getResourceName());
        $option->setRefId($geoComponent->getId());
        $option->setPosition($geoComponent->getPos());
        $option->setRequired(1);
        $option->setType('radio');
        $option->setTitle('GeoRef');
        $option->save();

        return $this;
    }

    protected function _processSelections(Bkg_VirtualGeo_Model_Components_Componentproduct $geoComponent) {
        $selection = Mage::getModel('virtualgeo/bundle_selection');

        $option = Mage::getModel('virtualgeo/bundle_option');
        $optCollection = $option->getCollection();
        $optCollection->addFieldToFilter('resource', $geoComponent->getResourceName());
        $optCollection->addFieldToFilter('parent_id', $geoComponent->getProductId());

        if ($optCollection->getSize() < 1) {
            return $this;
        }

        $optionId = $optCollection->getFirstItem()->getId();

        $selCollection = $selection->getCollection();
        $selCollection->addFieldToFilter('selection.resource', $geoComponent->getResourceName());
        $selCollection->addFieldToFilter('selection.parent_product_id', $geoComponent->getProductId());
        $selCollection->addFieldToFilter('selection.ref_id', $geoComponent->getId());
        $selCollection->addFieldToFilter('selection.option_id', $optionId);

        if ($selCollection->getSize() > 0) {
            foreach ($selCollection->getItems() as $selection) {

            }

            return $this;
        }

        $selection->setOptionId($optionId);
        $selection->setParentProductId($geoComponent->getProductId());
        if ($geoComponent->getTransportProductId() > 0) {
            $selection->setProductId($geoComponent->getTransportProductId());
        }
        $selection->setPosition($geoComponent->getPos());
        $selection->setSelectionQty(1);
        $selection->setSelectionCanChangeQty(0);
        $selection->setIsVisibleOnlyInAdmin($geoComponent->getIsVisibleOnlyInAdmin());
        $selection->setResource($geoComponent->getResourceName());
        $selection->setRefId($geoComponent->getId());

        $selection->save();

        return $this;
    }

    public function onComponentsSaveAfter(Varien_Object $observer) {
        /** @var \Mage_Core_Model_Resource_Resource $rsce */
        $rsce = Mage::getResourceModel('core/resource');
        /** @var Varien_Db_Adapter_Interface $adapter */
        $adapter = $rsce->getReadConnection();

        if (!$adapter->isTableExists($rsce->getTable('virtualgeo/bundle_option'))
            || !$adapter->isTableExists($rsce->getTable('virtualgeo/bundle_selection'))
        ) {
            return;
        }

        $geoComponent = $observer->getGeoComponent();

        if (!($geoComponent instanceof Bkg_VirtualGeo_Model_Components_Componentproduct)) {
            return;
        }

        $this->_processOptions($geoComponent);
        $this->_processSelections($geoComponent);
    }
}