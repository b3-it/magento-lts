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

class Bkg_Viewer_Block_Adminhtml_Service_Service_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/import', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
				'enctype' => 'multipart/form-data'
		)
				);


		$form->setUseContainer(true);
		$this->setForm($form);

		$fieldset = $form->addFieldset('navi_form', array('legend'=>Mage::helper('bkgviewer')->__('Information')));
		$fieldset->addField('url', 'text', array(
				'label'     => Mage::helper('bkgviewer')->__('Url'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'url',
				'value'	=> 'http://sg.geodatenzentrum.de/wfs_kachel',
				'note'	=> 'getCapabilities'
		));

		$fieldset->addField('type', 'radios', array(
				'label'     => Mage::helper('bkgviewer')->__('type'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'type',
				'values' => array(
					array('label'=>'Web Map Service','value'=>'Wms'),
					array('label' => 'Web Map Tile Service', 'value'=>'Wmts'),
					array('label'=>'Web Feature Service','value'=>'Wfs')
				)
				//'value'	=> 'http://localhost.local/bestand_niedersachsen_wms.xml',
				//'note'	=> 'getCapabilities'
		));

		$options = Mage::helper('bkgviewer')->getAvailableVersions();
		$fieldset->addField('version', 'select', array(
				'label'     => Mage::helper('bkgviewer')->__('Version'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'version',
				'options' => $options
				
		));


		return parent::_prepareForm();
	}
}