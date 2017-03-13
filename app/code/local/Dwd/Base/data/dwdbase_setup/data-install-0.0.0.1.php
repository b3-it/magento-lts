<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

/**
 * DWD-Blöcke für die Seite erzeugen
 * @var array $dwd_cms_blocks
 */
$cms_blocks = array(
                array(
                         'title'      => 'Top-Links für DWD-Layout',
                      	 'identifier' => 'dwd_top_links',
                      	 'content'    => '<ul id="top-row-content-list">
<li id="header-imprint-link"><a href="{{store url="impressum"}}">Impressum</a></li>
<li id="header-contact-link"><a href="{{store url="contactpage"}}">Kontakt</a></li>
</ul>',
                    	 'isactive'   => 1,
				         'stores'     => array(0)
                     ),
 				array(
 						'title'      => 'Footer-Info für den DWD',
 						'identifier' => 'dwd_footer_block',
						'content'    => '<div id="footer-block-legal">
<img title="Bundesadler" alt="Bundesadler" src="{{skin url=\'images/adler.svg\' _secure=1}}" />
<div>
<p id="footer-text-top">Der Deutsche Wetterdienst ist eine Bundesoberbeh&ouml;rde im Gesch&auml;ftsbereich des Bundesministeriums f&uuml;r Verkehr und digitale Infrastruktur.</p>
<p id="footer-text-bottom">{{block type="imprint/field" value="company_first"}}, {{block type="imprint/field" value="street"}}, {{block type="imprint/field" value="zip"}} {{block type="imprint/field" value="city"}}</p>
</div>
</div>',
						'isactive'   => 1,
				        'stores'     => array(0)
				),
				array(
						'title'      => 'DWD Footer Info-Block rechts',
						'identifier' => 'dwd_footer_rechts',
						'content'    => '<div class="links">
<div class="block-title"><strong><span>Vergangenes Wetter</span></strong></div>
<ul>
<li><a href="{{store url="vergangenes-wetter-klimainfos/deutschland-allgemein.html"}}">Deutschland allgemein</a></li>
<li><a href="{{store url="vergangenes-wetter-klimainfos/deutschland-speziell.html"}}">Deutschland speziell</a></li>
<li><a href="{{store url="vergangenes-wetter-klimainfos/global.html"}}">Global</a></li>
<li><a href="{{store url="vergangenes-wetter-klimainfos/geburtstagswetterkarte.html"}}">Geburtstagswetterkarte</a></li>
<li><a href="{{store url="wissenschaftliche-publikationen.html"}}">Publikationen</a></li>
<li><a href="{{store url="free-information"}}">Kostenlose Informationen</a></li>
</ul>
</div>',
						'isactive'   => 1,
				        'stores'     => array(0)
				),
				array(
						'title'      => 'DWD Footer Info-Block mitte',
						'identifier' => 'dwd_footer_mitte',
						'content'    => '<div class="links">
<div class="block-title"><strong><span>Aktuelles Wetter</span></strong></div>
<ul>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/agrarwetter.html"}}">Agrarwetter</a></li>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/flugwetter.html"}}">Flugwetter</a></li>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/seewetter.html"}}">Seewetter</a></li>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/strassenwetter.html"}}">Stra&szlig;enwetter</a></li>
</ul>
</div>',
						'isactive'   => 1,
				        'stores'     => array(0)
				),
				array(
						'title'      => 'DWD Footer Info-Block links',
						'identifier' => 'dwd_footer_links',
						'content'    => '<div class="links">
<div class="block-title"><strong>Wettershop</strong></div>
<ul>
<li><a href="{{store url="agb"}}">AGB</a></li>
<li><a href="{{store url="widerruf"}}">Widerruf</a></li>
<li><a href="http://ec.europa.eu/consumers/odr/">Streitbeilegung</a></li>
<li><a href="{{store url="lieferung"}}">Lieferung</a></li>
<li><a href="{{store url="zahlung"}}">Zahlungsarten</a></li>
<li><a href="{{store url="bestellung"}}">Bestellvorgang</a></li>
<li><a href="{{store url="faq"}}">FAQ</a></li>
<li><a href="{{store url="catalogsearch/term/popular/"}}">Beliebte Suchanfragen</a></li>
<li><a href="{{store url="catalog/seo_sitemap/category"}}">Sitemap</a></li>
</ul>
</div>',
						'isactive'   => 1,
				        'stores'     => array(0)
				),
				array(
						'title'      => 'DWD Footer Navigation',
						'identifier' => 'dwd_footer_navigation',
						'content'    => '<ul id="footer-navigation">
<li class="show-on-mobile"><a href="{{store url="impressum"}}">Impressum</a></li>
<li><a href="{{store url="datenschutz"}}">Datenschutz</a></li>
<li><a href="{{store url="disclaimer"}}">Disclaimer</a></li>
<li><a href="{{store url="agb"}}">AGB</a></li>
<li><a href="{{store url="copyright"}}">Copyright</a></li>
</ul>',
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


/**
 * CMS-Seiten für DWD erzeugen
 * @var array $cms_pages
 */

$cms_pages = array(
		array(
				'root_template'   => 'two_columns_left',
				'identifier'      => 'free-information',
				'title'           => 'Kostenlose Informationen',
				'stores'          => array(0),
				'content_heading' => 'Kostenlose Informationen',
				'is_active'       => 1,
		),
		array(
				'root_template'   => 'two_columns_left',
				'identifier'      => 'disclaimer',
				'title'           => 'Disclaimer',
				'stores'          => array(0),
				'content_heading' => 'Disclaimer',
				'is_active'       => 1,
		),
		array(
				'root_template'   => 'two_columns_left',
				'identifier'      => 'copyright',
				'title'           => 'Copyright',
				'stores'          => array(0),
				'content_heading' => 'Copyright',
				'is_active'       => 1,
		)
);

foreach ($cms_pages as $data) {
	$page = Mage::getModel('cms/page');
	
	if ( $page->load($data['identifier'])->isEmpty() ) {
		$page->setData($data)->save();
	}
}

$installer->endSetup();