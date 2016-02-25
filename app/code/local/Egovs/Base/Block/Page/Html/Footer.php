<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Page
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Html page block
 *
 * @category   Egovs
 * @package    Egovs_Base
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Base_Block_Page_Html_Footer extends Mage_Page_Block_Html_Footer
{
	protected $_canShowVersion = null;
	
	public function canShowVersion() {
		if (is_null($this->_canShowVersion)) {
			$mode = Mage::getStoreConfig("admin/design/shop_mode");
			//Wenn nicht Produktion
			if ($mode != 3) {
				$this->_canShowVersion = true;
			} else {
				$this->_canShowVersion = false;
			}
		}
			
		return $this->_canShowVersion;
	}
	
	public function getVersion() {
		if ($this->canShowVersion()) {
			return Mage::getVersion();
		}
		
		return '';
	}
}