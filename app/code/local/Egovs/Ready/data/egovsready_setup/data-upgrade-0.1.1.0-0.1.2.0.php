<?php


$this->saveCmsPage(array(
    'title'         => 'AGB',
    'identifier'    => 'unsere_agbs',
    'content'       => $this->getTemplateContent('agb.html'),
	'content_heading' => "Unsere AGB's",
    'is_active'     => 1,
    'stores'        => 0,
	'root_template' => 'three_columns'
));

$this->saveCmsPage(array(
		'title'         => 'Impressum',
		'identifier'    => 'impressum',
		'content'       => $this->getTemplateContent('imprint.html'),
		'content_heading' => 'Impressum',
		'is_active'     => 1,
		'stores'        => 0,
		'root_template' => 'three_columns'
));

$this->saveCmsPage(array(
		'title'         => 'Datenschutz',
		'identifier'    => 'datenschutz',
		'content'       => $this->getTemplateContent('datenschutz.html'),
		'content_heading' => 'Datenschutz',
		'is_active'     => 1,
		'stores'        => 0,
		'root_template' => 'three_columns'
));

$this->saveCmsBlock(array(
		'title'         => 'Fusszeile Firma',
		'identifier'    => 'footer_links_company',
		'content'       => $this->getTemplateContent('footer.html'),
		'is_active'     => 1,
		'stores'        => 0,
));

