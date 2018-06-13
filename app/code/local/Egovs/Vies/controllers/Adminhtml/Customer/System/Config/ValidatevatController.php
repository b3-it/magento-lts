<?php
require_once "Mage/Adminhtml/controllers/Customer/System/Config/ValidatevatController.php";
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
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Erweitert die Kundengruppen um Regeln zur automatischen Zuordnung
 *
 * @category	Egovs
 * @package		Egovs_Vies
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Vies_Adminhtml_Customer_System_Config_ValidatevatController extends Mage_Adminhtml_Customer_System_Config_ValidatevatController
{
    /**
     * Retrieve validation result as JSON
     *
     * @return void
     */
    public function validateAdvancedAction() {
        /** @var $coreHelper Mage_Core_Helper_Data */
        $coreHelper = Mage::helper('core');

        $result = $this->_validate();
        $valid = $result->getIsValid();
        $success = $result->getRequestSuccess();
        // ID of the store where order is placed
        $storeId = $this->getRequest()->getParam('store_id');
        // Sanitize value if needed
        if (!is_null($storeId)) {
            $storeId = (int)$storeId;
        }

        $data = array('taxvat_valid' => $result->getIsValid(), 'country_id' => $this->getRequest()->getParam('country'));
        if (!$result->getRequestSuccess()) {
        	$groupId = (int)Mage::getStoreConfig(Mage_Customer_Helper_Data::XML_PATH_CUSTOMER_VIV_ERROR_GROUP, $storeId);
        } else {
        	$groupId = Mage::helper('egovsvies')->getGroupIdByCustomerGroupRules($data);
        		
        	//Falls nichts gematched hat!!!
        	if (is_null($groupId)) {
        		$groupId = Mage::helper('customer')->getDefaultCustomerGroupId($storeId);
        	}
        }

        $body = $coreHelper->jsonEncode(array(
            'valid' => $valid,
            'group' => $groupId,
            'success' => $success
        ));
        $this->getResponse()->setBody($body);
    }
}
