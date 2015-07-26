<?php
/**
 * Adminhtml Newsletter Template Edit Block
 *
 * @category   	Egovs
 * @package    	Egovs_Acl
 * @author		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2011-2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Acl_Block_Adminhtml_Newsletter_Template_Edit extends Mage_Adminhtml_Block_Newsletter_Template_Edit
{
 
    /**
     * Preparing block layout
     * 
     * Erweitert die ursprüngliche Version um zusätzliche ACLs (Speichern,Löschen)
     *
     * @return Mage_Adminhtml_Block_Newsletter_Template_Edit
     */
    protected function _prepareLayout()
    {
    	parent::_prepareLayout();
    	
    	$canSave = Mage::getSingleton('admin/session')->isAllowed('admin/newsletter/template/newslettertemplatesave');
    	$canDelete = Mage::getSingleton('admin/session')->isAllowed('admin/newsletter/template/newslettertemplatedelete');
    	
        if (!$canSave) {
        	$this->unsetChild('save_button');
	        $this->unsetChild('save_as_button');
        }

        if (!$canDelete) {
	        $this->unsetChild('delete_button');
        }

        return $this;
    } 
}
