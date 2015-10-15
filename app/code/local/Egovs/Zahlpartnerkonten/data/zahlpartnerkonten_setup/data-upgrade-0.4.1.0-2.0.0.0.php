<?php
/**
 *
 * Umbennenung von core_config_data der pfad wurde von payment nach payment_services geändert
 *
 *
 *
 * @category        Egovs
 * @package         Egovs_Zahlpartnerkonten
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
$installer = $this;

$fields = array('mandanten_kz_prefix','zpkonten_length','zpkonten_pool_limit','zpkonten_checksum');

foreach ($fields as $f)
{
	$sql = "UPDATE ".$installer->getTable('core/config_data')." SET path = 'payment_services/paymentbase/".$f."'";
	$sql .= " WHERE path = 'payment/paymentbase/".$f."'";
	$installer->run($sql);
}
