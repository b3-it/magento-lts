<?php
/**
 *
 * Umbennenung von core_config_data der pfad wurde von payment nach payment_services geändert
 *
 *
 *
 * @category        Egovs
 * @package         Egovs_Paymentbase
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;


$fields = array('accounting_list_limit',
				'active',
				'adapter',
				'adminemail',
				'auto_sync_epaybl_data',
				'bewirtschafternr',
				'buchungstext',
				'ca_certificate',
				'client_certificate',
				'haushaltsstelle',
				'href',
				'href_max_length',
				'is_alive',
				'mandantnr',
				'mandate_pdf_template_store',
				'maxcounthaushaltsstelle',
				'objektnummer',
				'service',
				'successaction',
				'webshopdesmandanten'
		
);

foreach ($fields as $f)
{
	$sql = "UPDATE ".$installer->getTable('core/config_data')." SET path = 'payment_services/paymentbase/".$f."'";
	$sql .= " WHERE path = 'payment/paymentbase/".$f."'";
	$installer->run($sql);
}