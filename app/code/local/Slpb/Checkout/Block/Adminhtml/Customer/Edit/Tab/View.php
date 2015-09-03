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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Customer account form block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Slpb_Checkout_Block_Adminhtml_Customer_Edit_Tab_View
 extends Mage_Adminhtml_Block_Customer_Edit_Tab_View
{
	private $_helper = null;
	protected function _beforeToHtml()
	{
		$this->setTemplate('slpb/customer/edit/tab/view.phtml');
	}
	
	public function getKundennummer()
	{
		$model = Mage::getModel('slpbcheckout/abstract'); 
        return $model->encodeCustumerId($this->getCustomer()->getId());
	}
	
	public function getTranslate($text)
	{
		if($this->_helper == null)
		{
			$this->_helper = Mage::helper("adminhtml");
		}
		return  $this->_helper->__($text);
	}

}
