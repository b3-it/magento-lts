<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Tab_Agreement
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit_Tab_Agreement extends Mage_Adminhtml_Block_Widget_Form
{
	protected function x_construct()
	{
		parent::_construct();
		$this->setTemplate('bkg/license/master/edit/tab/agreement.phtml');
	}


    /**
     * @return Mage_Adminhtml_Block_Widget_Form|void
     */
    protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		// Tabelle mehrspaltig
		$fieldset = $form->addFieldset('agreement_form', array(
				'legend' => Mage::helper('bkg_orgunit')->__('Agreement')
		));

        $collection = Mage::getModel('bkg_license/master_agreement')->getCollection();

        $collection->addMasterIdFilter(Mage::registry('entity_data')->getId());

        $value = array();
        foreach($collection as $item)
        {
            $value[] = array('value'=>$item->getIdentifier(),'pos'=>$item->getPos());
        }

        $values = $this->getCmsBlocks();
		$fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
		$fieldset->addField('agreement', 'ol', array(
				'label'     => Mage::helper('bkg_orgunit')->__('Block'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'agreement',
				'values' =>$values,
				'value' => $value
		));
	}



	public function getCmsBlocks()
	{
		$collection = Mage::getModel('cms/block')->getCollection();
		$res = array();


		foreach($collection as $item)
		{
			$res[$item->getIdentifier()] = array('label'=>$item->getTitle(), 'value'=>$item->getIdentifier());
		}


		return $res;
	}

}
