<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name        Bkg_Orgunit_Adminhtml_Orgunit_UnitController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Adminhtml_Orgunit_UnitController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('customer/bkgorgunit_unit')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Organisation'), Mage::helper('adminhtml')->__('Organisation'));
		$this->_title(Mage::helper('adminhtml')->__('Organisation'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('bkg_orgunit/unit')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			$is_used= $model->isOrganisationUsed();
			if($is_used !== false)
			{
				$used = implode(',',array_keys($is_used));
				
				Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__("Organisation is used by '%s'",$used));
			}
			
			Mage::register('unit_data', $model);

			$this->_initAction();
			

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('bkg_orgunit/adminhtml_unit_edit'))
				->_addLeft($this->getLayout()->createBlock('bkg_orgunit/adminhtml_unit_edit_tabs'));

				
					
				
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_orgunit')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

		    /**
		     * @var Bkg_Orgunit_Model_Unit $model
		     */
			$model = Mage::getModel('bkg_orgunit/unit');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

			// need to set parent to null, can't select it from this select type
			if ($model->getParentId() === '') {
			    $model->setParentId(null);
			}
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}

				$model->save();
				
				try {
				    
				    /**
				     * @var Bkg_Orgunit_Model_Resource_Unit_Address_Collection $col
				     */
				    $col = Mage::getModel("bkg_orgunit/unit_address")->getCollection();
				    
				    $keys = array_keys($data['address']);
				    
				    foreach($col->getItemsByColumnValue('unit_id', intval($model->getId())) as $val) {
				        /**
				         * @var Bkg_Orgunit_Model_Unit_Address $val
				         */
				        if (!in_array($val->getId(), $keys)) {
				            $val->delete();
				            // Address Deleted, remove UserAddresses thanks to FK Cascade
				        }
				    }
				    
				
				    $customers =  Mage::helper('bkg_orgunit')->getUserByOrganisation($model->getId());
				    foreach($data['address'] as $key => $value) {
				        // ignore template
				        if ("_template_" === $key) {
				            continue;
				        }
				        
				        /**
				         * @var Bkg_Orgunit_Model_Resource_Unit_Address $address
				         */
				        $address = Mage::getModel("bkg_orgunit/unit_address");
				        // address seems to exist, try to load old data
				        if (intval($key)) {
				            $address->load($key);
				        }
				        //var_dump(array_filter($value));
				        //var_dump($address);
				        $address->setData($value);
				        //var_dump($address);
				        //die();
				        $address->setUnitId(intval($model->getId()));
				        if (intval($key)) {
				            $address->setId($key);
				        }
				        $address->save();
				        
				        // Address got updated
				        
				        //need to filter data for the attributes, to exclude static, and possible other stuff
				        $newData = array();
				        foreach ($address->getAttributes() as $code => $attr) {
				            /**
				             * @var Mage_Eav_Model_Entity_Attribute $attr
				             */
				            if ($attr->getBackendType() != 'static') {
				                $newData[$code]=$address->getData($code);
				            }
				        }
				        // set company from organisation
				        $newData['company'] = $model->getData('company');
				        
				        foreach ($customers as $customer) {
				            /**
				             * @var Mage_Customer_Model_Customer $customer
				             */
				            /**
				             * @var Mage_Customer_Model_Resource_Address_Collection $collection
				             */
				            $collection = Mage::getModel('customer/address')->getCollection();
				            $collection->addAttributeToFilter('parent_id', array('eq' => $customer->getId()));
				            $collection->addAttributeToFilter('org_address_id', array('eq' => $address->getId()));
				            
				            $customer_address = $collection->fetchItem();
				            if ($customer_address === false) {
				                $customer_address = Mage::getModel('customer/address');
				                $customer_address->setData($newData);
				                $customer_address->setData('parent_id', $customer->getId());
				                $customer_address->setData('org_address_id', $address->getId());
				            } else {
				                // update existing data, key by key
				                foreach ($newData as $k => $v) {
				                    $customer_address->setData($k, $v);
				                }
				            }
				            $customer_address->save();
				        }
				    }
				} catch (Exception $e) {
				    var_dump($e->getMessage());
				    Mage::logException($e);
				    die();
				}
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bkg_orgunit')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_orgunit')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('bkg_orgunit/unit');

				if($model->isOrganisationUsed()!== false)
				{
					Mage::throwException($this->__("Orgunit can not deletetd!"));
				}
				
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
        $unitIds = $this->getRequest()->getParam('unit_ids');
        if(!is_array($unitIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($unitIds as $unitId) {
                    $bkg_orgunit = Mage::getModel('bkg_orgunit/unit')->load($unitId);
                    $bkg_orgunit->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($unitIds)
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
        $unitIds = $this->getRequest()->getParam('unit_ids');
        if(!is_array($unitIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($unitIds as $unitId) {
                    Mage::getSingleton('bkg_orgunit/unit')
                        ->load($unitId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($unitIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'unit.csv';
        $content    = $this->getLayout()->createBlock('bkg_orgunit/adminhtml_unit_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'unit.xml';
        $content    = $this->getLayout()->createBlock('bkg_orgunit/adminhtml_unit_grid')
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
