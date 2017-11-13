<?php
/**
  *
  * @category   	Gka Barkasse
  * @package    	Gka_Barkasse
  * @name       	Gka_Barkasse Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('gka_barkasse/kassenbuch_cashbox')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('gka_barkasse/kassenbuch_cashbox')};
	CREATE TABLE {$installer->getTable('gka_barkasse/kassenbuch_cashbox')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `title` varchar(128) default '',
	  `customer_id` int(11) unsigned default null,
	  `store_id` SMALLINT(5) unsigned default null,
	  `customer` varchar(128) default '',

	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE SET NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('gka_barkasse/kassenbuch_journal')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('gka_barkasse/kassenbuch_journal')};
	CREATE TABLE {$installer->getTable('gka_barkasse/kassenbuch_journal')} (
	  	`id` int(11) unsigned NOT NULL auto_increment,
    	`number` int(11) unsigned default 0,
        `owner` varchar(128) default '',
        `opening` datetime default null,
        `closing` datetime default null,
        `opening_balance`  decimal(12,4) default 0,
        `closing_balance`  decimal(12,4) default 0,
        `withdrawal`  decimal(12,4) default 0,
        `customer_id` int(11) unsigned default null,
        `cashbox_id` int(11) unsigned default null,
        `cashbox_title` varchar(128) default '',
        `status` smallint(6) unsigned default 0,
    
	  PRIMARY KEY (`id`),
      FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE SET NULL,
      FOREIGN KEY (`cashbox_id`) REFERENCES `{$this->getTable('gka_barkasse/kassenbuch_cashbox')}`(`id`) ON DELETE SET NULL
      
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('gka_barkasse/kassenbuch_journal_items')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('gka_barkasse/kassenbuch_journal_items')};
	CREATE TABLE {$installer->getTable('gka_barkasse/kassenbuch_journal_items')} (
	  	`id` int(11) unsigned NOT NULL auto_increment,
    	`number` int(11) unsigned default 0,
        `booking_date` datetime default null,
        `booking_amount`  decimal(12,4) default 0,
        `given_amount`  decimal(12,4) default 0,
        `journal_id` int(11) unsigned default 0,
        `order_id` int(11) unsigned default null,
        `source` smallint(6) unsigned default 0,
	  PRIMARY KEY (`id`),
     FOREIGN KEY (`journal_id`) REFERENCES `{$this->getTable('gka_barkasse/kassenbuch_journal')}`(`id`) ON DELETE SET NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}



$data = array();
$data['general']['title'] = "Kassenabschlussprotokoll";
$data['general']['type'] = 'report_cashbox';
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

$html = '<h2>Kassenabschlussprotokoll {{number}}</h2><h3>{{cashbox_title}} - {{(datetime)closing}}</h3>
	<table border="1" cellpadding="1" style="font-size:8pt;" >
	
	<tr>
	<td style="width:80mm;">Kasse</td><td style="width:80mm;">{{cashbox_title}}</td>
	</tr><tr>
	<td style="width:80mm;">Protokollnummer</td><td style="width:80mm;">{{number}}</td>
	</tr><tr>
	<td style="width:80mm;">Bearbeiter</td><td style="width:80mm;">{{owner}}</td>
	</tr><tr>		
	<td style="width:80mm;">Eröffnet</td><td style="width:80mm;">{{(datetime)opening}}</td>
	</tr><tr>
	<td style="width:80mm;">Geschlossen</td><td style="width:80mm;">{{(datetime)closing}}</td>
	</tr><tr>		
	<td style="width:80mm;">Eröffnungsbetrag</td><td style="width:80mm;">{{(price)opening_balance}}</td>
	</tr><tr>		
	<td style="width:80mm;">Abschlussbetrag</td><td style="width:80mm;">{{(price)closing_balance}}</td>
	</tr><tr>	
	<td style="width:80mm;">Entnahme</td><td style="width:80mm;">{{(price)withdrawal}}</td>
	</tr><tr>	
	<td style="width:80mm;">Summe der Einzelbeträge</td><td style="width:80mm;">{{(price)total}}</td>
	</tr>
	</table>
		<br><br>
	<table border="1" cellpadding="1" style="font-size:8pt;">
	<thead>
		<tr style="background-color:#DFDFDF; ">
			<td style="width:15mm;">Nummer</td>
			<td style="width:25mm;">Datum</td>
			<td style="width:25mm;">Betrag</td>
			<td style="width:25mm;">Bestellung</td>	
			<td style="width:25mm;">Kassenzeichen</td>
			<td style="width:25mm;">Externes Kassenzeichen</td>
			<td style="width:25mm;">Bestellstatus</td>
		</tr>
	</thead>
	{{items}}
		<tr>
		<td style="width:15mm;" align="center">{{number}}</td>
		<td style="width:25mm;">{{(datetime)booking_date}}</td>
		<td style="width:25mm;">{{(price)booking_amount}}</td>
		<td style="width:25mm;">{{increment_id}}</td>
		<td style="width:25mm;">{{kassenzeichen}}</td>
		<td style="width:25mm;">{{externes_kassenzeichen_text}}</td>
		<td style="width:25mm;">{{status}}</td>
		</tr>{{items}}
	</table><br><br>';
$data['body']['top'] = 110;
$data['body']['left'] = 22;
$data['body']['width'] = 0;
$data['body']['height'] = 0;
$data['body']['content'] = $html;

$html = '<table >
		<tr><td style="font-size:8pt;">Kassenabschlussprotokoll {{number}} - {{cashbox_title}} - {{(datetime)closing}}</td></tr>
		<tr><td style="font-size:8pt;">Seite {:pnp:} von {:ptp:}</td></tr>
	</table>
	';
$data['footer']['top'] = 285;
$data['footer']['left'] = 22;
$data['footer']['width'] = 0;
$data['footer']['height'] = 0;
$data['footer']['content'] = $html;

$setup = Mage::getModel('pdftemplate/setup');
$setup->CreateTemplate($data);







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
