<?php
/**
  *
  * @category   	Bkg License
  * @package    	Bkg_License
  * @name       	Bkg_License Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
/**
 * @var Bkg_License_Model_Resource_Setup $this
 */
$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bkg_license/master')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master')};
	CREATE TABLE {$installer->getTable('bkg_license/master')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
        `type` smallint(6) unsigned default '0',
        `reuse` smallint(6) unsigned default '0',
        `ident` varchar(255) default '',
        `name` varchar(255) default '',
        `title_fe` varchar(255) default '',
        `date_from` date default NULL,
        `date_to` date default NULL,
        `active` smallint(6) unsigned default '0',
        `consternation_check` smallint(6) unsigned default '0',
        `template` MEDIUMTEXT default '',
        `pdf_template_id` int(11) unsigned default null,
	  PRIMARY KEY (`id`),
	   FOREIGN KEY (`pdf_template_id`) REFERENCES `{$this->getTable('pdftemplate_template')}`(`pdftemplate_template_id`) ON DELETE SET NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/master_product')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_product')};
	CREATE TABLE {$installer->getTable('bkg_license/master_product')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
      `product_id` int(11) unsigned NOT NULL ,
      `master_id` int(11) unsigned NOT NULL ,    
	  PRIMARY KEY (`id`),
     FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE,
     FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
}


