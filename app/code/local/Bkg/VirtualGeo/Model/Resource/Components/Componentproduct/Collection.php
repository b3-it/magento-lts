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

    public function addComponentToSelect($model, $productId, $storeId = 0)
    {
        $model = Mage::getModel($model);
        if($model == null) {
            return $this;
        }
        $select = $this->getSelect();

        $select->join(array('entity'=>$model->getResource()->getMainTable()),'main_table.entity_id = entity.id',array('code'))
            ->join(array('label'=>$model->getResource()->getLabelTable()), "label.entity_id=main_table.entity_id AND label.store_id=".intval(0),array('shortname','name','description'))
            ->where('main_table.product_id = ' .intval($productId))
            ->where('main_table.store_id IN (0,?)', intval($storeId));
        return $this;
    }

}
