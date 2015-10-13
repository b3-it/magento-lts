<?php
/**
 * Formblock für Giropay über Saferpay
 *
 * @category   	Egovs
 * @package    	Egovs_Giropay
 * @name       	Egovs_Giropay_Block_Form
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Giropay_Block_Form extends Mage_Payment_Block_Form
{

	/**
	 * Setzt ein eigenes Template
	 *
	 * @return void
	 *
	 * @see Mage_Core_Block_Abstract::_construct()
	 */
	protected function _construct() {

		parent::_construct();
	}
	
	/**
	 * Render block HTML
	 *
	 * @return string
	 */
	protected function _toHtml() {
		$_html = parent::_toHtml();
		
		$_cmsBlock = Mage::getStoreConfig("payment/giropay/cms_block");
		if (!empty($_cmsBlock)) {
			$_html .= $this->getLayout()->createBlock('cms/block')
				->setBlockId($_cmsBlock)
				->toHtml();
		}
		
		return $_html;
	}
}