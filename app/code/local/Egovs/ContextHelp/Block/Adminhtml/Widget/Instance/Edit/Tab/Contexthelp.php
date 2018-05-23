<?php
class Egovs_ContextHelp_Block_Adminhtml_Widget_Instance_Edit_Tab_Contexthelp
    extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
        public function _construct()
        {
            parent::_construct();

            // nicht auf Aktiv setzen
            $this->setActive(false);
        }

        /**
         * Prepare form before rendering HTML
         *
         * @return Egovs_ContextHelp_Block_Adminhtml_Widget_Instance_Edit_Tab_Contexthelp
         */
        protected function _prepareForm()
        {
            $widgetInstance = $this->getWidgetInstance();
            $form = new Varien_Data_Form(array(
                        'id' => 'edit_form',
                        'action' => $this->getData('action'),
                        'method' => 'post'
                    ));

            /* @var $layoutBlock Egovs_ContextHelp_Block_Adminhtml_Widget_Instance_Edit_Tab_Contexthelp_Value */
            $layoutBlock = $this->getLayout()
                                ->createBlock('contexthelp/adminhtml_widget_instance_edit_tab_contexthelp_value')
                                ->setWidgetInstance($widgetInstance);

            $fieldset = $form->addFieldset('context_help_fieldset',
                            array('legend' => $this->__('URL Set'))
                        );
            $fieldset->addField('context_help', 'note', array(
                       ));

            $form->getElement('context_help_fieldset')->setRenderer($layoutBlock);
            $this->setForm($form);

            return parent::_prepareForm();
        }

        /**
         * Label für die Registerkarte vorbereiten
         *
         * @return string
         */
        public function getTabLabel()
        {
            return $this->__('Context Help');
        }

        /**
         * Titel für die Registerkarte vorbereiten
         *
         * @return string
         */
        public function getTabTitle()
        {
            return $this->__('Context Help');
        }

        /**
         * Status-Flag über diese Registerkarte ob diese angezeigt werden kann oder nicht
         *
         * @return true
         */
        public function canShowTab()
        {
            return (bool)($this->getWidgetInstance()->getType() && $this->getWidgetInstance()->getPackageTheme());
        }

        /**
         * Status-Flag über diese Registerkarte ob diese versteckt ist oder nicht
         *
         * @return true
         */
        public function isHidden()
        {
            return false;
        }

        /**
         * Ermittelt die aktuelle Widget-Instanz
         *
         * @return Mage_Widget_Model_Resource_Widget_Instance
         */
        public function getWidgetInstance()
        {
            return Mage::registry('current_widget_instance');
        }
}
