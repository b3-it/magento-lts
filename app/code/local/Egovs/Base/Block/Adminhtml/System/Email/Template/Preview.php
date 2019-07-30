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
* @category    Egovs
* @package     Egovs_Base
* @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

/**
 * Adminhtml system template preview block
*
* @category   Egovs
* @package    Egovs_Base
* @author     Frank Rochlitzer <f.rochlitzer@b3-it.de>
* @copyright  Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
*/
class Egovs_Base_Block_Adminhtml_System_Email_Template_Preview extends Mage_Adminhtml_Block_System_Email_Template_Preview
{
	/**
	 * Prepare html output
	 *
	 * @return string
	 */
	protected function _toHtml()
	{
		// Start store emulation process
		// Since the Transactional Email preview process has no mechanism for selecting a store view to use for
		// previewing, use the default store view
		$defaultStoreId = Mage::app()->getDefaultStoreView()->getId();
		$appEmulation = Mage::getSingleton('core/app_emulation');
		$initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($defaultStoreId);

		/** @var $template Mage_Core_Model_Email_Template */
		$template = Mage::getModel('core/email_template');
		$id = (int)$this->getRequest()->getParam('id');
		if ($id) {
			$template->load($id);
		} else {
			$template->setTemplateType($this->getRequest()->getParam('type'));
			$template->setTemplateText($this->getRequest()->getParam('text'));
			$template->setTemplateStyles($this->getRequest()->getParam('styles'));
		}

		/* @var $filter Mage_Core_Model_Input_Filter_MaliciousCode */
		$filter = Mage::getSingleton('core/input_filter_maliciousCode');
		//Tabs hier nicht filtern
		$_expressions = array(
				//comments, must be first
				'/(\/\*.*\*\/)/Us',
				//javasript prefix
				'/(javascript\s*:)/Usi',
				//import styles
				'/(@import)/Usi',
				//js in the style attribute
				'/style=[^<]*((expression\s*?\([^<]*?\))|(behavior\s*:))[^<]*(?=\>)/Uis',
				//js attributes
				'/(ondblclick|onclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onload|onunload|onerror)\s*=[^<]*(?=\>)/Uis',
				//tags
				'/<\/?(script|link|frame|iframe).*>/Uis',
				//base64 usage
				'/src\s*=[^<]*base64[^<]*(?=\>)/Uis',
		);
		$filter->setExpressions($_expressions);

		$template->setTemplateText(
				$filter->filter($template->getTemplateText())
		);

		Varien_Profiler::start("email_template_proccessing");
		$vars = array();

		$templateProcessed = $template->getProcessedTemplate($vars, true);

		if ($template->isPlain()) {
			$templateProcessed = "<pre>" . htmlspecialchars($templateProcessed) . "</pre>";
		}

		Varien_Profiler::stop("email_template_proccessing");

		// Stop store emulation process
		$appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

		return $templateProcessed;
	}
}