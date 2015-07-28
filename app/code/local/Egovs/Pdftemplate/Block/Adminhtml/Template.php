<?php
/**
 * 
 *  Master Block für Pdf Templates
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Block_Adminhtml_Template extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_template';
    $this->_blockGroup = 'pdftemplate';
    $this->_headerText = Mage::helper('pdftemplate')->__('PDF Templates');
    $this->_addButtonLabel = Mage::helper('pdftemplate')->__('Add Template');
    parent::__construct();
  }
}