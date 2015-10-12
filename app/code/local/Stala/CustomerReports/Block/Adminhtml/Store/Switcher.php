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
 * Store switcher block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Stala_CustomerReports_Block_Adminhtml_Store_Switcher extends Mage_Adminhtml_Block_Store_Switcher
{
    public function getSwitchUrl()
    {
    	$sw = '';
    	$cgroup = Mage::registry('cgroup');
    	if (isset($cgroup)) {
            $sw = "cgroup/$cgroup";
        }
        if (strlen($sw) > 0)
        	$sw .= '/';
        if ($url = $this->getData('switch_url')) {
            return $url.$sw;
        }
        
        return $this->getUrl('*/*/*', array('_current' => true, 'store' => null)).$sw;
    }
}
