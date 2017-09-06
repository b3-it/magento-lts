<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$cms_blocks = array(
		array(
				'title'      => 'SlpB - Lieferungshinweis',
				'identifier' => 'slpb_liefer_block',
				'content'    => '<div class="slpb-lieferung-hinweis">
Lieferzeit 5 - 14 Tage <a href="{{store url="bereitstellung"}}">zzgl. Bereitstellungspauschale (ab 6 Sternchen)</a>
</div>',
				'isactive'   => 1,
				'stores'     => array(0)
		)
	);

foreach( $cms_blocks AS $data ) {
	$block = Mage::getModel('cms/block');
	
	if ( $block->load($data['identifier'])->isEmpty() ) {
		$block->setData($data)->save();
	}
}

		
$installer->endSetup();
