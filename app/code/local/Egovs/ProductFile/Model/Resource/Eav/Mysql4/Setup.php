<?php
/**
 * Setup für Attributerweiterungen
 *
 * @category   	Egovs
 * @package    	Egovs_ProductFile
 * @author 		Jan Knipper <j.knipper@edv-beratung-hempel.de>
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_ProductFile_Model_Resource_Eav_Mysql4_Setup extends Mage_Catalog_Model_Resource_Setup
{

	/**
	 * Leifert die neuen Attribute
	 * 
	 * @return array
	 */
	public function getDefaultEntities() {
		return array(
            'catalog_product' => array(
                'entity_model'      => 'catalog/product',
                'attribute_model'   => 'catalog/resource_eav_attribute',
                'table'             => 'catalog/product',
				// uncomment the following two lines for magento 1.4
				'additional_attribute_table' => 'catalog/eav_attribute',
                'entity_attribute_collection' => 'catalog/product_attribute_collection',
                'attributes'        => array(
                    'productfile' => array(
                        //'group'             => 'General',
                        'label'             => 'ProductFile path',
                        'type'              => 'varchar',
                        'input'             => 'text',
                        'default'           => '',
                        'class'             => '',
                        'backend'           => '',
                        'frontend'          => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => false,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'visible_in_advanced_search' => false,
                        'unique'            => false
					),
					'productimage' => array(
                        //'group'             => 'General',
                        'label'             => 'ProductImage path',
                        'type'              => 'varchar',
                        'input'             => 'text',
                        'default'           => '',
                        'class'             => '',
                        'backend'           => '',
                        'frontend'          => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => false,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'visible_in_advanced_search' => false,
                        'unique'            => false
					),
					'productfiledescription' => array(
                        //'group'             => 'General',
                        'label'             => 'ProductFile description',
                        'type'              => 'varchar',
                        'input'             => 'text',
                        'default'           => '',
                        'class'             => '',
                        'backend'           => '',
                        'frontend'          => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => false,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'visible_in_advanced_search' => false,
                        'unique'            => false
					),
				)
			),
		);
	}
}