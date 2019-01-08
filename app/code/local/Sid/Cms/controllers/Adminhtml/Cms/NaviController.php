<?php
/**
 * Sid Cms
 *
 *
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Adminhtml_NaviController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Adminhtml_Cms_NaviController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('cms/navigation')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Cms'), Mage::helper('adminhtml')->__('Navigation'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('sidcms/navi')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('navi_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('cms/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Cms'), Mage::helper('adminhtml')->__('Navigation'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('sidcms/adminhtml_navi_edit'));
			//	->_addLeft($this->getLayout()->createBlock('sidcms/adminhtml_navi_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sidcms')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->loadLayout();
		$this->_setActiveMenu('cms/navigation');

		//$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		//$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

		$this->_addContent($this->getLayout()->createBlock('sidcms/adminhtml_navi_new'));
				

		$this->renderLayout();
	}
	
	
	public function step1Action() {
		if ($data = $this->getRequest()->getPost()) {
	
			$collection = Mage::getModel('sidcms/navi')->getCollection();
			$collection->getSelect()->where('store_id = '. intval($data['store_id']));
			if(count($collection)>0)
			{
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sidcms')->__('The store has a navigation already'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/new');
				return;
			}
			$model = Mage::getModel('sidcms/navi');
			$model->setData($data);
	
			
			try {
				
				$model->setCreatedTime(now())
					->setUpdateTime(now());	
				$model->save();
				
				$this->_redirect('*/*/edit',array('id'=>$model->getId()));
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sidcms')->__('Can not save'));
		$this->_redirect('*/*/');
	}
	
	

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('sidcms/navi');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

			if(isset($data['node_options'])){
				$this->saveChilds($data['node_options'], $this->getRequest()->getParam('id'));
			}
			

			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}

				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('sidcms')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sidcms')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	/**
	 * Den Baum speichern 
	 */
	public function saveChilds($nodes,$naviId)
	{
		$loaded = array();
		//model erzeugen oder laden
		foreach($nodes as $node)
		{
			$model = Mage::getModel('sidcms/node');
			if(!isset($node['id']) || empty($node['id']))
			{
				$model->save();
				$node['id'] = $model->getId();
				$node['model'] = $model;
			}else {
				$model = Mage::getModel('sidcms/node')->load($node['id']);
				$node['model'] = $model;
			}
			
			$model->setLabel($node['label'])
				->setPos($node['pos'])
				->setType($node['type'])
				->setNaviId($naviId);
			
			if(!isset($node['page_id']) || empty($node['page_id']))
			{
				$model->unsetData('page_id');
			}else{
				
				$model->setPageId($node['page_id']);
			}
			$loaded[] = $node;
			
		}
		
		//jetzt die Elternbeziehung und die Reihenfolge
		foreach($loaded as $node)
		{
			
			$model = $node['model'];
			$parent = $this->findByNumber($loaded, $node['parent']);
			
			if($parent){
				$model->setParentId($parent['model']->getId());
			}else{
				$model->setData('parent_id',null);
			}
			
			
			$model->save();
			
		}
		
		foreach($loaded as $node)
		{
			if($node['is_delete']){
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
				$model = Mage::getModel('sidcms/navi');

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

	
	public function rootAction()
	{
		$data = array();
		$data[] = array("id" => "demo_root_1", "text" => "Root", "children" => true, "type" => "root", "open" => true);
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data));
		//$this->getResponse()->setBody('[{ "id" : "demo_root_1", "text" : "Root 1", "children" : true, "type" : "root" }]');
	}
	
	public function nodesAction()
	{
		$this->getResponse()->setBody('');
		//$this->getResponse()->setBody('["Child 11", { "id" : "demo_child_1", "text" : "Child 2", "children" : [ { "id" : "demo_child_2", "text": "One more", "type" : "file" }] }]');
	}

	public function tabInformationAction()
	{
		$block = $this->getLayout()->createBlock('sidcms/adminhtml_page_edit_tabs_information_form');
		//$this->getLayout()->addBlock($block, 'sidcms.information');
		//$this->renderLayout();
		$this->getResponse()->setBody($block->toHtml());
		return $this;
	}
	
	protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/cms/cms_navi');
    }
}
