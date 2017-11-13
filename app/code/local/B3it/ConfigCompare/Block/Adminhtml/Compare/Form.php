<?php
/**
 * B3it ConfigCompare
 * 
 * 
 * @category   	B3it
 * @package    	B3it_ConfigCompare
 * @name       	B3it_ConfigCompare_Block_Adminhtml__Edit_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class B3it_ConfigCompare_Block_Adminhtml_Compare_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     *
     * {@inheritDoc}
     * @see Mage_Adminhtml_Block_Widget_Form::_beforeToHtml()
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}