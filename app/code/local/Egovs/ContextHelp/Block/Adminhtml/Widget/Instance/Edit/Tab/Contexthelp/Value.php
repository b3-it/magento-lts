<?php
/**
 *
 *
 * @category    Egovs
 * @package     Egovs_ConextHelp
 */
class Egovs_ContextHelp_Block_Adminhtml_Widget_Instance_Edit_Tab_Contexthelp_Value
    extends Mage_Adminhtml_Block_Template implements Varien_Data_Form_Element_Renderer_Interface
{
    /**
     * @var Varien_Data_Form_Element_Abstract
     */
    protected $_element = null;

    /**
     * Internal constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('egovs/contexthelp/edit/value.phtml');
    }

    /**
     * Render given element (return html of element)
     *
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }

    /**
     * Setter
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return
     */
    public function setElement(Varien_Data_Form_Element_Abstract $element)
    {
        $this->_element = $element;
        return $this;
    }

    /**
     * Getter
     *
     * @return Varien_Data_Form_Element_Abstract
     */
    public function getElement()
    {
        return $this->_element;
    }

    /**
     * HTML-Button zum hinzufügen eines neuen Eintrages
     *
     * @return string
     */
    public function getAddUrlButtonHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
                       ->setData(array(
                           'label'     => $this->__('Add URL'),
                           'onclick'   => 'ContextHelp.addUrlGroup({})',
                           'class'     => 'add'
                       ));
        return $button->toHtml();
    }

    /**
     * HTML-Button zum entfernen eines vorhandenen Eintrages
     *
     * @return string
     */
    public function getRemoveUrlButtonHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
                       ->setData(array(
                           'label'     => $this->__('Remove URL'),
                           'onclick'   => 'ContextHelp.removeUrlGroup(this)',
                           'class'     => 'delete'
                       ));
        return $button->toHtml();
    }

    /**
     * Prepare and retrieve page groups data of widget instance
     *
     * @return array
     */
    public function getUrlGroups()
    {
        $widgetInstance = $this->getWidgetInstance();
        $urlGroups = array();

        return $urlGroups;
    }
}
