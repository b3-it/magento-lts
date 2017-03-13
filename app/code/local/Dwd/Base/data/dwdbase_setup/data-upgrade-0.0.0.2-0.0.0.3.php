<?php
/** @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

try {
    $default = Mage::app()->getStore('default')->getId();
} catch (Mage_Core_Model_Store_Exception $e) {
    $e = Mage::exception('Mage_Core_Model_Store',"Store 'default' not found!");
    Mage::logException($e);
    throw $e;
}

try {
    $english = Mage::app()->getStore('wettershop_en')->getId();
}  catch (Mage_Core_Model_Store_Exception $e) {
    $e = Mage::exception('Mage_Core_Model_Store',"Store 'english' not found!");
    Mage::logException($e);
    throw $e;
}

$eng_cmsblocks = array (
		array(
				'title'      => 'Top-Links für DWD-Layout (english)',
				'identifier' => 'dwd_top_links',
				'content'    => '<ul id="top-row-content-list">
<li id="header-imprint-link"><a href="{{store url="impressum"}}">Imprint</a></li>
<li id="header-contact-link"><a href="{{store url="contactpage"}}">Contact</a></li>
</ul>',
				'isactive'   => 1,
				'stores'     => array($english)
		),
		array(
        'title'      => 'Footer-Info für den DWD (english)',
        'identifier' => 'dwd_footer_block',
        'content'    => '<div id="footer-block-legal">
<img title="Bundesadler" alt="Bundesadler" src="{{skin url=\'images/adler.svg\' _secure=1}}" />
<div>
<p id="footer-text-top">The German Weather Service is a federal authority in the business area of the Federal Ministry of Transport and Digital Infrastructure.</p>
<p id="footer-text-bottom">{{block type="imprint/field" value="company_first"}}, {{block type="imprint/field" value="street"}}, {{block type="imprint/field" value="zip"}} {{block type="imprint/field" value="city"}}</p>
</div>
</div>',
        'isactive'   => 1,
        'stores'     => array($english)
    ),
    array(
        'title'      => 'DWD Footer Info-Block rechts (english)',
        'identifier' => 'dwd_footer_rechts',
        'content'    => '<div class="links">
<div class="block-title"><strong><span>Past weather</span></strong></div>
<ul>
<li><a href="{{store url="vergangenes-wetter-klimainfos/deutschland-allgemein.html" _store=default}}">Germany general</a></li>
<li><a href="{{store url="vergangenes-wetter-klimainfos/deutschland-speziell.html" _store=default}}">Germany special</a></li>
<li><a href="{{store url="vergangenes-wetter-klimainfos/global.html" _store=default}}">Global</a></li>
<li><a href="{{store url="vergangenes-wetter-klimainfos/geburtstagswetterkarte.html" _store=default}}">Birthday wetter map</a></li>
<li><a href="{{store url="wissenschaftliche-publikationen.html" _store=default}}">Publicationen</a></li>
<li><a href="{{store url="free-information" _store=default}}">Free informationen</a></li>
</ul>
</div>',
        'isactive'   => 1,
        'stores'     => array($english)
    ),
    array(
        'title'      => 'DWD Footer Info-Block mitte (english)',
        'identifier' => 'dwd_footer_mitte',
        'content'    => '<div class="links">
<div class="block-title"><strong><span>Current weather</span></strong></div>
<ul>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/agrarwetter.html" _store=default}}">Agricultural weather</a></li>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/flugwetter.html"}}">Aeronautical meteorology</a></li>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/seewetter.html" _store=default}}">Sea weather</a></li>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/strassenwetter.html" _store=default}}">Road weather</a></li>
</ul>
</div>',
        'isactive'   => 1,
        'stores'     => array($english)
    ),
    array(
        'title'      => 'DWD Footer Info-Block links (english)',
        'identifier' => 'dwd_footer_links',
        'content'    => '<div class="links">
<div class="block-title"><strong>Weather shop</strong></div>
<ul>
<li><a href="{{store url="agb"}}">Terms and conditions</a></li>
<li><a href="{{store url="widerruf"}}">Right of withdrawal</a></li>
<li><a href="http://ec.europa.eu/consumers/odr/">Dispute resolution</a></li>
<li><a href="{{store url="lieferung"}}">Delivery</a></li>
<li><a href="{{store url="zahlung"}}">Payments</a></li>
<li><a href="{{store url="bestellung"}}">How to order</a></li>
<li><a href="{{store url="faq"}}">FAQ</a></li>
<li><a href="{{store url="catalogsearch/term/popular/"}}">Popular search</a></li>
<li><a href="{{store url="catalog/seo_sitemap/category"}}">Sitemap</a></li>
</ul>
</div>',
        'isactive'   => 1,
        'stores'     => array($english)
    ),
    array(
        'title'      => 'DWD Footer Navigation (english)',
        'identifier' => 'dwd_footer_navigation',
        'content'    => '<ul id="footer-navigation">
<li class="show-on-mobile"><a href="{{store url="impressum"}}">Imprint</a></li>
<li><a href="{{store url="datenschutz"}}">Data Protection</a></li>
<li><a href="{{store url="disclaimer"}}">Disclaimer</a></li>
<li><a href="{{store url="agb"}}">Terms and conditions</a></li>
<li><a href="{{store url="copyright"}}">Copyright</a></li>
</ul>',
        'isactive'   => 1,
        'stores'     => array($english)
    )
);

$hasCmsData = function ($id, $storeId) {
    $store = array($storeId);
    $model = Mage::getModel('cms/block');
    $collection = $model->getCollection()
    ->addFieldToFilter('identifier', $id)
    ->addStoreFilter($storeId)
    ->addFieldToFilter('store_id', array('in' => $store));
    $cmsItem = $collection->getFirstItem();
    if ($cmsItem && $cmsItem->getBlockId()) {
        $cmsItem->load();
        return $cmsItem;
    } else {
        return null;
    }
};

foreach( $eng_cmsblocks as $data ) {
    // look for blocks only in default store
    if (( $block = $hasCmsData($data['identifier'], 0)) &&
        !$hasCmsData($data['identifier'], $default)) {
        $oldTitle = $block->getData('title');
        $block->setData('title', $oldTitle.' (deutsch)');
        $block->setData('stores', array($default));
        $block->save();
    }
    // create english blocks if they didnt exist yet
    if (!$hasCmsData($data['identifier'], $english)) {
        Mage::getModel('cms/block')->setData($data)->save();
    }
}

$installer->endSetup();