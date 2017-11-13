<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Customer
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;

/* @var $installer Mage_Customer_Model_Entity_Setup */
$installer->startSetup();


if (!$installer->tableExists($installer->getTable('egovsbase/mail_attachment'))
		&& $installer->tableExists($installer->getTable('core/email_queue')))
{
	$table = $installer->getConnection()
	->newTable($installer->getTable('egovsbase/mail_attachment'))
	->addColumn('att_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity'  => true,
			'unsigned'  => true,
			'nullable'  => false,
			'primary'   => true,
	), 'Entity ID')
	->addColumn('message_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Message Id')
	//->addForeignKey('fk_relation_store','message_id', $installer->getTable('core/email_queue'), 'message_id',
	//    Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
			//2^21 => 2MB
	->addColumn('body', Varien_Db_Ddl_Table::TYPE_TEXT, 2097152, array('default'=>''), 'Body')
	->addColumn('mime_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array('default'=>''), 'MimeType')
	->addColumn('disposition', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array('default'=>''), 'Disposition')
	->addColumn('encoding', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array('default'=>''), 'Encoding')
	->addColumn('filename', Varien_Db_Ddl_Table::TYPE_VARCHAR, 1024, array('default'=>''), 'Original FileName')
	;
	$installer->getConnection()->createTable($table);
	
	/**
	 * Add foreign keys
	 */
	$installer->getConnection()->addForeignKey(
	    $installer->getFkName('egovsbase/mail_attachment', 'message_id', 'core/email_queue', 'message_id'),
	    $installer->getTable('egovsbase/mail_attachment'),
	    'message_id',
	    $installer->getTable('core/email_queue'),
	    'message_id',
	    Varien_Db_Ddl_Table::ACTION_CASCADE,
	    Varien_Db_Ddl_Table::ACTION_CASCADE
	);
}

$installer->endSetup();