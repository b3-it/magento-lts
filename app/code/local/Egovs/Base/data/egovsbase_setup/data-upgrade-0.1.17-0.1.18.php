<?php

/* @var $installer Mage_Eav_Model_Entity_Setup*/
$installer = $this;
$installer->startSetup();

$content = '<div class="block block-links" id="jumptargetherausgeberboxwidget">
    <div class="block-title">
        <h2>Herausgeber</h2>
    </div>
    <div class="block-content">
        <ul class="links">
            <li><a href="{{store url="impressum"}}">Impressum</a></li>
            <li><a href="{{store url="kontact"}}">Kontakt</a></li>
            <li><a href="{{store url="rechtlichehinweise"}}">rechtliche Hinweise</a></li>
            <li><a href="{{store url="behoerdenwegweiser"}}">Behördenwegweiser</a></li>
        </ul>
    </div>
</div>
';
//if you want one block for each store view, get the store collection
//$stores = Mage::getModel('core/store')->getCollection()->addFieldToFilter('store_id', array('gt'=>0))->getAllIds();
//if you want one general block for all the store viwes, uncomment the line below
$stores = array(0);
foreach ($stores as $store){
	/* @var $collection Mage_Cms_Model_Resource_Block_Collection */
	$collection = Mage::getModel('cms/block')->getCollection();
	$collection->addStoreFilter($store, true);
	$collection->addFieldToFilter('identifier', 'herausgeberbox');
	if ($collection->getSize() > 0) {
		continue;
	}
	
	$block = Mage::getModel('cms/block');
	$block->setTitle('herausgeberbox');
	$block->setIdentifier('herausgeberbox');
	$block->setStores(array($store));
	$block->setIsActive(1);
	$block->setContent($content);
	$block->save();
}


$installer->endSetup();