<?php
/** @var $this Egovs_Base_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$attributeId = 'body_hash';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('egovsbase/mail_attachment'), $attributeId)) {

    //since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
    $installer->getConnection()->addColumn(
        $installer->getTable('egovsbase/mail_attachment'),
        $attributeId,
        'varchar(255)'
    );
}

$installer->endSetup();
