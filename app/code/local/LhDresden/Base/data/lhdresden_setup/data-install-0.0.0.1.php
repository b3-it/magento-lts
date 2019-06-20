<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

// Logo-Grafiken setzen
$installer->setConfigData('design/header/logo_src', 'images/logo-lhdd-gelb.svg');
$installer->setConfigData('design/header/logo_src_small', 'images/logo-lhdd-gelb.svg');
$installer->setConfigData('design/header/enable_ajax_search', '0');

// Theme-Einstellungen zurücksetzen
$installer->setConfigData('design/theme/locale', '');
$installer->setConfigData('design/theme/template', '');
$installer->setConfigData('design/theme/skin', '');
$installer->setConfigData('design/theme/layout', '');
$installer->setConfigData('design/theme/default', '');

// Default-Package setzen
$installer->setConfigData('design/package/name', 'lhdd');


/**
 * CMS-Block für den Footer erzeugen
 * @var array $cms_blocks
 */
$cms_blocks = array(
    array(
        'title'      => 'Footerblock Herausgeber',
        'identifier' => 'footerblock_herausgeber',
        'content'    => '<div class="links">
    <div class="block-title"><strong>Herausgeber</strong></div>
        <div class="block-content"><img class="footer-wappen" alt="Wappen vom Freistaat Sachsen" src="{{skin url=\'images/logo_dresden_stadtverwaltung_footer.png\'}}" />
        <div class="herausgeber-info">
            {{block type=\'imprint/field\' value=\'shop_name\'}}<br />
            {{block type=\'imprint/field\' value=\'street\'}}<br />
            {{block type=\'imprint/field\' value=\'zip\'}} {{block type=\'imprint/field\' value=\'city\'}}<br /> <br />
            Telefon: {{block type=\'imprint/field\' value=\'telephone\'}}<br />
            Telefax: {{block type=\'imprint/field\' value=\'fax\'}}<br />
            E-Mail: {{block type=\'imprint/field\' value=\'email\'}}
        </div>
    </div>
</div>',
        'isactive'   => 1,
        'stores'     => array(0)
    )
);

$installer->endSetup();