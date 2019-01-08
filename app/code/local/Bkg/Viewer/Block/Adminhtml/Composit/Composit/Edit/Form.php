<?php
/**
 * Sid Cms
 *
 *
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Block_Adminhtml_Navi_Edit_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_Viewer_Block_Adminhtml_Composit_Composit_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

	public function xx__construct()
	{
		parent::__construct();
		$this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
	}
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $this->setTemplate('bkg/viewer/composit/edit/form.phtml');
      $form->setUseContainer(true);
      $this->setForm($form);


      $this->setChild('navigation_tree',  $this->getLayout()->createBlock('bkgviewer/adminhtml_composit_composit_edit_tree'));
      $this->setChild('content_tools',
          $this->getLayout()->createBlock('bkgviewer/adminhtml_composit_composit_edit_selectiontools')
      );
      $this->setChild('composit_form',
          $this->getLayout()->createBlock('bkgviewer/adminhtml_composit_composit_edit_tab_form')
      );

      return parent::_prepareForm();
  }







}
