<?php
/* @var $this Mage_Eav_Model_Entity_Setup */

$update = array(
              array('type' => 'customer', 'key' => 'firstname'),
              array('type' => 'customer', 'key' => 'lastname')
          );

$installer = $this;
$installer->startSetup();

foreach( $update AS $attrib ) {
    $installer->updateAttribute($attrib['type'], $attrib['key'], 'is_required', 0);
}

$installer->endSetup();
