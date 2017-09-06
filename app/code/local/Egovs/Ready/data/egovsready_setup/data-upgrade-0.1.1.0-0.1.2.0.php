<?php


$this->saveCmsPage(array(
    'title'         => 'AGB',
    'identifier'    => 'agb',
    'content'       => $this->getTemplateContent('agb.html'),
	'content_heading' => "AGB",
    'replace_content' => 0,
    'is_active'     => 1,
    'stores'        => 0,
	'root_template' => 'two_columns_left'
));

$this->saveCmsPage(array(
		'title'         => 'Widerrufsbelehrung',
		'identifier'    => 'widerruf',
		'content'       => $this->getTemplateContent('revocation.html'),
		'content_heading' => "Widerrufsbelehrung",
        'replace_content' => 0,
		'is_active'     => 1,
		'stores'        => 0,
		'root_template' => 'two_columns_left'
));

$this->saveCmsPage(array(
		'title'         => 'Impressum',
		'identifier'    => 'impressum',
		'content'       => $this->getTemplateContent('imprint.html'),
		'content_heading' => 'Impressum',
        'replace_content' => 0,
		'is_active'     => 1,
		'stores'        => 0,
		'root_template' => 'two_columns_left'
));

$this->saveCmsPage(array(
		'title'         => 'Datenschutz',
		'identifier'    => 'datenschutz',
		'content'       => $this->getTemplateContent('datenschutz.html'),
		'content_heading' => 'Datenschutz',
        'replace_content' => 0,
		'is_active'     => 1,
		'stores'        => 0,
		'root_template' => 'two_columns_left'
));

$this->saveCmsBlock(array(
		'title'         => 'Fusszeile',
		'identifier'    => 'footer_links',
		'content'       => $this->getTemplateContent('footer.html'),
        'replace_content' => 0,
		'is_active'     => 1,
		'stores'        => 0,
));

