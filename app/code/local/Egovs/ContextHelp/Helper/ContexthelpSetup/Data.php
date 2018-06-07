<?php
/**
 *  Installer für ContextHelper
 * 
 *  @category       Egovs
 *  @package        Egovs_ContextHelp
 *  @author 		René Mütterlein <r.muetterlein@b3-it.de>
 *  @copyright  	Copyright (c) 2017 B3-IT Systeme GmbH - http://www.b3-it.de
 *  @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Helper_ContexthelpSetup_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Datei-Maske zum anlegen neuer Verzeichnis-Strukturen im Media-Verzeichnis
     *
     * @var string
     */
    private $_defaultDirectoryMask = '0750';
    
    /**
     * Liste alles aktiven Layout-Handles
     * 
     * @var Mage_Core_Model_Layout
     */
    private $_layoutHandles = null;
    
    /**
     * Liste aller CMS-Blöcke
     * 
     * @var Mage_Cms_Block_Block
     */
    private $_availableBlocks = null;

    /**
     * Klasse erzeugen
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        /* @var $_baseHelper Egovs_ContextHelp_Helper_Data */
        $_baseHelper = Mage::helper('contexthelp');
        
        $this->_layoutHandles   = $_baseHelper->getAllLayoutUpdates(true, $this);
        $this->_availableBlocks = $_baseHelper->getAllAvailableBlocks();
    }
    
    /**
     * neuen Hilfe-Eintrag hinzufügen
     * 
     * @param  Varien_Object  $data
     * @return null|int       ID des neuen Items
     * @access public
     */
    public function addNewContextHelp($data)
    {
        if ( !$data ) {
            return null;
        }
        
        $newItem = Mage::getModel('contexthelp/contexthelp')
                   ->setData($data)
                   ->save();
        return $newItem->getId();
    }

    /**
     * neue Handels zu einem Hilfe-Eintrag hinzufügen
     * 
     * @param  int           $itemId    ID des Hilfe-Eintrages
     * @param  string|array  $handle
     * @return bool                     Handle success
     * @access public
     */
    public function addNewHandles($itemId, $handle)
    {
        $newHandle = Mage::getModel('contexthelp/contexthelphandle');
        
        if ( !$itemId || !in_array($handle, $this->_layoutHandles) ) {
            return false;
        }
        
        if ( is_array($handle) ) {
            foreach( $handle AS $item ) {
                if ( is_string($item) ) {
                    $this->_saveNewHandle($newHandle, $item, $itemId);
                }
            }
        }
        elseif ( is_string($handle) ) {
            $this->_saveNewHandle($newHandle, $handle, $itemId);
        }
        
        return true;
    }
    
    public function addNewBlocks($itemId, $blockName)
    {
        $newBlock = Mage::getModel('contexthelp/contexthelpblock');
        
        if ( !$itemId || !in_array($blockName, $this->_availableBlocks) ) {
            return false;
        }
        
        return true;
    }



    /**
     * neues Handle anlegen
     * 
     * @param Egovs_ContextHelp_Model_Contexthelphandle $model
     * @param string                                    $handle
     * @param int                                       $parent
     */
    private function _saveNewHandle($model, $handle, $parent)
    {
        if ( !$parent || !is_int($parent) || !strlen($handle) || !($model instanceof Egovs_ContextHelp_Model_Contexthelphandle) ) {
            return;
        }
        
        $model->setParentId($parent)
              ->setHandle($handle)
              ->save();
    }
}