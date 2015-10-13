<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Sid_Framecontract_Block_Adminhtml_Import_Edit
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abomigration_Block_Adminhtml_Import extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->removeButton('back')
             ->removeButton('reset')
             ->_updateButton('save', 'label', $this->__('Check Data'))
             ->_updateButton('save', 'id', 'upload_button')
             ->_updateButton('save', 'onclick', 'editForm.postToFrame();');
        
        
        $this->_addButton('run', array(
        		'label'     => Mage::helper('adminhtml')->__('Download Sample File'),
        		'onclick'   => "setLocation('". $this->getUrl('/*/demo')."')" ,
        		'class'     => 'save',
        ), 100);
        
    }

    /**
     * Internal constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_objectId   = 'import_id';
        $this->_blockGroup = 'abomigration';
        $this->_controller = 'adminhtml_import';
    }

    /**
     * Get header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('importexport')->__('Import');
    }
}
