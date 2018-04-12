<?php

class Bkg_VirtualAccess_Adminhtml_VirtualAccess_CredentialController extends Mage_Adminhtml_Controller_action
{
	//TODO: HK andere action wählen
	protected $_publicActions = array('index');
	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('sales/credential')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Credentials'), Mage::helper('adminhtml')->__('Credentials'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction();
		
		$item_id = intval($this->getRequest()->getParam('item_id'));
		
		if($item_id){
			$this->getLayout()->getBlock('credential')
				->getChild('grid')
				->setDefaultFilter(array("item_id"=>array('from'=>$item_id, "to"=>$item_id)));
		}
		
		$this->renderLayout();
	}

	public function showAction() {
		$id     = intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('virtualaccess/purchased_item')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('action_data', $model);

			$this->_initAction();


			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('virtualaccess/adminhtml_purchaseditem_edit'))
				->_addLeft($this->getLayout()->createBlock('virtualaccess/adminhtml_purchaseditem_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtualaccess')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

    public function editAction() {
        $id     = intval($this->getRequest()->getParam('id'));
        $model  = Mage::getModel('virtualaccess/purchased_credential')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('action_data', $model);

            $this->_initAction();


            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('virtualaccess/adminhtml_purchaseditem_edit_tab_credential_edit'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtualaccess')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
 
	public function newAction() {
        $id     = intval($this->getRequest()->getParam('item_id'));
        $model  = Mage::getModel('virtualaccess/purchased_credential');
        $model->setPurchasedItemId($id)
            ->createUuid()
            ->save();

            Mage::register('action_data', $model);

            $this->_initAction();


            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('virtualaccess/adminhtml_purchaseditem_edit_tab_credential_edit'));

            $this->renderLayout();

	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('virtualaccess/purchased_credential')->load(intval($this->getRequest()->getParam('credential_id')));

            foreach($data as $k=>$v)
            {
                $model->setData($k,$v);
            }

			$model->setId(intval($this->getRequest()->getParam('credential_id')));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtualaccess')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);


				$this->_redirect('*/*/show', array('id' => $model->getPurchasedItemId()));
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => intval($this->getRequest()->getParam('credential_id'))));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtualaccess')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
			    $id = intval($this->getRequest()->getParam('id'));
				$model = Mage::getModel('virtualaccess/purchased_credential')->load($id);

				$pruchasedItemId = $model->getPurchasedItemId();
				$model->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/show',array('id'=>$pruchasedItemId));
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}



    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
    
    public function purchasedgridAction()
    {
       die($this->getLayout()->createBlock('virtualaccess/adminhtml_credential_edit_tab_purchased_grid')->toHtml());
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('sales/credential');
    			break;
    	}
    }
}