<?php
/**
 *
 * @category    Bfr Eventparticipants
 * @package        Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants Installer
 * @author        Holger Kögel <h.koegel@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license        http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bfr_eventparticipants/notification_order'))) {
    $installer->run("
    -- DROP TABLE IF EXISTS {$installer->getTable('bfr_eventparticipants/notification_order')};
    CREATE TABLE {$installer->getTable('bfr_eventparticipants/notification_order')} (
      `id` int(11) unsigned NOT NULL auto_increment,
        `order_item_id` int(11) unsigned,
        `customer_id` int(11) unsigned,
        `hash` varchar(255) default '',
        `status` smallint(6) unsigned default '0',
        `event_id` int(11) unsigned NOT NULL,
        `signed_at` datetime default NULL,
    
      PRIMARY KEY (`id`),
      FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE CASCADE,
      FOREIGN KEY (`order_item_id`) REFERENCES `{$this->getTable('sales/order_item')}`(`item_id`) ON DELETE CASCADE,
      FOREIGN KEY (`event_id`) REFERENCES `{$this->getTable('eventmanager/event')}`(`event_id`) ON DELETE CASCADE

    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");
}

if (!$installer->getAttribute('catalog_product', 'eventParticipationList')) {
    $installer->addAttribute('catalog_product', 'eventParticipationList', array(
        'label' => 'Teilnahmeliste bestätigen',
        'input' => 'select',
        'type' => 'int',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => true,
        'is_user_defined' => true,
        'searchable' => false,
        'comparable' => false,
        'visible_on_front' => false,
        'visible_in_advanced_search' => false,
        'source' => 'eav/entity_attribute_source_boolean',
        'default' => '0',
        'group' => 'General',
        'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
    ));
}

$installer->endSetup();
