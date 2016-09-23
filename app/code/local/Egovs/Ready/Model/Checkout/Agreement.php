<?php
/**
 *
 * Erweiterung für Agreements
 *
 *
 *
 * @category		Egovs
 * @package			Egovs_Ready
 * @name			Egovs_Ready_Checkout_Agreement
 * @author			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright		Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license			http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * @version			0.1.5.0
 * @since			0.1.5.0
 *
 */
class Egovs_Ready_Model_Checkout_Agreement extends Mage_Checkout_Model_Agreement
{
	/**
	 * Funktion zum Parsen von Magento-Variablen für Agreement content.
	 *
	 * @return string
	 */
	public function getContent() {
		$content = $this->getData('content');
		$processor = Mage::getModel('cms/template_filter');
		$html = $processor->filter($content);
	
		return $html;
	}
	
	/**
	 * Funktion zum Parsen von Magento-Variablen für Agreement checkbox text hinzufügen.
	 *
	 * @return string
	 */
	public function getCheckboxText() {
		$content = $this->getData('checkbox_text');
		$processor = Mage::getModel('cms/template_filter');
		$html = $processor->filter($content);
	
		return $html;
	}
}