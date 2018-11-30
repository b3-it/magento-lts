<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name        Bkg_VirtualGeo_Adminhtml_Virtualgeo_Components_ContententityController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
http://localhost.local/magen  /virtualgeo_components_content_category/refeshComponentContent/key/d3b91ed5ecadd4f1e2a8351233bb404b//id/4
class Bkg_VirtualGeo_Adminhtml_Virtualgeo_Components_Content_CategoryController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('componentscontent_entity/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('ComponentsContent_entity Manager'), Mage::helper('adminhtml')->__('Components Content Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Components Content Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$store_id     =  intval($this->getRequest()->getParam('store'));
		$model  = Mage::getModel('virtualgeo/components_content_category')
			->setStoreId($store_id)
			->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('components_content_category_entity_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('virtualgeo/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			
			$this->_addContent($this->getLayout()->createBlock('virtualgeo/adminhtml_components_content_category_edit'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtualgeo')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {


			$model = Mage::getModel('virtualgeo/components_content_category');
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
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtualgeo')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtualgeo')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('virtualgeo/components_content_category');

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

 

    
    
    
    public function refeshComponentContentAction()
    {
    	$id     =  intval($this->getRequest()->getParam('id'));
    	$collection = Mage::getModel('virtualgeo/components_content')->getCollection();
    	if($id)
    	{
    		$collection->getSelect()->where('main_table.category_id = ?',$id);
    	}
    	$collection->getSelect()->order('pos');
    	$res = array();
    	foreach($collection->getItems() as $item)
    	{
    		$name = trim($item->getName()." ". $item->getDescription());
    		$res[] = "<option value='{$item->getId()}' >{$name} </option>";
    	}
    	
    	$this->getResponse()->setBody(implode(" ",$res));
    }
}
