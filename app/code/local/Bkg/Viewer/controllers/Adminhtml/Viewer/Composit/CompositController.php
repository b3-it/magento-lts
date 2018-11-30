<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name        Bkg_Viewer_Adminhtml_Viewer_Composit_CompositController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Adminhtml_Viewer_Composit_CompositController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('compositcomposit/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Items Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('bkgviewer/composit_composit')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('compositcomposit_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('bkgviewer/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('bkgviewer/adminhtml_composit_composit_edit'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkgviewer')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			


			$model = Mage::getModel('bkgviewer/composit_composit');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}

				$model->save();
				
				if(isset($data['node_options'])){
					$this->saveChilds($data['node_options'], $model->getId());
				}
				if(isset($data['sectiontools']))
                {
                    $this->saveSelectiontools($data['sectiontools'], $model->getId());
                }

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bkgviewer')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkgviewer')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}


    public function saveSelectiontools($data,$compositId)
    {
        if($data)
        {
            foreach($data as $d) {
                $model = Mage::getModel('bkgviewer/composit_selectiontools');
                if($d['id'] > 0)
                {
                    $model->load($d['id']);
                }
				if($d['deleted'] == 0)
				{
	                $model->setPos($d['pos'])
	                    ->setCompositId($compositId)
	                    ->setLayerId($d['layer_id'])
	                    ->setLabel($d['label'])
	                    ->save();
				}else{
					$model->delete();
				}
            }
        }
    }


	public function saveChilds($nodes,$compositId)
	{
		foreach($nodes as $key =>$node)
		{
			$nodes[$key] = json_decode($nodes[$key],true);
		}
		$loaded = array();
		//model erzeugen oder laden
		foreach($nodes as $node)
		{
			$model = Mage::getModel('bkgviewer/composit_layer');
			if(!isset($node['id']) || empty($node['id']))
			{
				
			}else {
				$model = Mage::getModel('bkgviewer/composit_layer')->load($node['id']);
			}
				
			$model->setTitle($node['title'])
			->setPos($node['pos'])
			->setVisualPos($node['visual_pos'])
			->setType($node['type'])
			->setPermanent($node['permanent'])
			->setIsChecked($node['is_checked'])
			->setCompositId($compositId);
				
			if(!isset($node['serviceLayer']) || empty($node['serviceLayer']))
			{
				$model->unsetData('service_layer');
			}else{
	
				$model->setServiceLayerId($node['serviceLayer']);
			}
			
			$model->save();
			$node['id'] = $model->getId();
			$node['model'] = $model;
			
			$loaded[] = $node;
				
		}
	
		//jetzt die Elternbeziehung und die Reihenfolge
		foreach($loaded as $node)
		{
				
			$model = $node['model'];
			$parent = $this->findByNumber($loaded, $node['parent_number']);
				
			if($parent){
				$model->setParentId($parent['model']->getId());
			}else{
				$model->setData('parent_id',null);
			}
				
				
			$model->save();
				
		}
	
		foreach($loaded as $node)
		{
			if($node['deleted']){
				$model = $node['model'];
				$model->delete();
			}
		}
	
	
	
	}
	
	private function findByNumber($nodes,$number)
	{
		foreach ($nodes as $node){
			if($node['number'] == $number){
				return $node;
			}
		}
	
		return null;
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('bkgviewer/compositcomposit');

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
        $compositcompositIds = $this->getRequest()->getParam('compositcomposit');
        if(!is_array($bkgviewerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($bkgviewerIds as $bkgviewerId) {
                    $bkgviewer = Mage::getModel('bkgviewer/compositcomposit')->load($bkgviewerId);
                    $bkgviewer->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($bkgviewerIds)
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
        $compositcompositIds = $this->getRequest()->getParam('compositcomposit');
        if(!is_array($bkgviewerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($compositcompositIds as $compositcompositId) {
                    $compositcomposit = Mage::getSingleton('bkgviewer/compositcomposit')
                        ->load($bkgviewerId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($bkgviewerIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'compositcomposit.csv';
        $content    = $this->getLayout()->createBlock('bkgviewer/adminhtml_compositcomposit_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'compositcomposit.xml';
        $content    = $this->getLayout()->createBlock('bkgviewer/adminhtml_compositcomposit_grid')
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
