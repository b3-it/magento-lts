<?php

/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2022-2024 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * user roles block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 */
class Mage_Adminhtml_Block_Permissions_Roles extends Mage_Adminhtml_Block_Template
{
    /**
     * Get URL of adding new record
     *
     * @return string
     */
    public function getAddNewUrl()
    {
        return $this->getUrl('*/*/editrole');
    }

    /**
     * Get URL for refreshing role-rule relations
     *
     * @return string
     */
    public function getRefreshRolesUrl()
    {
        return $this->getUrl('*/*/refreshroles');
    }

    /**
     * Get grid HTML
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChild('grid')->toHtml();
    }
}
