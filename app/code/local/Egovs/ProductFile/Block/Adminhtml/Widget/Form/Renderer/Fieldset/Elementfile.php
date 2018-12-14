<?php
/**
 * Eigener Renderer für Fieldset-Elemente
 *
 * @category   Egovs
 * @package    Egovs_ProductFile
 * @author     Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license	   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ProductFile_Block_Adminhtml_Widget_Form_Renderer_Fieldset_Elementfile extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
    /**
     * Setzt eigenes Template
     * 
     * @see Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element::_construct()
     * 
     * @return void
     */
	protected function _construct()
    {
        $this->setTemplate('egovs/widget/form/renderer/fieldset/element/file.phtml');
    }
}
