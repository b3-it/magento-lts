<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Adminhtml_EventManager_ToCmsController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Adminhtml_EventManager_ToCmsController extends Mage_Adminhtml_Controller_action
{

	public function indexAction() {
		$this->loadLayout();
        $this->_setActiveMenu('bfr_eventmanager/eventmanager_event');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()->createBlock('eventmanager/adminhtml_toCms_new'));
        $this->renderLayout();
	}

	public function createAction()
	{
		if ($data = $this->getRequest()->getPost()) {
			if(isset($data['event_id'])){
			    try {
                    $block = Mage::getModel('eventmanager/copyToCms')->createCmsBlock($data);
                }catch(Exception $e)
                {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    $this->_redirect('*/eventmanager_event/edit', array('id' => intval($data['event_id'])));
                    return;
                }
				$this->_redirect('*/cms_block/edit',array('block_id' => $block->getId()));
				return;
			}
		}
		
		$this->_redirect('*/eventmanager/index');
		return;
	}

    protected function _isAllowed() {
    	return Mage::getSingleton('admin/session')->isAllowed('bfr_eventmanager/eventmanager_event');
    }
    
    
    
    
    

    
    
    
}
