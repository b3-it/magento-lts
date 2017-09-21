<?php
/**
 * @var $this Mage_Eav_Model_Entity_Setup
 */

$installer = $this;
$installer->startSetup();

$cfg_array = 'a:3:{s:5:"title";s:12:"Kreditkarten";s:13:"force_enabled";s:1:"0";s:16:"custom_cms_block";s:1:"0";}';

$this->run("INSERT INTO `widget_instance` (`instance_id`, `instance_type`, `package_theme`, `title`, `store_ids`, `widget_parameters`, `sort_order`) " .
           "VALUES ('1', 'paymentbase/widget_creditcardlogos', 'egov/default', 'kreditkartenlogos', '0', '{$cfg_array}', '100');");

$this->run("INSERT INTO `widget_instance_page` (`page_id`, `instance_id`, `page_group`, `layout_handle`, `block_reference`, `page_for`, `page_template`) " .
           "VALUES ('1', '1', 'all_pages', 'default', 'left', 'all', 'egovs/paymentbase/cc_logos_widget.phtml')");

$this->run("INSERT INTO `widget_instance_page_layout` (`page_id`, `layout_update_id`) " .
           "VALUES ('1', '1')");

$installer->endSetup();
