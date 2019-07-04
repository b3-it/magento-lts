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
 * @copyright  Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Adminhtml catalog super product configurable tab
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Acl_Block_Adminhtml_Catalog_Product_Edit_Tab_Super_Config extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Super_Config
{
    /**
     * Prepare Layout data
     *
     * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Super_Config
     */
    protected function _prepareLayout() {
        $canAdd = Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/newproducts');

        $this->setChild('grid',
            $this->getLayout()->createBlock('adminhtml/catalog_product_edit_tab_super_config_grid',
                'admin.product.edit.tab.super.config.grid')
        );
        if ($canAdd) {
            $this->setChild('create_empty',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label' => Mage::helper('catalog')->__('Create Empty'),
                        'class' => 'add',
                        'onclick' => 'superProduct.createEmptyProduct()',
                    ))
            );

            if ($this->_getProduct()->getId()) {
                $this->setChild('simple',
                    $this->getLayout()->createBlock('adminhtml/catalog_product_edit_tab_super_config_simple',
                        'catalog.product.edit.tab.super.config.simple')
                );

                $this->setChild('create_from_configurable',
                    $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label' => Mage::helper('catalog')->__('Copy From Configurable'),
                            'class' => 'add',
                            'onclick' => 'superProduct.createNewProduct()',
                        ))
                );
            }
        }
        return Mage_Adminhtml_Block_Widget::_prepareLayout();
    }
}
