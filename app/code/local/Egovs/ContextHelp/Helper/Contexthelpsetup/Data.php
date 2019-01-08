<?php
/**
 *
 *  @category       Egovs
 *  @package        Egovs_ContextHelp
 *  @copyright  	Copyright (c) 2018 B3-IT Systeme GmbH - http://www.b3-it.de
 *  @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Helper_Contexthelpsetup_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Liste alles aktiven Layout-Handles
     *
     * @var Mage_Core_Model_Layout
     */
    private $_layoutHandles = null;

    /**
     * Klasse erzeugen
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_layoutHandles = Mage::helper('contexthelp')->getAllLayoutUpdates(true, $this);
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
     * einen neuen ContextHelp-Block verknüpfen
     *
     * @param  int           $parent         ID des Hilfe-Eintrages
     * @param  int           $blockId        ID des CMS-Blocks
     * @param  int           $blockPosition  Position des Blocks
     * @return bool|void
     * @access public
     */
    public function linkBlock($parent, $blockId, $blockPosition)
    {
        if ( !$parent || !$blockId ) {
            return false;
        }
        
        /* @var $model Egovs_ContextHelp_Model_Contexthelpblock */
        $model = Mage::getModel('contexthelp/contexthelpblock');
        
        $model->setParentId($parent)
              ->setBlockId($blockId)
              ->setPos($blockPosition)
              ->save();
    }

    /**
     * neue Handels zu einem Hilfe-Eintrag hinzufügen
     *
     * @param  int           $parent      ID des Hilfe-Eintrages
     * @param  string|array  $handle
     * @return bool                       Handle success
     * @access public
     */
    public function addNewHandle($parent, $handle)
    {
        // Prüfen, ob es das LayoutHandel überhaupt gibt
        if ( !$parent || !in_array($handle, $this->_layoutHandles) ) {
            return false;
        }
        
        /* @var $model Egovs_ContextHelp_Model_Contexthelphandle */
        $model = Mage::getModel('contexthelp/contexthelphandle');
        
        $model->setParentId($parent)
              ->setHandle($handle)
              ->save();
    }
}