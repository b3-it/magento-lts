<?php
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$data       = array();


$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_ROLE , 'value'  => 'Vortragender');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_ROLE , 'value'  => 'Poster');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_ROLE , 'value'  => 'Chair');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_ROLE , 'value'  => 'Moderator');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_ROLE , 'value'  => 'Organisation');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_ROLE , 'value'  => 'Teilnehmer');

$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_JOB , 'value'  => 'Präsident');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_JOB , 'value'  => 'Staatssekretär');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_JOB , 'value'  => 'Referentin');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_JOB , 'value'  => 'Wissenschaftlerin');

$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY , 'value'  => 'Wirtschaft');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY , 'value'  => 'Politik');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY , 'value'  => 'Verbraucherschaft');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY , 'value'  => 'Verband');

$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY , 'value'  => 'Pharma');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY , 'value'  => 'Chemie');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY , 'value'  => 'Landwirtschaft');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY , 'value'  => 'Einzelhandel');
$data[] = array('typ' => Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY , 'value'  => 'Überwachung');


$installer->getConnection()->insertMultiple($this->getTable('eventmanager/lookup'), $data);
 
