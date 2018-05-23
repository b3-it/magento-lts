<?php
/**
 *
 * @see Mage_Widget_Adminhtml_Widget_InstanceController
 */

$pathData = array(
    Mage::getModuleDir('controllers','Mage_Adminhtml'),
    'Widget',
    'InstanceController.php'
);
//require_once( implode(DS, $pathData) );
require_once( Mage::getModuleDir('controllers','Mage_Adminhtml') . DS . 'Widget' . DS . 'InstanceController.php' );
Zend_Debug::dump('Loading');

//class Egovs_ContextHelp_Adminhtml_Widget_InstanceController extends Mage_Widget_Adminhtml_Widget_InstanceController
class Egovs_ContextHelp_Adminhtml_InstanceController extends Mage_Widget_Adminhtml_Widget_InstanceController
{
    /**
     * Widget zum bearbeiten laden
     *
     */
    public function editAction()
    {
        Zend_Debug::dump('<h1>OK</h1>');
        $this->_getSession()->addError('OK');
    }

    /**
     * Widget Speichern
     *
     */
    public function saveAction()
    {
        $_postData = $this->getRequest()->getPost();

        Zend_Debug::dump('Save');
        $this->_getSession()->addError('Save');
    }

    /**
     * Widget löschen
     *
     */
    public function deleteAction()
    {
    }
}
