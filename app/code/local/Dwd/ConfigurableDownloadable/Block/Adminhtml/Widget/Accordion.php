<?php
/**
 * Configurable Downloadable Accordion Widget
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Block_Adminhtml_Widget_Accordion extends Mage_Adminhtml_Block_Widget_Accordion
{
	/**
	 * Add accordion item by specified block
	 *
	 * @param string                   $itemId ID
	 * @param Mage_Core_Block_Abstract $block  Block
	 * 
	 * @return void
	 */
	public function addAccordionItem($itemId, $block)
	{
		if (strpos($block, '/') !== false) {
			$block = $this->getLayout()->createBlock($block);
		} else {
			$block = $this->getLayout()->getBlock($block);
		}

		if (!$block) {
			return;
		}
			
		$this->addItem($itemId, array(
				'title'   => Mage::helper('configdownloadable')->__($block->getTitle()),
				//Damit es in richtiger Reihenfolge gerendert wird -> ohne toHtml() aufrufen! 
				'content' => $block,
				'open'    => $block->getIsOpen(),
		));
	}
}