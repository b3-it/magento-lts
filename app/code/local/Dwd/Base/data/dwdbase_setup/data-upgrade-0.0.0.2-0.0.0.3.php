<?php
/** @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$default = Mage::app()->getStore('default')->getId();
$english = Mage::app()->getStore('english')->getId();

$eng_cmsblocks = array (
    array(
        'title'      => 'Footer-Info für den DWD (english)',
        'identifier' => 'dwd_footer_block',
        'content'    => '<div id="footer-block-legal">
<img title="Bundesadler" alt="Bundesadler" src="{{skin url=\'images/adler.svg\'}}" />
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
<div class="block-title"><strong><span>Vergangenes Wetter</span></strong></div>
<ul>
<li><a href="{{store url="vergangenes-wetter-klimainfos/deutschland-allgemein.html"}}">Germany general</a></li>
<li><a href="{{store url="vergangenes-wetter-klimainfos/deutschland-speziell.html"}}">Germany special</a></li>
<li><a href="{{store url="vergangenes-wetter-klimainfos/global.html"}}">Global</a></li>
<li><a href="{{store url="vergangenes-wetter-klimainfos/geburtstagswetterkarte.html"}}">Birthday wetter map</a></li>
<li><a href="{{store url="wissenschaftliche-publikationen.html"}}">Publicationen</a></li>
<li><a href="{{store url="free-information"}}">Free informationen</a></li>
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
<li><a href="{{store url="aktuelles-wetter-vorhersagen/agrarwetter.html"}}">Agrar weather</a></li>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/flugwetter.html"}}">Flight weather</a></li>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/seewetter.html"}}">Sea weather</a></li>
<li><a href="{{store url="aktuelles-wetter-vorhersagen/strassenwetter.html"}}">Street weather</a></li>
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
<li><a href="{{store url="widerruf"}}">Recall</a></li>
<li><a href="{{store url=""}}">Dispute resolution</a></li>
<li><a href="{{store url="lieferung"}}">Delivery</a></li>
<li><a href="{{store url="zahlung"}}">Payment</a></li>
<li><a href="{{store url="bestellung"}}">Ordering process</a></li>
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
<li><a href="{{store url="datenschutz"}}">Data security</a></li>
<li><a href="{{store url="disclaimer"}}">Disclaimer</a></li>
<li><a href="{{store url="agb"}}">Terms and conditions</a></li>
<li><a href="{{store url="copyright"}}">Copyright</a></li>
</ul>',
        'isactive'   => 1,
        'stores'     => array($english)
    )
);

foreach( $eng_cmsblocks as $data ) {
    $block = Mage::getModel('cms/block');
    $engBlock = Mage::getModel('cms/block');

    // look for blocks only in default store
    if ( !$block->setStoreId(0)->load($data['identifier'])->isEmpty() ) {
        $oldTitle = $block->getData('title');
        $block->setData('title', $oldTitle.' (deutsch)');
        $block->setData('stores', array($default));
        $block->save();
    }

    $engBlock->setData($data)->save();
}

$installer->endSetup();