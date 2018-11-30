<?php
/**
 * Widget für Kreditkartenlogos
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Widget_Creditcardlogos extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
	/**
	 * Block rendern
	 *
	 * @return string
	 *
	 * @see Mage_Core_Block_Template::_toHtml()
	 */
	protected function _toHtml() {
		$payments = Mage::getSingleton('payment/config')->getActiveMethods();

		if (!array_key_exists('saferpay', $payments) AND
		    !array_key_exists('egovs_girosolution_giropay', $payments) AND
			!array_key_exists('egovs_girosolution_creditcard', $payments) AND
			!$this->getForceEnabled()
		   ) {
			return '';
		}

		if ($this->hasCustomCmsBlock()) {
			$block = $this->getCustomCmsBlock();

			if (!$block->getIsActive()) {
				return '';
			}

			$helper = Mage::helper('cms');
			$processor = $helper->getBlockTemplateProcessor();
			$html = $processor->filter($block->getContent());
			return $html;
		}
		return parent::_toHtml();
	}

	/**
	 * Übersetzt den Title des CMS-Blocks
	 *
	 * @return string
	 */
	public function getTitle() {
		return Mage::helper('paymentbase')->__($this->getData('title'));
	}

	/**
	 * Prüft ob das Widget immer aktiviert sein soll.
	 *
	 * Falls force_enabled true ist wird das Widget unabhängig vom Status des Kreditkarten Zahlmoduls angezeigt.
	 *
	 * @return boolean
	 */
	public function getForceEnabled() {
		return $this->getData('force_enabled') == 1 ? true : false;
	}

	/**
	 * Prüft ob ein individueller CMS Block konfiguriert wurde.
	 *
	 * @return boolean
	 */
	public function hasCustomCmsBlock() {
		return $this->getData('custom_cms_block') == 0 ? false : true;
	}

	/**
	 * Gibt den entsprechenden CMS Block zurück
	 *
	 * Der Block kann ggf. leer sein.
	 *
	 * @return Mage_Cms_Model_Block
	 */
	public function getCustomCmsBlock() {
		$blockId = $this->getData('custom_cms_block');
		return Mage::getModel('cms/block')->load($blockId);
	}
}
