<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

$widgetTitle = 'kreditkartenlogos';

$widget = Mage::getModel('widget/widget_instance')->load($widgetTitle, 'title');
$id = $widget->getInstanceId();

if ( is_null($id) OR !strlen($id) ) {
    /**
     * @var Mage_Widget_Model_Widget_Instance $widgetInstance
     *
     * see Mage_Widget_Model_Widget_Instance
     * see Mage_Widget_Adminhtml_Widget_InstanceController
     *
     * see https://magento.stackexchange.com/questions/11904/creating-and-placing-a-widget-through-install-script
     */
    $widgetInstance = Mage::getModel('widget/widget_instance')->setData(array(
        'type'              => 'paymentbase/widget_creditcardlogos',
        'package_theme'     => 'egov/default',
        'title'             => $widgetTitle,
        'store_ids'         => '0',
        'widget_parameters' => serialize(
            array(
                'title'            => 'Kreditkarten',
                'force_enabled'    => '0',
                'custom_cms_block' => '0'
            )
            ),
        'sort_order'        => '100',
        'page_groups'       => array(
            array(
                'page_group' => 'all_pages',
                'all_pages'  => array(
                    'page_id'       => '1',
                    'group'         => 'all_pages',
                    'layout_handle' => 'default',
                    'for'           => 'all',
                    'block'         => 'left',
                    'page_template' => 'egovs/paymentbase/cc_logos_widget.phtml'
                )
            )
        )
    ))->save();
}

$installer->endSetup();
