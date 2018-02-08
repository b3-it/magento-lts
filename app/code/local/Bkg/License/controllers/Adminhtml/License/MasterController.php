<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name        Bkg_License_Adminhtml_License_Master_EntityController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Adminhtml_License_MasterController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('entity/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Entity Manager'), Mage::helper('adminhtml')->__('Entity Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Entity Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('bkg_license/master')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('entity_data', $model);

			$this->_initAction();

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('bkg_license/adminhtml_master_edit'))
				->_addLeft($this->getLayout()->createBlock('bkg_license/adminhtml_master_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_license')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('bkg_license/master');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

			$this->_saveCustomerGroup($data,$model);
			$this->_saveFees($data,$model);
			$this->_saveProducts($data,$model);
			$this->_saveAgreements($data,$model);

			try {

				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bkg_license')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_license')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	protected function _saveCustomerGroup($data,$model)
    {
        $groups = $data['customer_groups'];
        $collection = Mage::getModel('bkg_license/master_customergroups')->getCollection();
        $collection->addMasterIdFilter(intval($model->getId()));

        $items = array();
        foreach($collection as $item)
        {
            if(in_array($item->getCustomergroupId(),$groups)) {
                $items[$item->getCustomergroupId()] = $item;
            }else{
                $item->delete();
            }
        }

        foreach($groups as $group)
        {
            if(isset($items[$group])){
                $item = $items[$group];
            }else{
                $item = Mage::getModel('bkg_license/master_customergroups');
            }

            $item->setMasterId(intval($model->getId()));
            $item->setCustomergroupId($group);
            $item->save();
        }

    }

    protected function _saveProducts($data,$model)
    {
        $groups = $data['products'];
        $collection = Mage::getModel('bkg_license/master_products')->getCollection();
        $collection->addMasterIdFilter(intval($model->getId()));

        $items = array();
        foreach($collection as $item)
        {
            if(in_array($item->getProductId(),$groups)) {
                $items[$item->getProductId()] = $item;
            }else{
                $item->delete();
            }
        }

        foreach($groups as $group)
        {
            if(isset($items[$group])){
                $item = $items[$group];
            }else{
                $item = Mage::getModel('bkg_license/master_products');
            }

            $item->setMasterId(intval($model->getId()));
            $item->setProductId($group);
            $item->save();
        }

    }

    protected function _saveAgreements($data,$model)
    {
        $groups = array();
        $tmp = $data['agreement'];

        foreach($tmp['value'] as $k=>$v)
        {
            $groups[] = array('value'=>$v,'pos'=>$tmp['pos'][$k],'delete'=>$tmp['delete'][$k]);
        }

        $collection = Mage::getModel('bkg_license/master_agreement')->getCollection();
        $collection->addMasterIdFilter(intval($model->getId()));

        $items = array();
        foreach($collection as $item)
        {
            $items[$item->getIdentifier()] = $item;
        }

        foreach($groups as $group)
        {
            if((count($items) > 0) && (isset($items[$group['value']]))){
                $item = $items[$group['value']];
            }else{
                $item = Mage::getModel('bkg_license/master_agreement');
            }

            $item->setMasterId(intval($model->getId()));
            $item->setIdentifier($group['value']);
            $item->setPos($group['pos']);


            if($group['delete'])
            {
                $item->delete();
            }else{
                $item->save();
            }
        }

    }

    protected function _saveFees($data,$model)
    {
        $fees = $data['fees'];
        $collection = Mage::getModel('bkg_license/master_toll')->getCollection();
        $collection->getSelect()->where('master_id ='. intval($model->getId()));

        $items = array();
        foreach($collection as $item)
        {
            $items[$item->getFeeCode()] = $item;
        }

        foreach($fees as $key =>$fee)
        {
            if(isset($items[$key])){
                $item = $items[$key];
            }else{
                $item = Mage::getModel('bkg_license/master_toll');
            }

            $fee['id'] = $item->getId();
            $item->setData($fee);
            $item->setMasterId(intval($model->getId()));
            $item->setFeeCode($key);
            $item->save();
        }


    }

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('bkg_license/entity');

				$model->setId($this->getRequest()->getParam('id'))
					->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $entityIds = $this->getRequest()->getParam('entity_ids');
        if(!is_array($entityIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($entityIds as $entityId) {
                    $bkg_license = Mage::getModel('bkg_license/entity')->load($entityId);
                    $bkg_license->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($entityIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction()
    {
        $entityIds = $this->getRequest()->getParam('entity_ids');
        if(!is_array($bkg_licenseIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($entityIds as $entityId) {
                    $entity = Mage::getSingleton('bkg_license/entity')
                        ->load($entityId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($entityIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'entity.csv';
        $content    = $this->getLayout()->createBlock('bkg_license/adminhtml_entity_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'entity.xml';
        $content    = $this->getLayout()->createBlock('bkg_license/adminhtml_entity_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
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
}
