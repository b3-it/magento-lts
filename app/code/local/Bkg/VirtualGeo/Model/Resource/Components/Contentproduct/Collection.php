<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Resource_Components_Format_entity_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Resource_Components_Contentproduct_Collection extends Bkg_VirtualGeo_Model_Resource_Components_Componentproduct_Collection
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_contentproduct');
    }

    public function addComponentToSelect($model, $productId, $storeId = 0, $fields = null) {
        parent::addComponentToSelect($model, $productId, $storeId, $fields);

        $resource = $this->getResource();
        $this->join(
            array('additional' => 'virtualgeo/components_content_option_value'),
            'additional.entity_id = main_table.id',
            array_merge(array('node_id' => 'id'), $resource->getOptionValueAdditionalFields())
        );

        return $this;
    }
}
