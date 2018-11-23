<?php
/**
 * 
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package			Egovs_Ready
 * @name            \Egovs_Ready_Block_Catalog_Product_View_Type_Configurable
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2018 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Ready_Block_Catalog_Product_View_Type_Configurable extends Mage_Catalog_Block_Product_View_Type_Configurable
{
	protected function _getAdditionalConfig() {
        $additionalConfig = array();
        $addTaxConfig = array(
            'exclTaxTitle'      => Mage::helper('catalog')->__('Excl. Tax'),
            'taxFreeTitle'      => Mage::helper('catalog')->__('Tax Free'),
        );
        $additionalConfig['addTaxConfig'] = $addTaxConfig;

        return $additionalConfig;
    }
}