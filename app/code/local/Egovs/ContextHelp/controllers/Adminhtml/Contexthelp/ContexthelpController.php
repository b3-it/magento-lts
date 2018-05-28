<?php
/**
 *
 * @category   	Egovs ContextHelp
 * @package    	Egovs_ContextHelp
 * @name        Egovs_ContextHelp_Adminhtml_ContextHelp_ContexthelpController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Adminhtml_ContextHelp_ContexthelpController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('contexthelp/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Contexthelp Manager'), Mage::helper('adminhtml')->__('Contexthelp Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Contexthelp Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('contexthelp/contexthelp')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('contexthelp_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('egovs_contextHelp/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('contexthelp/adminhtml_contexthelp_edit'))
				->_addLeft($this->getLayout()->createBlock('contexthelp/adminhtml_contexthelp_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('contexthelp')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {




			$model = Mage::getModel('contexthelp/contexthelp');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

			try {

				$model->save();
				$this->_saveHandle($data, $model);
				$this->_saveBlocks($data, $model);
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('contexthelp')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('contexthelp')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	protected function _reorderData($data,$key)
	{
		if(!isset($data[$key]))
		{
			return null;
		}
		$data =$data[$key];

		$res = array();
		foreach($data['value'] as $key => $val)
		{
			$obj = new Varien_Object();
			$obj->setValue($val);

			if(isset($data['pos'][$key])){
				$obj->setPos($data['pos'][$key]);
			}
			if(isset($data['delete'][$key])){
				$obj->setDelete($data['delete'][$key]);
			}

			$res[$key] = $obj;
		}

		return $res;

	}


	protected function _saveHandle($data,$model)
	{
		$data = $this->_reorderData($data,'handle');
		if(!$data)
		{
			return $this;
		}


		$items = array();

		foreach($model->getHandles() as $item)
		{
			$items[$item->getHandle()] = $item;

		}

		foreach($data as $dat)
		{
			if(isset($items[$dat->getValue()])){
				$item = $items[$dat->getValue()];
				if($dat->getDelete()){
					$item->delete();
					continue;
				}
			}else{
				$item = Mage::getModel('contexthelp/contexthelphandle');
			}

			$item->setParentId(intval($model->getId()));
			$item->setHandle($dat->getValue());

			$item->save();
		}

	}

	protected function _saveBlocks($data,$model)
	{
		$data = $this->_reorderData($data,'block');
		if(!$data)
		{
			return $this;
		}

		$items = array();

		foreach($model->getBlocks() as $item) {
			$items[$item->getBlockId()] = $item;
		}

		foreach($data as $dat) {
			if(isset($items[$dat->getValue()])) {
				$item = $items[$dat->getValue()];
				if($dat->getDelete() {
					$item->delete();
					continue;
				}
			} else {
				$item = Mage::getModel('contexthelp/contexthelpblock');
			}

			$item->setParentId(intval($model->getId()));
			$item->setBlockId($dat->getValue());
			$item->setPos($dat->getPos());
			$item->save();
		}

	}



	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('contexthelp/contexthelp');

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
        $contexthelpIds = $this->getRequest()->getParam('contexthelp_ids');
        if(!is_array($contexthelpIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($contexthelpIds as $contexthelpId) {
					$egovs_contextHelp = Mage::getModel('contexthelp/contexthelp')->load($contexthelpId);
                    $egovs_contextHelp->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($contexthelpIds)
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
        $contexthelpIds = $this->getRequest()->getParam('contexthelp_ids');
        if(!is_array($egovs_contextHelpIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($contexthelpIds as $contexthelpId) {
                    $contexthelp = Mage::getSingleton('egovs_contextHelp/contexthelp')
                        ->load($contexthelpId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($contexthelpIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = $this->_getFileName('csv');
        $content    = $this->getLayout()->createBlock('egovs_contextHelp/adminhtml_contexthelp_grid')
                           ->getCsv();

        $this->_prepareDownloadResponse($fileName,$content);
    }

    public function exportXmlAction()
    {
        $fileName   = $this->_getFileName('xml');
        $content    = $this->getLayout()->createBlock('egovs_contextHelp/adminhtml_contexthelp_grid')
                           ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName,$content);
    }

    public function exportExcelAction()
    {
        $fileName   = $this->_getFileName('xls');
        $content    = $this->getLayout()->createBlock('egovs_contextHelp/adminhtml_contexthelp_grid')
                           ->getXml();

         $this->_prepareDownloadResponse($fileName,$content);
    }

    protected function _getFileName($ext = "csv")
    {
    	$fileName   = $this->__('contexthelp');
    	$fileName .= "_".date('Y-m-d') . ".".$ext;

    	return $fileName;
    }



}
