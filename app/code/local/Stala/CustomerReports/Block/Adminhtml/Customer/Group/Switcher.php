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
class Stala_CustomerReports_Block_Adminhtml_Customer_Group_Switcher extends Mage_Adminhtml_Block_Template
{
    /**
     * @var bool
     */
    protected $_hasDefaultOption = true;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('stala/customerreports/switcher.phtml');
        $this->setUseConfirm(true);
        $this->setUseAjax(true);
        $this->setModuleName('Stala_CustomerReports');
    }

    /**
     * Get Customer groups
     * @return Mage_Customer_Model_Entity_Group_Collection
     */
    public function getGroupCollection()
    {
    	/* @var $collection Mage_Customer_Model_Entity_Group_Collection */
        $collection = Mage::getResourceModel('customer/group_collection');
        
        //Bei einigen Reports machen Gäste keinen Sinn -> filtern!
        if (isset($collection)
        	&& ($this->getParentBlock() instanceof Stala_CustomerReports_Block_Adminhtml_Report_Customer_Orders_Grid
        		|| $this->getParentBlock() instanceof Stala_CustomerReports_Block_Adminhtml_Report_Customer_Totals_Grid
        		|| $this->getParentBlock() instanceof Stala_CustomerReports_Block_Adminhtml_Report_Customer_Accounts_Grid
        		)
        	) {
        		$collection->addFieldToFilter('customer_group_id',array('gt'=> 0));
        	}
        return $collection;
    }

    public function getSwitchUrl()
    {
    	$sw = '';
    	$store = Mage::registry('store');
    	$website = Mage::registry('website');
    	$group = Mage::registry('group');
    	
    	if (isset($store)) {
            $sw = "store/$store";
        } else if (isset($website)){
            $sw = "website/$website";
        } else if (isset($group)){
            $sw = "group/$group";
        }
        if (strlen($sw) > 0)
        	$sw .= '/';
        if ($url = $this->getData('switch_url')) {
            return $url.$sw;
        }
        
        return $this->getUrl('*/*/*', array('_current' => true, 'store' => null)).$sw;
    }

    /**
     * Set/Get whether the switcher should show default option
     *
     * @param bool $hasDefaultOption
     * @return bool
     */
    public function hasDefaultOption($hasDefaultOption = null)
    {
        if (null !== $hasDefaultOption) {
            $this->_hasDefaultOption = $hasDefaultOption;
        }
        return $this->_hasDefaultOption;
    }
}
