<?php
class Egovs_ContextHelp_Block_Adminhtml_Widget_Instance_Edit_Tab_Contexthelp
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

        protected function _construct()
        {
            parent::_construct();
            $this->setActive(true);
        }

        /**
         * Prepare form before rendering HTML
         *
         * @return Egovs_ConextHelp_Block_Adminhtml_Widget_Instance_Edit_Tab_Contexthelp
         */
        protected function _prepareForm()
        {
            return parent::_prepareForm();
        }

        /**
         * Prepare label for tab
         *
         * @return string
         */
        public function getTabLabel()
        {
            return $this->__('Context Help');
        }

        /**
         * Prepare title for tab
         *
         * @return string
         */
        public function getTabTitle()
        {
            return $this->__('Context Help');
        }

        /**
         * Returns status flag about this tab can be showen or not
         *
         * @return true
         */
        public function canShowTab()
        {
            return !(bool)$this->getWidgetInstance()->isCompleteToCreate();
        }

        /**
         * Returns status flag about this tab hidden or not
         *
         * @return true
         */
        public function isHidden()
        {
            return false;
        }
}
