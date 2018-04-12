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

        $selCollection = $selection->getCollection();
        $selCollection->addFieldToFilter('selection.resource', $geoComponent->getResourceName());
        $selCollection->addFieldToFilter('selection.parent_product_id', $geoComponent->getProductId());
        $selCollection->addFieldToFilter('selection.ref_id', $geoComponent->getId());

        $option = Mage::getModel('virtualgeo/bundle_option');

        $optCollection = $option->getCollection();
        $optCollection->addFieldToFilter('resource', $geoComponent->getResourceName());
        $optCollection->addFieldToFilter('parent_id', $geoComponent->getProductId());

        if ($optCollection->getSize() < 1) {
            return $this;
        }

        $optionId = $optCollection->getFirstItem()->getId();

        if ($selCollection->getSize() > 0) {
            foreach ($selCollection->getItems() as $selection) {

            }

            return $this;
        }

        $selection->setOptionId($optionId);
        $selection->setParentProductId($geoComponent->getProductId());
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
        $geoComponent = $observer->getGeoComponent();

        if (!($geoComponent instanceof Bkg_VirtualGeo_Model_Components_Componentproduct)) {
            return;
        }

        $this->_processOptions($geoComponent);
        $this->_processSelections($geoComponent);
    }
}