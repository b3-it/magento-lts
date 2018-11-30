<?php
/**
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Adminhtml_Ibewi_Kostentraeger_AttributeController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Adminhtml_Ibewi_Kostentraeger_AttributeController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('catalog/attributes')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Cost Unit'), Mage::helper('adminhtml')->__('Cost Unit'));
		$this->_title(Mage::helper('adminhtml')->__('Cost Unit'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('ibewi/kostentraeger_attribute')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('kostentraegerattribute_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('ibewi/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('ibewi/adminhtml_kostentraeger_attribute_edit'))
				->_addLeft($this->getLayout()->createBlock('ibewi/adminhtml_kostentraeger_attribute_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ibewi')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		
		if ($data = $this->getRequest()->getPost()) {
			$id = intval($this->getRequest()->getParam('id'));
			$model = Mage::getModel('ibewi/kostentraeger_attribute')->load($id);
			$model->setData($data);
			if($id > 0)
			{
				$model->setId($id);
			}
			$collection = $model->getCollection();
			
			$collection->getSelect()
			->where('id <> '.$id)
			->where("value = ?", $data['value'] );
			
			//die($collection->getSelect()->__toString());
			if(count($collection->getItems()) > 0)
			{
				Mage::getSingleton('adminhtml/session')->addError('Dieser Kostenträger existiert bereits');
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			

			try {
				
				if($data['standard'] == '1'){
					$model->removeStandard4All();
				}
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ibewi')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ibewi')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('ibewi/kostentraeger_attribute')->load($this->getRequest()->getParam('id'));

				$products = $model->isUsedByProduct();
				if(strlen($products) > 0){
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Cost Unit is used by these Products: %s.',$products));
					$this->_redirect('*/*/');
				}
				
				else{
					$model->delete();
	
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
					$this->_redirect('*/*/');
				}
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	protected function _isAllowed() {
		return Mage::getSingleton('admin/session')->isAllowed('catalog/attributes/dwdibewi_kostentraeger_attribute');
		
	}
 
}
