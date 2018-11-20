<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

/**
 * SID-ContextHelp-Blöcke für die Popups erzeugen
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

foreach( $cms_blocks AS $data ) {
	$block = Mage::getModel('cms/block');

	if ( $block->load($data['identifier'])->isEmpty() ) {
		$block->setData($data)->save();
	}
}


$installer->endSetup();
