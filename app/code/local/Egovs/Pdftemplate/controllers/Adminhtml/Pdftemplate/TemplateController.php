<?php

/**
 *
 *  Controller für pdf Templates
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Adminhtml_Pdftemplate_TemplateController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('template/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}



	private function applyFormData($data,&$formdata)
	{
		$key = Egovs_Pdftemplate_Model_Sectiontype::getHtmlPrefix($data['sectiontype']);
		//if(key_exists($key, $data))
		{
			foreach ($data as $itemkey => $item)
			{
				$formdata[$key.'_'.$itemkey] = $item;
			}
		}
		/*
		else
		{
			$formdata[$key.'_top'] = 0;
			$formdata[$key.'_left'] = 0;
			$formdata[$key.'_width'] = 0;
			$formdata[$key.'_height'] = 0;
		}
		*/
		return $formdata;
	}
	
	
	public function previewAction() 
	{
		/*zum RechnungsEmail testen
		$invoice = Mage::getModel('sales/order_invoice')->load(1);
		$model = Mage::getModel('mpcheckout/observer');
		$model->sendInvoiceEmail($invoice);
		return;
		*/
		$id     = $this->getRequest()->getParam('id');
		$store  = $this->getRequest()->getParam('store');
		$pdf = Mage::getModel('pdftemplate/pdf_preview');
		$pdf->load($id,$store);
	}
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('pdftemplate/template')->load($id);
		$formdata = $model->getData();

		if ($model->getId())
		{
			$collection = Mage::getModel('pdftemplate/section')->getCollection();
			$collection->getSelect()
				->where('pdftemplate_template_id=?',intval($id))
				->order('position');
			
			foreach($collection->getItems() as $item)
			{
				$this->applyFormData($item->getData(),$formdata);
			}

		}
		
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			//if (!empty($data)) 
			{
				$model->setData($formdata);
			}

			Mage::register('template_data', $model);

			$this->loadLayout();
			/*
			$this->_setActiveMenu('pdftemplate/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			*/
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('pdftemplate/adminhtml_template_edit'))
				->_addLeft($this->getLayout()->createBlock('pdftemplate/adminhtml_template_edit_tabs'));
			
			
			
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pdftemplate')->__('Template does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	
	private function escapeHTML($data)
	{
		$sections = array('header','marginal','address','body','footer');
		foreach($sections as $section)
		{
			if(isset($data[$section]))
			{
				if(isset($data[$section]['content']))
				{
					$data[$section]['content'] = html_entity_decode($data[$section]['content'], ENT_QUOTES, 'UTF-8');
				}
			}
		}
		return $data;
	}
	
	
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			//$data = $this->escapeHTML($data);
			try {
				
				$template = Mage::getModel('pdftemplate/template');		
				$template->setData($data['general'])->setId($this->getRequest()->getParam('id'));
				$template->save();
				
				$model = Mage::getModel('pdftemplate/section');		
				$model->setData($data['header']);
				if(!$model->getData('pdftemplate_section_id')) $model->unsetData('pdftemplate_section_id');
				$model->setPdftemplateTemplateId($template->getId());
				$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_HEADER);
				$model->save();
				
				$model = Mage::getModel('pdftemplate/section');		
				$model->setData($data['address']);
				if(!$model->getData('pdftemplate_section_id')) $model->unsetData('pdftemplate_section_id');
				$model->setPdftemplateTemplateId($template->getId());
				$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_ADDRESS);
				$model->save();

				$model = Mage::getModel('pdftemplate/section');		
				$model->setData($data['body']);
				if(!$model->getData('pdftemplate_section_id')) $model->unsetData('pdftemplate_section_id');
				$model->setPdftemplateTemplateId($template->getId());
				$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY);
				$model->save();
				
				$model = Mage::getModel('pdftemplate/section');		
				$model->setData($data['footer']);
				if(!$model->getData('pdftemplate_section_id')) $model->unsetData('pdftemplate_section_id');
				$model->setPdftemplateTemplateId($template->getId());
				$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_FOOTER);
				$model->save();
				
				$model = Mage::getModel('pdftemplate/section');		
				$model->setData($data['marginal']);
				if(!$model->getData('pdftemplate_section_id')) $model->unsetData('pdftemplate_section_id');
				$model->setPdftemplateTemplateId($template->getId());
				$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_MARGINAL);
				$model->save();
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('pdftemplate')->__('Template was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $template->getId()));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pdftemplate')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('pdftemplate/template');
				 
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
        $templateIds = $this->getRequest()->getParam('template_id');
        if(!is_array($templateIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($templateIds as $pdftemplateId) {
                    $pdftemplate = Mage::getModel('pdftemplate/template')->load($pdftemplateId);
                    $pdftemplate->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($templateIds)
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
        $templateIds = $this->getRequest()->getParam('template_id');
        if(!is_array($templateIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($templateIds as $templateId) {
                    $template = Mage::getSingleton('pdftemplate/template')
                        ->load($templateId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($templateIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    
	public function dublicateAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('pdftemplate/template')->load($id);
		
		if ($model->getId())
		{
			
			try {
				
				$newid = $model->Dupicate();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('pdftemplate')->__('Template was duplicated! Copy was opened.'));

				$this->_redirect('*/*/edit', array('id' => $newid));
					return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pdftemplate')->__('Unable to find item to dublicate'));
        $this->_redirect('*/*/');
	}
    
    
    public function exportCsvAction()
    {
        $fileName   = 'template.csv';
        $content    = $this->getLayout()->createBlock('pdftemplate/adminhtml_template_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'template.xml';
        $content    = $this->getLayout()->createBlock('pdftemplate/adminhtml_template_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('system/pdftemplates/pdftemplate');
    			break;
    	}
    }
}