if (!$installer->tableExists($installer->getTable('bkg_license/master_toll')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_toll')};
			CREATE TABLE {$installer->getTable('bkg_license/master_toll')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `useoption_id` int(11) unsigned NOT NULL ,
	  `useoption_code` varchar(255) default '' ,
	  `master_id` int(11) unsigned NOT NULL ,
	  `pos` int(11) default '0',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`useoption_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/use_options_entity')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


if (!$installer->tableExists($installer->getTable('bkg_license/master_customergroup')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_customergroup')};
	CREATE TABLE {$installer->getTable('bkg_license/master_customergroup')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
        `customergroup_id` smallint(5) unsigned NOT NULL ,
        `master_id` int(11) unsigned NOT NULL ,
    
	  PRIMARY KEY (`id`),
    FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`customergroup_id`) REFERENCES `{$this->getTable('customer/customer_group')}`(`customer_group_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('bkg_license/master_fee')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_fee')};
	CREATE TABLE {$installer->getTable('bkg_license/master_fee')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
    `master_id` int(11) unsigned NOT NULL,
        `fee_code` varchar(255) default '',
        `is_percent` smallint(6) default '0',
        `is_active` smallint(6) default '0',
        `discount` DECIMAL(12,4) default '0',
	  PRIMARY KEY (`id`),
    FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('bkg_license/master_agreement')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_agreement')};
	CREATE TABLE {$installer->getTable('bkg_license/master_agreement')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
    `master_id` int(11) unsigned NOT NULL ,
        `identifier` varchar(128) default '',
        `pos` int(11) default '0',
    
	  PRIMARY KEY (`id`),
      FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('bkg_license/master_useoption')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_useoption')};
	CREATE TABLE {$installer->getTable('bkg_license/master_useoption')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
      `master_id` int(11) unsigned NOT NULL,
      `use_option_id` int(11) unsigned,
      `pos` int(11) default '0',
	  PRIMARY KEY (`id`),
      FOREIGN KEY (`use_option_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/use_options_entity')}`(`id`) ON DELETE CASCADE,
      FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
}

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bkg_license/copy')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy')};
	CREATE TABLE {$installer->getTable('bkg_license/copy')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `type` smallint(6) unsigned default '0',
	  `reuse` smallint(6) unsigned default '0',
	  `ident` varchar(255) default '',
	  `name` varchar(255) default '',
	  `title_fe` varchar(255) default '',
	  `date_from` date default NULL,
	  `date_to` date default NULL,
	  `status` smallint(6) unsigned default '0',
	  `order_allow_all_customer` smallint(6) unsigned default '1',
	  `accounting` smallint(6) unsigned default '0',
	  `consternation_check` smallint(6) unsigned default '0',
	  `template` MEDIUMTEXT default '',
	  `content` MEDIUMTEXT default '',
	  `customer_id` int(11) unsigned default NULL,
	  `orgunit_id` int(11) unsigned default NULL,
	  `is_orgunit` smallint(6) unsigned default '0',
	  `pdf_template_id` int(11) unsigned default null,
      FOREIGN KEY (`pdf_template_id`) REFERENCES `{$this->getTable('pdftemplate_template')}`(`pdftemplate_template_id`) ON DELETE SET NULL,
	  FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE SET NULL,
	  FOREIGN KEY (`orgunit_id`) REFERENCES `{$this->getTable('bkg_orgunit/unit')}`(`id`) ON DELETE SET NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_product')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_product')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_product')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `product_id` int(11) unsigned NOT NULL ,
	  `copy_id` int(11) unsigned NOT NULL ,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


if (!$installer->tableExists($installer->getTable('bkg_license/copy_toll')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_toll')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_toll')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `useoption_id` int(11) unsigned NOT NULL ,
	  `useoption_code` varchar(255) default '' ,
	  `copy_id` int(11) unsigned NOT NULL ,
	  `pos` int(11) default '0',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`useoption_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/use_options_entity')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


if (!$installer->tableExists($installer->getTable('bkg_license/copy_customergroup')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_customergroup')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_customergroup')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `customergroup_id` smallint(5) unsigned NOT NULL ,
	  `copy_id` int(11) unsigned NOT NULL ,

	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`customergroup_id`) REFERENCES `{$this->getTable('customer/customer_group')}`(`customer_group_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_authorized_customer')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_authorized_customer')};
	CREATE TABLE {$installer->getTable('bkg_license/copy_authorized_customer')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `customer_id` int(11) unsigned NOT NULL ,
	  `copy_id` int(11) unsigned NOT NULL ,

	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_fee')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_fee')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_fee')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `copy_id` int(11) unsigned NOT NULL,
	  `fee_code` varchar(255) default '',
	  `is_percent` smallint(6) default '0',
	  `is_active` smallint(6) default '0',
	  `discount` DECIMAL(12,4) default '0',

	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_agreement')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_agreement')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_agreement')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `copy_id` int(11) unsigned NOT NULL ,
	  `identifier` varchar(128) default '',
	  `pos` int(11) default '0',
		
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_useoption')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_useoption')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_useoption')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `copy_id` int(11) unsigned NOT NULL,
	  `use_option_id` int(11) unsigned,
	  `pos` int(11) default '0',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`use_option_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/use_options_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


if (!$installer->tableExists($installer->getTable('bkg_license/copy_file')))
{
    $installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_file')};
	CREATE TABLE {$installer->getTable('bkg_license/copy_file')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `copy_id` int(11) unsigned NOT NULL ,
      `usage` smallint(6) unsigned default '0', 
      `hash_filename` varchar(255) default '',
      `orig_filename` varchar(255) default '',
      `path` varchar(255) default '', 
      `ext` varchar(56) default '', 
      `created` datetime default now(),
      `modified` datetime default now(),
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_address')))
{
    $installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_address')};
	CREATE TABLE {$installer->getTable('bkg_license/copy_address')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `copy_id` int(11) unsigned NOT NULL ,
      `customer_address_id` int(11) unsigned default null,
      `orgunit_address_id` int(11) unsigned default null,
      `is_orgunit` smallint(6) unsigned default '0',
      `code` varchar(56) default '',  
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`customer_address_id`) REFERENCES `{$this->getTable('customer/address_entity')}`(`entity_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`orgunit_address_id`) REFERENCES `{$this->getTable('bkg_orgunit/unit_address_entity')}`(`entity_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

$data = array();
$data['general']['title'] = "Lizenz";
$data['general']['type'] = 'license_copy';
$data['general']['status'] = Egovs_Pdftemplate_Model_Status::STATUS_ENABLED;

$html = '<table><tr>
<td width="132mm" align="right" ><h1>Amt für Angelegenheiten</h1></td>
<td width="8mm" ></td>
<td><img src="{{config.logo}}" alt="logo" width="37mm"  height="22mm" border="0" /></td>
</tr></table>';
$data['header']['top'] = 10;
$data['header']['left'] = 20;
$data['header']['width'] = 210;
$data['header']['height'] = 30;
$data['header']['content'] = $html;

$html = '<table >
	<tr><td style="font-weight:bold;font-size:8pt;">Ihr Ansprechpartner</td></tr>
	<tr><td style="font-size:8pt">Frau Müller</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>

	<tr><td style="font-weight:bold;font-size:8pt;color:black;">Durchwahl</td></tr>
	<tr><td style="font-size:8pt;">Telefon 0351/123456</td></tr>
	<tr><td style="font-size:8pt;">Fax 0351/123456</td></tr>
	<tr><td style="font-size:8pt;">beratung@amt.de</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>

	<tr><td style="font-weight:bold;font-size:8pt;color:black;">Hausanschrift</td></tr>
	<tr><td style="font-size:8pt;">Amt für Angelegenheiten</td></tr>
	<tr><td style="font-size:8pt;">Holzweg 3a</td></tr>
	<tr><td style="font-size:8pt;">12345 Witzhausen</td></tr>
	<tr><td style="font-size:8pt;"></td></tr>

	<tr><td style="font-size:8pt;">Witzhausen</td></tr>
	<tr><td style="font-size:8pt;">{{(date)closing}}</td></tr>
	</table>
	';
$data['marginal']['top'] = 50;
$data['marginal']['left'] = 162;
$data['marginal']['width'] = 0;
$data['marginal']['height'] = 0;
$data['marginal']['occurrence'] = 1;
$data['marginal']['content'] = $html;

$html = '<table >
	<tr><td style="font-size:6pt;">Amt für Angelegenheiten</td></tr>
	<tr><td style="font-size:6pt;">Holzweg 3a | 12345 Witzhausen</td></tr>
	<tr><td style="font-size:6pt;"></td></tr>

	</table>
	';
$data['address']['top'] = 50;
$data['address']['left'] = 22;
$data['address']['width'] = 38;
$data['address']['height'] = 0;
$data['address']['content'] = $html;

$html = '{{content}}';
$data['body']['top'] = 110;
$data['body']['left'] = 22;
$data['body']['width'] = 0;
$data['body']['height'] = 0;
$data['body']['content'] = $html;

$html = '';
$data['footer']['top'] = 285;
$data['footer']['left'] = 22;
$data['footer']['width'] = 0;
$data['footer']['height'] = 0;
$data['footer']['content'] = $html;


$this->CreatePdfTemplate($data);

/*
if (!$installer->getAttribute('catalog_product', 'request')) {
	$installer->addAttribute('catalog_product', 'request', array(
			'label' => 'With Request',
			'input' => 'select',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => false,
			//'required' => true,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'source'    => 'eav/entity_attribute_source_boolean',
			'default' => '1',
			//'option' => $option,
			'group' => 'General',
			'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
	));
}
*/
$installer->endSetup();
