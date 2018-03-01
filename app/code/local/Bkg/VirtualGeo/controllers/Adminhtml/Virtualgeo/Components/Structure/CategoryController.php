<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name        Bkg_VirtualGeo_Adminhtml_Virtualgeo_Components_StructureentityController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
http://localhost.local/magen  /virtualgeo_components_structure_category/refeshComponentStructure/key/d3b91ed5ecadd4f1e2a8351233bb404b//id/4
class Bkg_VirtualGeo_Adminhtml_Virtualgeo_Components_Structure_CategoryController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('catalog/componentsstructure')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('ComponentsStructure_entity Manager'), Mage::helper('adminhtml')->__('Components Structure Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Components Structure Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$store_id     =  intval($this->getRequest()->getParam('store'));
		$model  = Mage::getModel('virtualgeo/components_structure_category')
			->setStoreId($store_id)
			->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('components_structure_category_entity_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('virtualgeo/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			
			$this->_addContent($this->getLayout()->createBlock('virtualgeo/adminhtml_components_structure_category_edit'));
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


			$model = Mage::getModel('virtualgeo/components_structure_category');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

			try {


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
				$model = Mage::getModel('virtualgeo/components_structure_category');

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

 

    
    
    
    public function refeshComponentStructureAction()
    {
    	$id     =  intval($this->getRequest()->getParam('id'));
    	$collection = Mage::getModel('virtualgeo/components_structure')->getCollection();
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
