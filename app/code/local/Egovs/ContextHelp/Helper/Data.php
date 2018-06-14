<?php
/**
 *
 *  @category       Egovs
 *  @package        Egovs_ContextHelp
 *  @copyright  	Copyright (c) 2018 B3-IT Systeme GmbH - http://www.b3-it.de
 *  @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * layout handles wildcar patterns
     * diese Handels werden NICHT angezeigt!!
     * @var array
     */
    protected $_layoutHandlePatterns = array(
        '^default$',
    );

    /**
     * Area-Getter
     *
     * @param  array                           $data
     * @return Mage_Core_Model_Design_Package
     * @access public
     */
    public function getArea($data)
    {
        if (!$data['area']) {
            return Mage_Core_Model_Design_Package::DEFAULT_AREA;
        }
        return $data['area'];
    }

    /**
     * Package-Getter
     *
     * @return Mage_Core_Model_Design_Package
     * @access public
     */
    public function getPackage()
    {
        $var = explode('/', $this->getPackageTheme);
        if(count($var) == 2) {
            return $var[0];
        }
        return Mage_Core_Model_Design_Package::DEFAULT_PACKAGE;
    }

    /**
     * Theme-Getter
     *
     * @return Mage_Core_Model_Design_Package
     * @access public
     */
    public function getTheme()
    {
        $var = explode('/', $this->getPackageTheme);
        if(count($var) == 2) {
            return $var[1];
        }
        return Mage_Core_Model_Design_Package::DEFAULT_THEME;
    }

    /**
     * alle aktuell verfügbaren Blöcke ermitteln
     *
     * @return array[]
     * @access public
     */
    public function getAllAvailableBlocks()
    {
        $collection = Mage::getModel('cms/block')->getCollection();

        $return = array();
        foreach($collection as $item) {
            $return[$item->getIdentifier()] = array(
                                                  'label' => $item->getTitle(),
                                                  'value' => $item->getId()
                                              );
        }

        return $return;
    }

    /**
     * Liste mit allen verfügbaren LayoutUpdates erzeugen
     *
     * @param boolean            $showKeyOnly
     * @param Varien_Object      $parent
     * @return array[]
     */
    public function getAllLayoutUpdates($showKeyOnly = false, $parent)
    {
        /* @var $update Mage_Core_Model_Layout_Update */
        $update     = Mage::getModel('core/layout')->getUpdate();
        $allUpdates = $update->getFileLayoutUpdatesXml(
                                   $this->getArea($parent->_data),
                                   $this->getPackage(),
                                   $this->getTheme()
                               )
                             ->xpath('/*/*/label/..');

        $return = array();
        if ( $allUpdates ) {
            foreach ($allUpdates AS $node) {
                $layoutHandle = $node->getName();

                if ( $this->_filterLayoutHandle($layoutHandle) ) {
                    if ( $showKeyOnly ) {
                        $return[] = $layoutHandle;
                    }
                    else {
                        $helper = Mage::helper(Mage_Core_Model_Layout::findTranslationModuleName($node));
                        $return[$layoutHandle] = Mage::helper('core')->jsQuoteEscape(
                            $helper->__((string)$node->label)
                        );
                    }
                }
            }

            if ( !$showKeyOnly ) {
                asort($return, SORT_STRING);
            }
        }

        return $return;
    }


    /**
     * Check if given layout handle allowed (do not match not allowed patterns)
     *
     * @param  string|array  $layoutHandle
     * @return boolean
     */
    private function _filterLayoutHandle($layoutHandle)
    {
        $wildCard = '/('.implode(')|(', $this->_layoutHandlePatterns).')/';
        if (preg_match($wildCard, $layoutHandle)) {
            return false;
        }
        return true;
    }
}
