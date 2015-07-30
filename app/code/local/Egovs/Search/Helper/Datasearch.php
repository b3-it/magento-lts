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
 * @package    Mage_CatalogSearch
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog search helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Search_Helper_Datasearch extends Mage_CatalogSearch_Helper_Data
{


    /**
     * Retrieve search query text
     *
     * @return string
     */
    public function getQueryText()
    {
        if (is_null($this->_queryText)) {
            $this->_queryText = $this->_getRequest()->getParam($this->getQueryParamName());
            if ($this->_queryText === null) {
                $this->_queryText = '';
            } else {
                if (is_array($this->_queryText)) {
                    $this->_queryText = null;
                }
                $this->_queryText = trim($this->_queryText);
                $this->_queryText = Mage::helper('core/string')->cleanString($this->_queryText);
				$this->_queryText = Mage::helper('egovssearch')->htmlEntityDecode($this->_queryText);
                if (Mage::helper('core/string')->strlen($this->_queryText) > $this->getMaxQueryLength()) {
                    $this->_queryText = Mage::helper('core/string')->substr(
                        $this->_queryText,
                        0,
                        $this->getMaxQueryLength()
                    );
                    $this->_isMaxLength = true;
                }
            }
        }
        return $this->_queryText;
    }

 
    
}
