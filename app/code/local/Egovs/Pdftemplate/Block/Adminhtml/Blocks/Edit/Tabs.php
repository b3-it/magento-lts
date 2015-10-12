<?php

/**
 * 
 *  Edit Block für pdf Template-Blöcke
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Block_Adminhtml_Blocks_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('blocks_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('pdftemplate')->__('Blocks'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('pdftemplate')->__('Blocks Information'),
          'title'     => Mage::helper('pdftemplate')->__('Blocks Information'),
          'content'   => $this->getLayout()->createBlock('pdftemplate/adminhtml_blocks_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}