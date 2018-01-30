<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_Adminhtml__Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_Adminhtml__Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bkg_orgUnit')->__(' Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('bkg_orgUnit')->__(' Information'),
          'title'     => Mage::helper('bkg_orgUnit')->__(' Information'),
          'content'   => $this->getLayout()->createBlock('bkg_orgUnit/adminhtml__edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
