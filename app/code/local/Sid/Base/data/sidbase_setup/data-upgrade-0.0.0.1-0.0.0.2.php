<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

/**
 * ContextHelp-Blöcke erzeugen
 * @var array $cms_blocks
 */
$cms_blocks = array(
                  array(
                      'title'      => 'Hilfe-Adressbuch',
                      'identifier' => 'help_addresses',
                      'content'    => '<p><img alt="Einleitung" src="{{media url="wysiwyg/contexthelp/Berechtigter_Besteller_final-4.jpg"}}" /></p>
<p><img alt="Adresse anlegen" src="{{media url="wysiwyg/contexthelp/Adressbuch/Berechtigter_Besteller_final-5.jpg"}}" /></p>
<p><img alt="Adresse bearbeiten" src="{{media url="wysiwyg/contexthelp/Adressbuch/Berechtigter_Besteller_final-6.jpg"}}" /></p>
<p><img alt="Adresse l&ouml;schen" src="{{media url="wysiwyg/contexthelp/Adressbuch/Berechtigter_Besteller_final-7.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten',
                      'identifier' => 'help_wishlist',
                      'content'    => '<p><img alt="Folie 1" src="{{media url="wysiwyg/contexthelp/Merklisten/12_Berechtigter_Besteller_final-12.jpg"}}" /></p>
<p><img alt="Folie 2" src="{{media url="wysiwyg/contexthelp/Merklisten/13_Berechtigter_Besteller_final-13.jpg"}}" /></p>
<p><img alt="Folie 3" src="{{media url="wysiwyg/contexthelp/Merklisten/14_Berechtigter_Besteller_final-14.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe-Bedarfsabfragen',
                      'identifier' => 'help_needs_assessment',
                      'content'    => '<p><img alt="Folie 3" src="{{media url="wysiwyg/contexthelp/Bedarf/3_Berechtigter_Besteller_final-3.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Produkte ansehen',
                      'identifier' => 'help_view-products',
                      'content'    => '<p><img alt="Einleitung" src="{{media url="wysiwyg/contexthelp/Bedarf/8_Berechtigter_Besteller_final-8.jpg"}}" /></p>
<p><img alt="Folie 9" src="{{media url="wysiwyg/contexthelp/Bedarf/9_Berechtigter_Besteller_final-9.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Aufträge Lieferanten',
                      'identifier' => 'help_order_supplier',
                      'content'    => '<p><img alt="Einleitung" src="{{media url="wysiwyg/contexthelp/Auftraege_Lieferanten/29_Berechtigter_Besteller_final-29.jpg"}}" /></p>
<p><img alt="Folie 1" src="{{media url="wysiwyg/contexthelp/Auftraege_Lieferanten/30_Berechtigter_Besteller_final-30.jpg"}}" /></p>
<p><img alt="Folie 2" src="{{media url="wysiwyg/contexthelp/Auftraege_Lieferanten/31_Berechtigter_Besteller_final-31.jpg"}}" /></p>
<p><img alt="Folie 3" src="{{media url="wysiwyg/contexthelp/Auftraege_Lieferanten/32_Berechtigter_Besteller_final-32.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten verteilen 2',
                      'identifier' => 'help_send_wishlist_2',
                      'content'    => '<p><img alt="Folie 17" src="{{media url="wysiwyg/contexthelp/Merklisten/17_Berechtigter_Besteller_final-17.jpg"}}" /></p>
<p><img alt="Folie 18" src="{{media url="wysiwyg/contexthelp/Merklisten/18_Berechtigter_Besteller_final-18.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe-Adresse bearbeiten',
                      'identifier' => 'help_configure_address',
                      'content'    => '<p><img alt="Adresse bearbeiten" src="{{media url="wysiwyg/contexthelp/Adressbuch/Berechtigter_Besteller_final-6.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Produkte zu Merklisten',
                      'identifier' => 'help_product_to_wishlist',
                      'content'    => '<p><img alt="zur Merkliste" src="{{media url="wysiwyg/contexthelp/Merklisten/Berechtigter_Besteller_final-11.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Aufruf Marklisten',
                      'identifier' => 'help_view_wishlists',
                      'content'    => '<p><img alt="Folie 1" src="{{media url="wysiwyg/contexthelp/Merklisten/15_Berechtigter_Besteller_final-15.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten verteilen 1',
                      'identifier' => 'help_send_wishlist_1',
                      'content'    => '<p><img alt="Folie 16" src="{{media url="wysiwyg/contexthelp/Merklisten/16_Berechtigter_Besteller_final-16.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten bestellen 19-20',
                      'identifier' => 'help_order_wishlist_19_20',
                      'content'    => '<p><img alt="Folie 19" src="{{media url="wysiwyg/contexthelp/Merklisten/19_Berechtigter_Besteller_final-19.jpg"}}" /></p>
<p><img alt="Folie 20" src="{{media url="wysiwyg/contexthelp/Merklisten/20_Berechtigter_Besteller_final-20.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten bestellen 21',
                      'identifier' => 'help_order_wishlist_21',
                      'content'    => '<p><img alt="Folie 21" src="{{media url="wysiwyg/contexthelp/Bestellen/21_Berechtigter_Besteller_final-21.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten bestellen 22',
                      'identifier' => 'help_order_wishlist_22',
                      'content'    => '<p><img alt="Folie 22" src="{{media url="wysiwyg/contexthelp/Bestellen/22_Berechtigter_Besteller_final-22.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten bestellen 23',
                      'identifier' => 'help_order_wishlist_23',
                      'content'    => '<p><img alt="Folie 23" src="{{media url="wysiwyg/contexthelp/Bestellen/23_Berechtigter_Besteller_final-23.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten bestellen 24',
                      'identifier' => 'help_order_wishlist_24',
                      'content'    => '<p><img alt="Folie 24" src="{{media url="wysiwyg/contexthelp/Bestellen/24_Berechtigter_Besteller_final-24.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten bestellen 25',
                      'identifier' => 'help_order_wishlist_25',
                      'content'    => '<p><img alt="Folie 25" src="{{media url="wysiwyg/contexthelp/Bestellen/25_Berechtigter_Besteller_final-25.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Merklisten bestellen 26',
                      'identifier' => 'help_order_wishlist_26',
                      'content'    => '<p><img alt="Folie 26" src="{{media url="wysiwyg/contexthelp/Bestellen/26_Berechtigter_Besteller_final-26.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe Bestellung stornieren',
                      'identifier' => 'help_order_cancel',
                      'content'    => '<p><img alt="Folie 27" src="{{media url="wysiwyg/contexthelp/Bestellen/27_Berechtigter_Besteller_final-27.jpg"}}" /></p>
<p><img alt="Folie 28" src="{{media url="wysiwyg/contexthelp/Bestellen/28_Berechtigter_Besteller_final-28.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
                  array(
                      'title'      => 'Hilfe-Adresse anlegen',
                      'identifier' => 'help_new_address',
                      'content'    => '<p><img alt="Folie 4" src="{{media url="wysiwyg/contexthelp/Adressbuch/4_Berechtigter_Besteller_final-4.jpg"}}" /></p>
<p><img alt="Folie 5" src="{{media url="wysiwyg/contexthelp/Adressbuch/5_Berechtigter_Besteller_final-5.jpg"}}" /></p>',
                      'isactive'   => 1,
                      'stores'     => array(0)
                  ),
            );

/**
 * ContextHelp erzeugen
 * @var array $_contextHelpEntity
 */
$_contextHelpEntity  = array(
                           0 => array(
                                    'title'         => 'Hilfe-Adressbuch',
                                    'category_id'   => 'customer',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           1 => array(
                                    'title'         => 'Hilfe Konfiguration Merklisten',
                                    'category_id'   => 'others',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           2 => array(
                                    'title'         => 'Hilfe Bedarfsermittlung',
                                    'category_id'   => 'others',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           3 => array(
                                    'title'         => 'Hilfe Produkte ansehen',
                                    'category_id'   => 'product',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           4 => array(
                                    'title'         => 'Hilfe Merklisten verteilen 2',
                                    'category_id'   => 'others',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           5 => array(
                                    'title'         => 'Hilfe-Adresse bearbeiten',
                                    'category_id'   => 'others',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           6 => array(
                                    'title'         => 'Hilfe-Artikel-Detailansicht',
                                    'category_id'   => 'product',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           7 => array(
                                    'title'         => 'Hilfe Aufruf Merklisten',
                                    'category_id'   => 'others',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           8 => array(
                                    'title'         => 'Hilfe Merklisten verteilen 1',
                                    'category_id'   => 'order',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           9 => array(
                                    'title'         => 'Hilfe Merklisten bestellen Warenkorb',
                                    'category_id'   => 'order',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           10 => array(
                                    'title'         => 'Hilfe Merklisten bestellen Adressen',
                                    'category_id'   => 'order',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           11 => array(
                                    'title'         => 'Hilfe Merklisten bestellen Overview',
                                    'category_id'   => 'order',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           12 => array(
                                    'title'         => 'Hilfe Merklisten bestellen Erfolg',
                                    'category_id'   => 'order',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           13 => array(
                                    'title'         => 'Hilfe Bestellung stornieren',
                                    'category_id'   => 'customer',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
                           14 => array(
                                    'title'         => 'Hilfe Kundenkonto',
                                    'category_id'   => 'order',
                                    'package_theme' => 'egov/sid',
                                    'store_ids'     => array('default', 'sidshop', 'esvshop')
                                ),
    					);
/**
 * ContextHelp-Block-Verlinkungen
 * @var array $_contextHelpBlocks
 */
$_contextHelpBlocks  = array(
                           0 => array(
                                    'help_addresses' => 1,
                                ),
                           1 => array(
                                    'help_wishlist' => 1,
                                ),
                           2 => array(
                                   'help_needs_assessment' => 1,
								   'help_view-products'    => 2,
                                ),
                           3 => array(
                                    'help_view-products'       => 1,
									'help_product_to_wishlist' => 2,
                                ),
                           4 => array(
                                    'help_send_wishlist_2' => 1,
                                ),
                           5 => array(
                                    'help_configure_address' => 1,
                                ),
                           6 => array(
                                    'help_order_supplier' => 1,
                                ),
                           7 => array(
                                    'help_view_wishlists' => 1,
                                ),
                           8 => array(
                                    'help_view_wishlists'       => 1,
									'help_send_wishlist_1'      => 2,
									'help_order_wishlist_19_20' => 3,
                                ),
                           9 => array(
                                    'help_order_wishlist_21' => 1,
                                ),
                           10 => array(
                                    'help_order_wishlist_22' => 1,
									'help_order_wishlist_23' => 2,
                                ),
                           11 => array(
                                    'help_order_wishlist_24' => 1,
									'help_order_wishlist_25' => 2,
                                ),
                           12 => array(
                                    'help_order_wishlist_26' => 1,
                                ),
                           13 => array(
                                    'help_order_cancel' => 1,
                                ),
                           14 => array(
                                    'help_new_address'    => 1,
									'help_view_wishlists' => 2,
									'help_order_cancel'   => 3,
                                ),
						);

/**
 * ContextHelp-Block-Handels
 * @var array $_contextHelpHandels
 */
$_contextHelpHandels = array(
                           0 => 'customer_address_index',
                           1 => 'sidwishlist_index_add,sidwishlist_index_newwishlist',
                           2 => 'cms_page,cms_index_index',
                           3 => 'catalog_product_view,catalog_category_default',
                           4 => 'sidwishlist_index_share',
                           5 => 'customer_address_form',
                           6 => 'PRODUCT_TYPE_configurable,PRODUCT_TYPE_bundle,PRODUCT_TYPE_simple',
                           7 => 'sidwishlist_index_index',
                           8 => 'sidwishlist_index_view',
                           9 => 'checkout_cart_index',
                           10 => 'checkout_multishipping_addresses',
                           11 => 'checkout_multishipping_overview',
                           12 => 'checkout_multishipping_success',
                           13 => 'sales_order_view,sales_order_history',
                           14 => 'customer_account_index',
                       );

/**
 * StoreDaten
 * @var array $_stores
 */
$_stores = array();

foreach( $cms_blocks AS $data ) {
    /** @var Mage_Cms_Model_Block $block */
    $block = Mage::getModel('cms/block');

    if ( $block->load($data['identifier'], 'identifier')->isEmpty() ) {
        $block->setData($data)->save();
    }
}

$allStores = Mage::app()->getStores();
foreach( $allStores AS $storeId => $storeData ) {
    $_stores[Mage::app()->getStore($storeId)->getCode()] = Mage::app()->getStore($storeId)->getId();
}

foreach( $_contextHelpEntity AS $helpId => $newHelpItem ) {
    /** @var Egovs_ContextHelp_Helper_Contexthelpsetup_Data $helper */
    $helper = Mage::helper('contexthelp_setup');

    if ( is_array($newHelpItem['store_ids']) ) {
        $tmp = array();
        foreach( $newHelpItem['store_ids'] AS $store ) {
            $tmp[] = $_stores[$store];
        }
        $newHelpItem['store_ids'] = implode(',', $tmp);
    }

    if ( $newContexthelp = $helper->addNewContextHelp($newHelpItem) ) {
        $_usedBlocks = $_contextHelpBlocks[$helpId];
        if ( count($_usedBlocks) ) {
            foreach( $_usedBlocks AS $blockIdent => $blockPosition ) {
                /** @var Mage_Cms_Model_Block $block */
                $block = Mage::getModel('cms/block');

                $destBlock = $block->load($blockIdent, 'identifier');

                if ( !$destBlock->isEmpty() ) {
                    $helper->linkBlock($newContexthelp, $destBlock->getBlockId(), $blockPosition);
                }
            }
        }

        $_usedHandels = $_contextHelpHandels[$helpId];
        if ( strlen($_usedHandels) ) {
            $_usedHandels = explode(',', $_usedHandels);
            foreach( $_usedHandels AS $newHandle ) {
                $helper->addNewHandle($newContexthelp, $newHandle);
            }
        }
    }
}

$installer->endSetup();
