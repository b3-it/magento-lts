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
 * @package     Mage_Bundle
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Bundle option renderer
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_EventBundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Option extends Mage_Bundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Bundle_Option
{


    public function getRequireSelectHtml()
    {
    	$opt = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
    	$opt[Egovs_EventBundle_Model_Product_Type::OPTION_VERIFIED] = Mage::helper('eventbundle')->__("verified"); 
        $select = $this->getLayout()->createBlock('adminhtml/html_select')
            ->setData(array(
                'id' => $this->getFieldId().'_{{index}}_required',
                'class' => 'select'
            ))
            ->setName($this->getFieldName().'[{{index}}][required]')
            ->setOptions($opt);

        return $select->getHtml();
    }
    
    
    protected function _prepareLayout()
    {
    	 $this->setChild('add_selection_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'id'    => $this->getFieldId().'_{{index}}_add_button',
                    'label'     => Mage::helper('bundle')->__('Add Selection'),
                    'on_click'   => 'bSelection.showSearch(event)',
                    'class' => 'add'
                )));

        $this->setChild('close_search_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'id'    => $this->getFieldId().'_{{index}}_close_button',
                    'label'     => Mage::helper('bundle')->__('Close'),
                    'on_click'   => 'bSelection.closeSearch(event)',
                    'class' => 'back no-display'
                )));

        $this->setChild('option_delete_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('catalog')->__('Delete Option'),
                    'class' => 'delete delete-product-option',
                    'on_click' => 'bOption.remove(event)'
                ))
        );

        $this->setChild('selection_template',
            $this->getLayout()->createBlock('eventbundle/adminhtml_catalog_product_edit_tab_option_selection')
        );
    
            
    	return Mage_Adminhtml_Block_Widget::_prepareLayout();
    }
    
    
}
