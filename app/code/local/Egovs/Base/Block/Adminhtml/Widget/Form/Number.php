<?php
/**
 * 
 *  Number input
 *
 *  @category Egovs
 *  @package  Egovs_Base
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @copyright Copyright (c) 2018 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Adminhtml_Widget_Form_Number extends Varien_Data_Form_Element_Abstract
{

    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->setType('number');
        $this->setExtType('numberfield');
    }

    public function getHtml()
    {
        $this->addClass('input-text html5-validate');
        return parent::getHtml();
    }

    public function getHtmlAttributes()
    {
        return array('type', 'title', 'class', 'style', 'onclick', 'onchange', 'onkeyup', 'disabled', 'readonly', 'max', 'min', 'step', 'tabindex');
    }
}