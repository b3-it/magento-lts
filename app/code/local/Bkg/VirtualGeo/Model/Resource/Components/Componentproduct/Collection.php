<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Resource_Components_Componentproduct_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Resource_Components_Componentproduct_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function addComponentToSelect($model, $productId, $storeId = 0, $fields = null)
    {
        $model = Mage::getModel($model);
        if($model == null) {
            return $this;
        }
        $select = $this->getSelect();

        if($fields == null)
        {
           $fields = array('code');
        }

        $productModel = $this->getNewEmptyItem();
        if (method_exists($productModel, 'getComponentType') && $productModel->getComponentType() > 0) {
            $select->join(
                array('entity'=>$model->getResource()->getMainTable()),
                "main_table.entity_id = entity.id and main_table.component_type = {$productModel->getComponentType()}",
                $fields
            );
        } else {
            $select->join(
                array('entity'=>$model->getResource()->getMainTable()),
                "main_table.entity_id = entity.id",
                $fields
            );
        }

        $select->join(array('label'=>$model->getResource()->getLabelTable()), "label.entity_id=main_table.entity_id AND label.store_id=".intval(0),array('shortname','name','description'))
            ->where('main_table.product_id = ' .intval($productId))
            ->where('main_table.store_id IN (0,?)', intval($storeId))
        	->order('pos');
        return $this;
    }

    public function addVirtualGeoBundleSelection($parentProductId, $resource) {
        $parentProductId = intval($parentProductId);
        $resource = $resource = $this->getSelect()->getAdapter()->quote($resource);
        $this->getSelect()->joinLeft(
            array('selection' => $this->getTable('virtualgeo/bundle_selection')),
            "selection.ref_id = main_table.id and selection.resource = {$resource} and selection.parent_product_id = {$parentProductId}",
            array('selection_id', 'option_id')
        );

        return $this;
    }

}
