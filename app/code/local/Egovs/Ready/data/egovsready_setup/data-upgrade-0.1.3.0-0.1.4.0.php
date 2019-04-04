<?php
/**
 * @var $this Egovs_Ready_Model_Setup
 */
$cmsPages = array(
    array(
		'root_template' => 'two_columns_left',
        'identifier'    => 'enable-cookies',
        'title'         => 'Cookies aktivieren',
        'content'       => $this->getTemplateContent('cookies.html')
    ),
    array(
		'root_template' => 'two_columns_left',
		'identifier'    => 'no-route',
		'title'         => 'Seite nicht gefunden',
		'content'       => $this->getTemplateContent('no-route.html')
    ),
    array(
		'root_template' => 'two_columns_left',
		'identifier'    => 'privacy-policy-cookie-restriction-mode',
		'title'         => 'Cookies',
		'content'       => $this->getTemplateContent('privacy-cookies.html')
    ),
    array(
        'identifier' => 'about-magento-demo-store',
        'is_active'     => 0
    ),
    array(
        'identifier' => 'contact-us',
        'title'      => 'Kontaktieren Sie uns'
    ),
    array(
        'identifier' => 'customer-service',
        'is_active'     => 0
    )
);

$installer = $this;
$installer->startSetup();

foreach ($cmsPages as $data) {
    $this->saveCmsPage($data);
}

$installer->endSetup();
