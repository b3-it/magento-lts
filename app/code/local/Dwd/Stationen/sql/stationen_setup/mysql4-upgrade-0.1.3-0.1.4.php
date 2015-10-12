<?php

$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('stationen_set_relation')} ADD FOREIGN KEY (`stationen_id`) REFERENCES {$this->getTable('stationen/stationen')} (entity_id) ON DELETE CASCADE");

$installer->run("ALTER TABLE {$this->getTable('stationen/stationen')} MODIFY COLUMN `lat` DECIMAL(14,6) DEFAULT 0");
$installer->run("ALTER TABLE {$this->getTable('stationen/stationen')} MODIFY COLUMN `lon` DECIMAL(14,6) DEFAULT 0");
$installer->run("ALTER TABLE {$this->getTable('stationen/stationen')} MODIFY COLUMN `height` DECIMAL(14,6) DEFAULT 0");

$installer->endSetup(); 