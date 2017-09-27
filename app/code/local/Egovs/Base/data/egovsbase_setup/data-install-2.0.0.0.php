<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();


$forms=array('customer_account_edit', 'customer_account_create', 'adminhtml_customer', 'checkout_register');
$att = Mage::getModel('customer/attribute')->loadByCode('customer', 'company');
$att->setData('used_in_forms', $forms)->save();

$forms=array('adminhtml_customer_address','customer_address_edit');
$entityType = 'customer_address';
$attributeCode = 'company2';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '62')->save();

$attributeCode = 'company3';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '64')->save();

$attributeCode = 'web';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '200')->save();

$attributeCode = 'email';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '0')->save();

$forms=array('customer_account_edit','customer_account_create','adminhtml_customer');
$att = Mage::getModel('customer/attribute')->loadByCode('customer', 'store_id');
$att->setData('used_in_forms', $forms)->save();
$installer->run("UPDATE `{$installer->getTable('customer_eav_attribute')}`  SET sort_order=10 WHERE attribute_id=" . $att->getId());

$entityType = 'customer_address';
$collection = Mage::getModel('customer/resource_address_attribute_collection');
$collection->setEntityTypeFilter($entityType);
foreach ($collection->getItems() as $att) {
	$att->setIsRequired(false)->save();
}

$cmsPages = array(
		array(
				'root_template' => 'three_columns',
				'identifier'    => 'no-route'
		),
		array(
				'root_template' => 'three_columns',
				'identifier'    => 'home',
				'title'         => 'Startseite'
		),
		array(
				'root_template' => 'three_columns',
				'identifier'    => 'customer-service'
		),
		array(
				'root_template' => 'three_columns',
				'identifier'    => 'enable-cookies'
		)
);

/**
 * Update system pages
*/
foreach ($cmsPages as $data) {
	$model = Mage::getModel('cms/page')->load($data['identifier']);
	if ( $model->isEmpty() ) {
		continue;
	}
	$model->setRootTemplate($data['root_template'])->save();
}

$content = '<div class="block block-links" id="jumptargetherausgeberboxwidget">
    <div class="block-title">
        <h2>Herausgeber</h2>
    </div>
    <div class="block-content">
        <ul class="links">
            <li><a href="{{store url="impressum"}}">Impressum</a></li>
            <li><a href="{{store url="kontact"}}">Kontakt</a></li>
            <li><a href="{{store url="rechtlichehinweise"}}">rechtliche Hinweise</a></li>
            <li><a href="{{store url="behoerdenwegweiser"}}">Beh&ouml;rdenwegweiser</a></li>
        </ul>
    </div>
</div>
';
//if you want one block for each store view, get the store collection
$stores = Mage::getModel('core/store')->getCollection()->addFieldToFilter('store_id', array('gt'=>0))->getAllIds();
//if you want one general block for all the store viwes, uncomment the line below
$stores = array(0);
/** @var Mage_Cms_Model_Block $block */
$block = Mage::getModel('cms/block')->load('herausgeberbox');
if ($block->isEmpty()) {
    foreach ($stores as $store) {
        /** @var Mage_Cms_Model_Block $block */
        $block = Mage::getModel('cms/block');
        $block->setTitle('herausgeberbox');
        $block->setIdentifier('herausgeberbox');
        $block->setStores(array($store));
        $block->setIsActive(1);
        $block->setContent($content);
        $block->save();
    }
}

try {
    $installer->getConnection()->insertMultiple(
        $installer->getTable('admin/permission_variable'),
        array(
            array('variable_name' => 'general/imprint/company_first', 'is_allowed' => 1),
            array('variable_name' => 'general/imprint/street', 'is_allowed' => 1),
            array('variable_name' => 'general/imprint/zip', 'is_allowed' => 1),
            array('variable_name' => 'general/imprint/city', 'is_allowed' => 1),
            array('variable_name' => 'general/imprint/email', 'is_allowed' => 1),
        )
    );
} catch (Exception $e) {}



$installer->endSetup();
