<?php
/**
 * Installer für CMS-Seiten und CMS-Blöcke
 * 
 * @category   	Egovs
 * @package    	Egovs_Base
 * @author 		René Mütterlein <r.muetterlein@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3-IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Helper_Cmssetup_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Funktion zum Ersetzen von Strings in den CMS-Blöcken und -Seiten durch die jeweiligen Config-Variablen
     * 
     * @param string                      $path                  Pfad 'cms/block' oder 'cms/page'
                                                                 Mage_Cms_Model_Resource_Block_Collection|Mage_Cms_Model_Resource_Page_Collection
     * @param array                       $replace_url           $key => $value für URL-Ersetzung
     * @param array                       $replace_string        $key => $value für String-Ersetzung
     * @param bool                        $remove_comments       Auskommentierten HTML-Code löschen
     */
    public function changeCmsData($path = null, $replace_url = null, $replace_string = null, $remove_comments = TRUE)
    {
        if ( is_null($path) OR !strlen($path) ) {
            return;
        }
        
        /* @var $data_arr Mage_Cms_Model_Resource_Block_Collection|Mage_Cms_Model_Resource_Page_Collection */
        $data_arr = Mage::getModel($path)->getCollection();
        foreach($data_arr AS $element) {
            if ($path == 'cms/block') {
                $id = $element->getBlockId();
            }
            else {
                $id = $element->getPageId();
            }
            
            $new = $old = $element->getContent();
            
            // URL's ersetzen
            if ( is_array($replace_url) AND count($replace_url) ) {
                $new = str_replace(array_keys($replace_url), array_values($replace_url), $new);
            }
            
            // Strings ersetzen
            if ( is_array($replace_string) AND count($replace_string) ) {
                $new = str_replace(array_keys($replace_string), array_values($replace_string), $new);
            }
            
            // Auskommentierten HTML-Code löschen
            if ( $remove_comments == TRUE ) {
                $new = preg_replace('/<!--(.*)-->/Uis', '', $new);
            }
            
            if ( $old != $new ) {
                $store_ids = $element->getResource()->lookupStoreIds($id);

                $model = Mage::getModel($path)->load($id);
                $model->setContent($new)->setStores($store_ids)->save();
            }
        }
    }
}