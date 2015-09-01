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

class Sid_Report_Block_Adminhtml_Sales_Filter_Form_Order extends Mage_Sales_Block_Adminhtml_Report_Filter_Form
{
    protected function x_prepareForm()
    {
        parent::_prepareForm();
        $form = $this->getForm();
        $htmlIdPrefix = $form->getHtmlIdPrefix();
        /** @var Varien_Data_Form_Element_Fieldset $fieldset */
        $fieldset = $this->getForm()->getElement('base_fieldset');

        if (is_object($fieldset) && $fieldset instanceof Varien_Data_Form_Element_Fieldset) {

            $fieldset->addField('show_actual_columns', 'select', array(
                'name'       => 'show_actual_columns',
                'options'    => array(
                    '1' => Mage::helper('reports')->__('Yes'),
                    '0' => Mage::helper('reports')->__('No')
                ),
                'label'      => Mage::helper('reports')->__('Show Actual Values'),
            ));

        }

        return $this;
    }
    
    protected function _prepareForm()
    {
        $actionUrl = $this->getUrl('*/*/sales');
        $form = new Varien_Data_Form(
            array('id' => 'filter_form', 'action' => $actionUrl, 'method' => 'get')
        );
        $htmlIdPrefix = 'sales_report_';
        $form->setHtmlIdPrefix($htmlIdPrefix);
        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('reports')->__('Filter')));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);

        $fieldset->addField('store_ids', 'hidden', array(
            'name'  => 'store_ids'
        ));
/*
        $fieldset->addField('report_type', 'select', array(
            'name'      => 'report_type',
            'options'   => $this->_reportTypeOptions,
            'label'     => Mage::helper('reports')->__('Match Period To'),
        ));
*/
        $fieldset->addField('period_type', 'select', array(
            'name' => 'period_type',
            'options' => array(
                'day'   => Mage::helper('reports')->__('Day'),
                'month' => Mage::helper('reports')->__('Month'),
                'year'  => Mage::helper('reports')->__('Year')
            ),
            'label' => Mage::helper('reports')->__('Period'),
            'title' => Mage::helper('reports')->__('Period')
        ));

        $fieldset->addField('from', 'date', array(
            'name'      => 'from',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'label'     => Mage::helper('reports')->__('From'),
            'title'     => Mage::helper('reports')->__('From'),
            'required'  => true
        ));

        $fieldset->addField('to', 'date', array(
            'name'      => 'to',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'label'     => Mage::helper('reports')->__('To'),
            'title'     => Mage::helper('reports')->__('To'),
            'required'  => true
        ));
        
        
        $fieldset->addField('customer_group', 'select', array(
            'name'      => 'customer_group',
            'label'     => Mage::helper('reports')->__('Customer Group'),
            'title'     => Mage::helper('reports')->__('Customer Group'),
        	'options'	=> $this->getCustomerGroupsArray()
            //'required'  => true
        ));
        
       $fieldset->addField('framecontract', 'select', array(
            'name'      => 'framecontract',
            'label'     => Mage::helper('sidreport')->__('Frame Contract'),
            'title'     => Mage::helper('sidreport')->__('Frame Contract'),
        	'options'	=> $this->getFramecontractArray()
            //'required'  => true
        ));
        
       $fieldset->addField('dienststelle', 'text', array(
            'name'      => 'dienststelle',
            'label'     => Mage::helper('sidreport')->__('Dienststelle'),
            'title'     => Mage::helper('sidreport')->__('Dienststelle'),
            //'required'  => true
        ));
        
/*
        $fieldset->addField('show_empty_rows', 'select', array(
            'name'      => 'show_empty_rows',
            'options'   => array(
                '1' => Mage::helper('reports')->__('Yes'),
                '0' => Mage::helper('reports')->__('No')
            ),
            'label'     => Mage::helper('reports')->__('Empty Rows'),
            'title'     => Mage::helper('reports')->__('Empty Rows')
        ));
*/
        $form->setUseContainer(true);
        $this->setForm($form);

        return Mage_Adminhtml_Block_Widget_Form::_prepareForm();
    }
    
    private function getCustomerGroupsArray()
    {
    	$res = array();
    	$cg = Mage::getModel('customer/group')->getCollection();
    	$res['-1'] = "All";
    	foreach ($cg->getItems() as $item)
    	{
    		$res[$item->getId()] = $item->getCustomerGroupCode();
    	}
    	return $res;
    }
    
	private function getFramecontractArray()
    {
    	$res = array();
    	$cg = Mage::getModel('framecontract/contract')->getCollection();
    	$res['-1'] = "All";
    	foreach ($cg->getItems() as $item)
    	{
    		$res[$item->getId()] = $item->getTitle();
    	}
    	return $res;
    }
    
}
