<?php

$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('pdftemplate_template')} MODIFY type varchar(64);");

$installer->run("UPDATE {$this->getTable('pdftemplate_template')} SET type = '".Egovs_Pdftemplate_Model_Type::TYPE_INVOICE."' WHERE type = 1;");
$installer->run("UPDATE {$this->getTable('pdftemplate_template')} SET type = '".Egovs_Pdftemplate_Model_Type::TYPE_CREDITMEMO."' WHERE type = 2;");
$installer->run("UPDATE {$this->getTable('pdftemplate_template')} SET type = '".Egovs_Pdftemplate_Model_Type::TYPE_DELIVERYNOTE."' WHERE type = 3;");
$installer->run("UPDATE {$this->getTable('pdftemplate_template')} SET type = '".Egovs_Pdftemplate_Model_Type::TYPE_SEPAMANDAT."' WHERE type = 4;");

/*
 *   const TYPE_INVOICE	= 1;
    const TYPE_CREDITMEMO	= 2;
    const TYPE_DELIVERYNOTE	= 3;
    const TYPE_SEPAMANDAT	= 4;

 */


$installer->endSetup(); 