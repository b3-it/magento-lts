<?php

class Egovs_Base_Model_System_Email_Template_Observer 
{
	
	public function onPrepareLayoutAfter($observer)
	{
		if (!$observer)
			return;
		
		if (!($observer->getBlock() instanceof Mage_Adminhtml_Block_System_Email_Template_Edit))
			return;
		
		/* @var $block Mage_Adminhtml_Block_System_Email_Template_Edit */
		$block = $observer->getBlock();
		$block->getMessagesBlock()->addNotice(Mage::helper('egovsbase')->__('Use --END_OF_HTML_MAIL to build multipart messages'));
	}
}

?>