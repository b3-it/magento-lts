<?php
/**
 * Egovs GermanTax
 *
 *
 * @category   	Egovs
 * @package    	Egovs_GermanTax
 * @name       	Egovs_GermanTax Installer
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2014 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('tax/tax_calculation_rule'), 'taxkey')) {
	$installer->run("ALTER TABLE {$installer->getTable('tax/tax_calculation_rule')} 
		ADD taxkey varchar(255) default '',
		ADD valid_taxvat int default 0 ;"
	);
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('tax/sales_order_tax_item'), 'tax_key')) {
		$installer->getConnection()->addColumn(
				$installer->getTable('tax/sales_order_tax_item'),
				'tax_key',
				'varchar(255)'
		);
}
$installer->endSetup(); 
