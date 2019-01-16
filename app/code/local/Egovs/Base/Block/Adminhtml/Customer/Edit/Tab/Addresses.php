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
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Customer addresses forms
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Base_Block_Adminhtml_Customer_Edit_Tab_Addresses extends Mage_Adminhtml_Block_Customer_Edit_Tab_Addresses
{
	
	
	public function initForm()
	{
		parent::initForm();
		
		$customer = Mage::registry('current_customer');
		$customerStoreId = null;
		if ($customer->getId()) {
			$customerStoreId = Mage::app()->getWebsite($customer->getWebsiteId())->getDefaultStore()->getId();
		}
		
		$data['form'] = $this->getForm();
		$data['customer_store_id'] = $customerStoreId;
		Mage::dispatchEvent('adminhtml_block_customer_edit_tab_addresses_init_after',$data);
		
		return $this;
	}
	
	
	/**
     * Set Fieldset to Form
     *
     * @param array $attributes attributes that are to be added
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     * @param array $exclude attributes that should be skipped
     * 
     * @see Stala_CustomerAddressBulks_Block_Adminhtml_Customer_Edit_Tab_Addresses
     */
    protected function _setFieldset($attributes, $fieldset, $exclude=array())
    {
        /** @var \Egovs_Base_Helper_Config $egovsHelper */
    	$egovsHelper = null;
    	try {
    		if (Mage::helper('core')->isModuleEnabled('Egovs_Base')) {
    			$egovsHelper = Mage::helper('egovsbase/config');
    		} else {
    			Mage::log("Helper 'egovsbase/config' not available!", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    		}
    	} catch (Exception $e) {
    		Mage::log("Helper 'egovsbase/config' not available! Exception:\n{$e->getMessage()}", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    	}

    	/** @var \Mage_Customer_Model_Customer $customer */
        $customer = Mage::registry('current_customer');
    	$store = null;
    	if ($customer->getId()) {
    	    $store = $customer->getStore();
        }
    	
        $this->_addElementTypes($fieldset);
        foreach ($attributes as $attribute) {
            /* @var $attribute Mage_Eav_Model_Entity_Attribute */
            if (!$attribute || ($attribute->hasIsVisible() && !$attribute->getIsVisible())) {
                continue;
            }
            
            if ( ($inputType = $attribute->getFrontend()->getInputType())
                && ('media_image' !== $inputType)
                && !in_array($attribute->getAttributeCode(), $exclude)
            ) {
                $fieldType      = $inputType;
                $rendererClass  = $attribute->getFrontend()->getInputRendererClass();
                if (!empty($rendererClass)) {
                    $fieldType  = $inputType . '_' . $attribute->getAttributeCode();
                    $fieldset->addType($fieldType, $rendererClass);
                }

                try {
                    $element = $fieldset->addField($attribute->getAttributeCode(), $fieldType,
                        array(
                            'name' => $attribute->getAttributeCode(),
                            'label' => $attribute->getFrontend()->getLabel(),
                            'class' => $attribute->getFrontend()->getClass(),
                            'required' => $egovsHelper !== NULL ? $egovsHelper->isFieldRequired($attribute->getAttributeCode(), 'register', $store) : $attribute->getIsRequired(),
                            'note' => $attribute->getNote(),
                        )
                    )->setEntityAttribute($attribute);
                } catch (Mage_Core_Model_Store_Exception $e) {
                    Mage::logException($e);
                    $element = $fieldset->addField($attribute->getAttributeCode(), $fieldType,
                        array(
                            'name' => $attribute->getAttributeCode(),
                            'label' => $attribute->getFrontend()->getLabel(),
                            'class' => $attribute->getFrontend()->getClass(),
                            'required' => $attribute->getIsRequired(),
                            'note' => $attribute->getNote(),
                        )
                    )->setEntityAttribute($attribute);
                }

                $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));

                if ($inputType == 'select') {
                    $element->setValues($attribute->getSource()->getAllOptions(true, true));
                } else if ($inputType == 'multiselect') {
                    $element->setValues($attribute->getSource()->getAllOptions(false, true));
                } else if ($inputType == 'date') {
                    $element->setImage($this->getSkinUrl('images/grid-cal.gif'));
                    $element->setFormat(
                        Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
                    );
                } else if ($inputType == 'multiline') {
                    $element->setLineCount($attribute->getMultilineCount());
                }
            }
        }
    }
}