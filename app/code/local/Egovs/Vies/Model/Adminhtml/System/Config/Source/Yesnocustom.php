<?php
/**
 * Source Model für Ja/Nein/Irrelevant
 *
 * @category	Egovs
 * @package		Egovs_Vies
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2011 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Vies_Model_Adminhtml_System_Config_Source_Yesnocustom
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Yes')),
            array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('No')),
            array('value' => 2, 'label'=>Mage::helper('egovsvies')->__('No matter'))
        );
    }

}
