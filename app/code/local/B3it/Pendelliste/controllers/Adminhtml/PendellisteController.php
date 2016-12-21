<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category B3it
 *  @package  B3it_Pendelliste
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_Pendelliste_Adminhtml_PendellisteController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('pendelliste/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		
		$import = Mage::getModel('pendelliste/restImport');
		$import->importTaskList();
		
		
		$this->_initAction()
			->renderLayout();
	}


	public function importAction()
	{
		$id     = $this->getRequest()->getParam('id');
		$pendel  = Mage::getModel('pendelliste/pendelliste')->load($id);
		$import = Mage::getModel('pendelliste/restImport');
		$model = $import->getTask($pendel->getTaskId());
		
		if($model){
			$model->import();
		}
		
	}
  
	
    public function massStatusAction()
    {
        $pendellisteIds = $this->getRequest()->getParam('pendelliste');
        if(!is_array($pendellisteIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($pendellisteIds as $pendellisteId) {
                    $pendelliste = Mage::getSingleton('pendelliste/pendelliste')
                        ->load($pendellisteId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($pendellisteIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }


}