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
 * Sales report admin controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Report_Adminhtml_Sidreport_SalesController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Admin session model
     *
     * @var null|Mage_Admin_Model_Session
     */
    protected $_adminSession = null;

    public function _initAction()
    {
        $this->loadLayout()
            ->_addBreadcrumb(Mage::helper('reports')->__('Reports'), Mage::helper('reports')->__('Reports'))
            ->_addBreadcrumb(Mage::helper('reports')->__('Sales'), Mage::helper('reports')->__('Sales'));
        return $this;
    }

    public function _initReportAction($blocks)
    {
        if (!is_array($blocks)) {
            $blocks = array($blocks);
        }

        $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));
        $requestData = $this->_filterDates($requestData, array('from', 'to'));
        $requestData['store_ids'] = $this->getRequest()->getParam('store_ids');
        $params = new Varien_Object();

        foreach ($requestData as $key => $value) {
            if (!empty($value)) {
                $params->setData($key, $value);
            }
        }

        foreach ($blocks as $block) {
            if ($block) {
                $block->setPeriodType($params->getData('period_type'));
                $block->setFilterData($params);
            }
        }

        return $this;
    }

    public function salesAction()
    {
        $this->_title($this->__('Reports'))->_title($this->__('Sales'))->_title($this->__('Frame Contract'));


        $this->_initAction()
            ->_setActiveMenu('sidreport/sales/sales')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Frame Contract'), Mage::helper('adminhtml')->__('Frame Contract'));

        //Muss mit $this->_controller aus Container Grid übereinstimmen
        $gridBlock = $this->getLayout()->getBlock('adminhtml_sales.grid');
        $filterFormBlock = $this->getLayout()->getBlock('grid.filter.form');

        $this->_initReportAction(array(
            $gridBlock,
            $filterFormBlock
        ));

        $this->renderLayout();
    }





    /**
     * Export sales report grid to CSV format
     */
    public function exportSalesCsvAction()
    {
        $fileName   = 'framecontract.csv';
        $grid       = $this->getLayout()->createBlock('sidreport/adminhtml_sales_grid');
        $this->_initReportAction($grid);
        $this->_prepareDownloadResponse($fileName, $grid->getCsv());
    }

    /**
     * Export sales report grid to Excel XML format
     */
    public function exportSalesExcelAction()
    {
        $fileName   = 'framecontract.xml';
        $grid       = $this->getLayout()->createBlock('sidreport/adminhtml_sales_grid');
        $this->_initReportAction($grid);
        $this->_prepareDownloadResponse($fileName, $grid->getExcel($fileName));
    }

 


    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'sales':
                return $this->_getSession()->isAllowed('report/salesroot/frame_contract_report');
                break;
            case 'exportSalesCsv':
                return $this->_getSession()->isAllowed('report/salesroot/frame_contract_report');
                break;
            case 'exportSalesExcel':
                return $this->_getSession()->isAllowed('report/salesroot/frame_contract_report');
                break;
                

        }
    }

    /**
     * Retrieve admin session model
     *
     * @return Mage_Admin_Model_Session
     */
    protected function _getSession()
    {
        if (is_null($this->_adminSession)) {
            $this->_adminSession = Mage::getSingleton('admin/session');
        }
        return $this->_adminSession;
    }
}
