<?php

/**
 * 
 *  Master Block für Pdf TTemplate-Blöcke
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Block_Adminhtml_Blocks extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_blocks';
    $this->_blockGroup = 'pdftemplate';
    $this->_headerText = Mage::helper('pdftemplate')->__('Pdf Block Manager');
    $this->_addButtonLabel = Mage::helper('pdftemplate')->__('Add Block');
    parent::__construct();
  }
}