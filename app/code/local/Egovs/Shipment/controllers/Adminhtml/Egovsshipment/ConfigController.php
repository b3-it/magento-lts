<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Mage_Adminhtml_System_ConfigController
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Shipment_Adminhtml_Egovsshipment_ConfigController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Whether current section is allowed
     *
     * @var bool
     */
    protected $_isSectionAllowedFlag = true;



    /**
     * Index action
     *
     */
    public function indexAction()
    {
        $this->_forward('edit');
    }

 

    /**
     * Save configuration
     *
     */
    public function saveAction()
    {
        $session = Mage::getSingleton('adminhtml/session');
        /* @var $session Mage_Adminhtml_Model_Session */

        $groups = $this->getRequest()->getPost('groups');

        if (isset($_FILES['groups']['name']) && is_array($_FILES['groups']['name'])) {
            /**
             * Carefully merge $_FILES and $_POST information
             * None of '+=' or 'array_merge_recursive' can do this correct
             */
            foreach($_FILES['groups']['name'] as $groupName => $group) {
                if (is_array($group)) {
                    foreach ($group['fields'] as $fieldName => $field) {
                        if (!empty($field['value'])) {
                            $groups[$groupName]['fields'][$fieldName] = array('value' => $field['value']);
                        }
                    }
                }
            }
        }

        try {
            if (!$this->_isSectionAllowed($this->getRequest()->getParam('section'))) {
                throw new Exception(Mage::helper('adminhtml')->__('This section is not allowed.'));
            }

            // custom save logic
            $this->_saveSection();
            $section = $this->getRequest()->getParam('section');
            $website = $this->getRequest()->getParam('website');
            $store   = $this->getRequest()->getParam('store');
            Mage::getSingleton('adminhtml/config_data')
                ->setSection($section)
                ->setWebsite($website)
                ->setStore($store)
                ->setGroups($groups)
                ->save();

            // reinit configuration
            Mage::getConfig()->reinit();
            Mage::dispatchEvent('admin_system_config_section_save_after', array(
                'website' => $website,
                'store'   => $store,
                'section' => $section
            ));
            Mage::app()->reinitStores();

            // website and store codes can be used in event implementation, so set them as well
            Mage::dispatchEvent("admin_system_config_changed_section_{$section}",
                array('website' => $website, 'store' => $store)
            );
            $session->addSuccess(Mage::helper('adminhtml')->__('The configuration has been saved.'));
        }
        catch (Mage_Core_Exception $e) {
            foreach(explode("\n", $e->getMessage()) as $message) {
                $session->addError($message);
            }
        }
        catch (Exception $e) {
            $session->addException($e,
                Mage::helper('adminhtml')->__('An error occurred while saving this configuration:') . ' '
                . $e->getMessage());
        }

        $this->_saveState($this->getRequest()->getPost('config_state'));

        $this->_redirect('*/*/edit', array('_current' => array('section', 'website', 'store')));
    }

 

    /**
     * Export shipping table rates in csv format
     *
     */
    public function exportBulkgoodsAction()
    {
        $fileName   = Mage::helper('egovsshipment')->__('Bulkgoods').'.csv';
        /** @var $gridBlock Mage_Adminhtml_Block_Shipping_Carrier_Tablerate_Grid */
        $gridBlock  = $this->getLayout()->createBlock('egovsshipment/adminhtml_carrier_bulkgoods_grid');
        $website    = Mage::app()->getWebsite($this->getRequest()->getParam('website'));
       
        $gridBlock->setWebsiteId($website->getId());
        $content    = $gridBlock->getCsvFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check is allow modify system configuration
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config');
    }

    /**
     * Check if specified section allowed in ACL
     *
     * Will forward to deniedAction(), if not allowed.
     *
     * @param string $section
     * @return bool
     */
    protected function _isSectionAllowed($section)
    {
        try {
            $session = Mage::getSingleton('admin/session');
            $resourceLookup = "admin/system/config/{$section}";
            if ($session->getData('acl') instanceof Mage_Admin_Model_Acl) {
                $resourceId = $session->getData('acl')->get($resourceLookup)->getResourceId();
                if (!$session->isAllowed($resourceId)) {
                    throw new Exception('');
                }
                return true;
            }
        }
        catch (Zend_Acl_Exception $e) {
            $this->norouteAction();
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        catch (Exception $e) {
            $this->deniedAction();
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
    }

    /**
     * Save state of configuration field sets
     *
     * @param array $configState
     * @return bool
     */
    protected function _saveState($configState = array())
    {
        $adminUser = Mage::getSingleton('admin/session')->getUser();
        if (is_array($configState)) {
            $extra = $adminUser->getExtra();
            if (!is_array($extra)) {
                $extra = array();
            }
            if (!isset($extra['configState'])) {
                $extra['configState'] = array();
            }
            foreach ($configState as $fieldset => $state) {
                $extra['configState'][$fieldset] = $state;
            }
            $adminUser->saveExtra($extra);
        }

        return true;
    }
}
