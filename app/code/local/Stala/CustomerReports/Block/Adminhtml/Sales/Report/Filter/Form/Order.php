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
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Sales Adminhtml report filter form order
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author     Magento Core Team <core@magentocommerce.com>
 */

class Stala_CustomerReports_Block_Adminhtml_Sales_Report_Filter_Form_Order  extends Mage_Sales_Block_Adminhtml_Report_Filter_Form_Order
{
    protected function _prepareForm()
    {
        parent::_prepareForm();
        $form = $this->getForm();
        $htmlIdPrefix = $form->getHtmlIdPrefix();
        /** @var Varien_Data_Form_Element_Fieldset $fieldset */
        $fieldset = $this->getForm()->getElement('base_fieldset');

        if (is_object($fieldset) && $this->showCustomerGroupSelection() && $fieldset instanceof Varien_Data_Form_Element_Fieldset) {

            $fieldset->addField('customergroup', 'select', array(
                'name'       => 'customergroup',
                'options'    => Mage::helper('stalareports')->getGroupCollectionToOptionArray(),
                'label'      => Mage::helper('reports')->__('Customer Group'),
            ));

        }

        return $this;
    }
    
    protected function showCustomerGroupSelection()
    {
    	$parent = $this->getParentBlock();
    	if($parent)
    	{
    		$child = $parent->getChild('grid');
    		return preg_match("/^Stala/", get_class($child)) > 0;
    	}
    	
    	return false;
    }
}
