<?php
/**
 * 
 *  Admin User Tab Left
 *  @category Egovs
 *  @package  Egovs_Isolation
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Block_Adminhtml_Permissions_User_Edit_Tabs extends Mage_Adminhtml_Block_Permissions_User_Edit_Tabs
{
    protected function _beforeToHtml()
    {
        $user = Mage::registry('permissions_user');

        if(!Mage::helper('isolation')->isAdmin($user)) {
            $this->addTabAfter('user_section', array(
                'label'     => Mage::helper('adminhtml')->__('Stores'),
                'title'     => Mage::helper('adminhtml')->__('Stores'),
                'content'   => $this->getLayout()->createBlock('isolation/adminhtml_permissions_user_edit_tabs_store')->toHtml(),
            ),'roles_section');
        }

        return parent::_beforeToHtml();
    }
}
