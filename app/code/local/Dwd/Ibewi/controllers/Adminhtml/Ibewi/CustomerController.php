<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Adminhtml_CustomerController
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Adminhtml_Ibewi_CustomerController extends Dwd_Ibewi_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('report/ibewi')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		try 
		{
			$this->_initAction();
			//$this->verifyDate();
			$this->renderLayout();
		}
		catch(Exception $ex)
		{
			Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
			$this->_redirect('adminhtml/');
		}
	}


  
    public function exportCsvAction()
    {
        $fileName   = 'kunde_'.$this->toDateToString().'.csv';
        $content    = $this->getLayout()->createBlock('ibewi/adminhtml_customer_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content, Dwd_Ibewi_Model_Access_Type::CUSTOMER);
    }

    public function exportXmlAction()
    {
        $fileName   = 'kunde_'.$this->toDateToString().'.xml';
        $content    = $this->getLayout()->createBlock('ibewi/adminhtml_customer_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content, Dwd_Ibewi_Model_Access_Type::CUSTOMER);
    }

    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('report/ibewi/customer');
    			break;
    	}
    }

}