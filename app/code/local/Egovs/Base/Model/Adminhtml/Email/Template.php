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
 *
 * @category        Egovs
 * @package			Egovs_Base
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * @see 			Mage_Adminhtml_Model_Email_Template
 */
class Egovs_Base_Model_Adminhtml_Email_Template extends Egovs_Base_Model_Core_Email_Template
{
	/**
	 * Xml path to email template nodes
	 *
	 */
	const XML_PATH_TEMPLATE_EMAIL = '//sections/*/groups/*/fields/*[source_model="adminhtml/system_config_source_email_template"]';

	/**
	 * Collect all system config pathes where current template is used as default
	 *
	 * @return array
	 */
	public function getSystemConfigPathsWhereUsedAsDefault()
	{
		$templateCode = $this->getOrigTemplateCode();
		if (!$templateCode) {
			return array();
		}
		$paths = array();

		$configSections = Mage::getSingleton('adminhtml/config')->getSections();

		// find nodes which are using $templateCode value
		$defaultCfgNodes = Mage::getConfig()->getXpath('default/*/*[*="' . $templateCode . '"]');
		if (!is_array($defaultCfgNodes)) {
			return array();
		}

		foreach ($defaultCfgNodes as $node) {
			// create email template path in system.xml
			$sectionName = $node->getParent()->getName();
			$groupName = $node->getName();
			$fieldName = substr($templateCode, strlen($sectionName . '_' . $groupName . '_'));
			$paths[] = array('path' => implode('/', array($sectionName, $groupName, $fieldName)));
		}
		return $paths;
	}

	/**
	 * Collect all system config pathes where current template is currently used
	 *
	 * @return array
	 */
	public function getSystemConfigPathsWhereUsedCurrently()
	{
		$templateId = $this->getId();
		if (!$templateId) {
			return array();
		}
		$paths = array();

		$configSections = Mage::getSingleton('adminhtml/config')->getSections();

		// look for node entries in all system.xml that use source_model=adminhtml/system_config_source_email_template
		// they are will be templates, what we try find
		$sysCfgNodes    = $configSections->xpath(self::XML_PATH_TEMPLATE_EMAIL);
		if (!is_array($sysCfgNodes)) {
			return array();
		}

		foreach ($sysCfgNodes as $fieldNode) {

			$groupNode = $fieldNode->getParent()->getParent();
			$sectionNode = $groupNode->getParent()->getParent();

			// create email template path in system.xml
			$sectionName = $sectionNode->getName();
			$groupName = $groupNode->getName();
			$fieldName = $fieldNode->getName();

			$paths[] = implode('/', array($sectionName, $groupName, $fieldName));
		}

		$configData = $this->_getResource()->getSystemConfigByPathsAndTemplateId($paths, $templateId);
		if (!$configData) {
			return array();
		}

		return $configData;
	}
	
	
	
    /**
     * Parse variables string into array of variables
     *
     * @param string $variablesString
     * @return array
     */
    protected function _parseVariablesString($variablesString)
    {
        $variables = array();
        if ($variablesString && is_string($variablesString)) {
            $variablesString = str_replace("\n", '', $variablesString);
            try{
            	$variables = Zend_Json::decode($variablesString);
            }catch(Exception $ex){
            	//Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
            	$msg = "@var Error ". $ex->getMessage(). " Template ID:" . $this->getId();
            	Mage::log($msg, Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
            }
        }
        return $variables;
    }
	
	

	/**
	 * Delete current usage
	 *
	 * @return Mage_Adminhtml_Model_Email_Template
	 */
	protected function _afterDelete() {
		$paths = $this->getSystemConfigPathsWhereUsedCurrently();
		foreach ($paths as $path) {
			$configDataCollection = Mage::getModel('core/config_data')
			->getCollection()
			->addFieldToFilter('scope', $path['scope'])
			->addFieldToFilter('scope_id', $path['scope_id'])
			->addFieldToFilter('path', $path['path']);
			foreach ($configDataCollection as $configItem) {
				$configItem->delete();
			}
		}
		return parent::_afterDelete();
	}
}