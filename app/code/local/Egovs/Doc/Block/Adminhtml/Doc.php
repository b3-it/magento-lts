<?php
/**
 * Verwalten von Dokumenten im Webshop.
 *
 * @category	Egovs
 * @package		Egovs_Doc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Doc_Block_Adminhtml_Doc extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {

    $this->_controller = 'adminhtml_doc';
    $this->_blockGroup = 'egovs_doc';
    $this->_headerText = Mage::helper('egovs_doc')->__('Document Manager');
    $this->_addButtonLabel = Mage::helper('egovs_doc')->__('Add Document');
    parent::__construct();
  }
}