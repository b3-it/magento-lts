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
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2017 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Cms page edit form main tab
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Egovs_Base_Block_Adminhtml_Permissions_User_Edit_Tab_Main extends Mage_Adminhtml_Block_Permissions_User_Edit_Tab_Main
{

    protected function _prepareForm()
    {
        parent::_prepareForm();
        
        /** @var $model Mage_Admin_Model_User */
        $model = Mage::registry('permissions_user');

        $form = $this->getForm();

        /** @var $fieldset Varien_Data_Form_Element_Fieldset */
        $fieldset = $form->getElement('base_fieldset');
        
        $phoneElement = $fieldset->addField('phone', 'text', array(
            'name'  => 'phone',
            'label' => Mage::helper('egovsbase')->__('Telephone'),
            'id'    => 'phone',
            'title' => Mage::helper('egovsbase')->__('Telephone')
            ),
          'email'
        );

        $phone = $model->getData('phone');
        
        if ($phone) {
            $phoneElement->setValue($phone);
        }
        
        return $this;
    }
}