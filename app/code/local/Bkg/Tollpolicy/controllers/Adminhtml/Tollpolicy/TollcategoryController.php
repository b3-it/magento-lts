<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name        Bkg_Tollpolicy_Adminhtml_Tollpolicy_TollcategoryController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Adminhtml_Tollpolicy_TollcategoryController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('bkgtollpolicy/bkgtollpolicy_toll_category')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Toll Category Manager'), Mage::helper('adminhtml')->__('Toll Category Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Toll Category Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('bkg_tollpolicy/tollcategory')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('toll_category_data', $model);

			$this->_initAction();

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_tollcategory_edit'))
				->_addLeft($this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_tollcategory_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_tollpolicy')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('bkg_tollpolicy/tollcategory');
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
				
				$groups = array();
				if(isset($data['customer_group_id']))
				{
					$groups = $data['customer_group_id'];
				}
						
					$collection = Mage::getModel('bkg_tollpolicy/tollcategory_customergroup')->getCollection();
					$collection->getSelect()->where('toll_category_id=?',intval($model->getId()));
						
					$found = array();
					foreach($collection as $cg)
					{
						if(!in_array($cg->getCustomerGroupId(), $groups))
						{
							$cg->delete();
						}
						else{
							$found[] = $cg->getCustomerGroupId();
						}
					}
					
					$new = array_diff($groups, $found);
					
					foreach($new as $item)
					{
						$relation = Mage::getModel('bkg_tollpolicy/tollcategory_customergroup');
						$relation->setCustomerGroupId($item);
						$relation->setTollCategoryId($model->getId());
						$relation->save();
						
					
				
					
				}
				
				
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bkg_tollpolicy')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_tollpolicy')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('bkg_tollpolicy/tollcategory');

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
        $toll_categoryIds = $this->getRequest()->getParam('toll_category_ids');
        if(!is_array($toll_categoryIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($toll_categoryIds as $toll_categoryId) {
                    $bkg_tollpolicy = Mage::getModel('bkg_tollpolicy/tollcategory')->load($toll_categoryId);
                    $bkg_tollpolicy->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($toll_categoryIds)
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
        $toll_categoryIds = $this->getRequest()->getParam('toll_category_ids');
        if(!is_array($bkg_tollpolicyIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($toll_categoryIds as $toll_categoryId) {
                    $toll_category = Mage::getSingleton('bkg_tollpolicy/tollcategory')
                        ->load($toll_categoryId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($toll_categoryIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'toll_category.csv';
        $content    = $this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_tollcategory_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'toll_category.xml';
        $content    = $this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_tollcategory_grid')
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
