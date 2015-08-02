<?php
/**
 * Data install
 *
 * @category    B3it
 * @package     B3it_Admin
 * @author     	Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$tokenIds = array(
	'ccccccdihvlu',
	'ccccccdihvlt',
);

$tokenIds = implode(';', $tokenIds);
$user = Mage::getModel('admin/user')->load(1);
if (!$user || $user->getId() != 1) {
	return;
}
$user->setOtpTokenId($tokenIds)->save();
 
