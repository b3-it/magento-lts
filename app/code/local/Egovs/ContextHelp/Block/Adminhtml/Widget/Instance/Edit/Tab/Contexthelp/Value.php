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
     * AjaxURL für den Block-Wähler
     *
     * @return string
     */
    public function getSourceUrl()
    {
        return Mage::helper('adminhtml')->getUrl('contexthelp/ajax');
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
                           'label'   => $this->__('Add URL'),
                           'onclick' => 'ContextHelp.addUrlGroup({})',
                           'type'    => 'button',
                           'class'   => 'add'
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
                           'label'   => $this->__('Remove URL'),
                           'onclick' => 'ContextHelp.removeUrlGroup(this)',
                           'type'    => 'button',
                           'class'   => 'delete'
                       ));
        return $button->toHtml();
    }

    /**
     * HTML-Button zum auswählen eines statischen Blocks
     *
     * @return string
     */
    public function getBlockChooserButton()
    {
        $element = $this->getElement();

        $chooseButton = $this->getLayout()->createBlock('adminhtml/widget_button')
                             ->setData(array(
                                 'label'   => $this->__('Choose Block'),
                                 'type'    => 'button',
                                 'id'      => 'chooser{{id}}',
                                 'class'   => 'btn-chooser',
                                 'onclick' => 'initBlockChooser({{id}})',
                                 'disabled'=> $element->getReadonly()
                             ));
        return $chooseButton->toHtml();
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

    /**
     * Convert Array config to Object
     *
     * @return Varien_Object
     */
    public function getConfig()
    {
        $config = new Varien_Object();

        // chooser control buttons
        $buttons = array(
            'open'  => Mage::helper('widget')->__('Choose...'),
            'close' => Mage::helper('widget')->__('Close')
        );
        if (isset($configArray['button']) && is_array($configArray['button'])) {
            foreach ($configArray['button'] as $id => $label) {
                $buttons[$id] = $this->__($label);
            }
        }
        $config->setButtons($buttons);

        return $config;
    }

    /**
     * Config-Array in JSON umwandeln
     *
     * @return string
     */
    public function getConfigJson()
    {
        $config = $this->getConfig();
        return Mage::helper('core')->jsonEncode($config->getData());
    }

}
