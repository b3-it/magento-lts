<?php
class B3it_Modelhistory_Block_Adminhtml_Widget_Grid_Column_Renderer_Datetime extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Datetime {

    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        if ($data = $this->_getValue($row)) {
            $format = $this->_getFormat();
            $useTimeZone = $this->getColumn()->getUseTimeZone();
            if ($useTimeZone === null) {
                $useTimeZone = true;
            }

            try {
                $data = Mage::app()->getLocale()
                ->date($data, Varien_Date::DATETIME_INTERNAL_FORMAT, null, $useTimeZone)->toString($format);
            }
            catch (Exception $e)
            {
                $data = Mage::app()->getLocale()
                ->date($data, Varien_Date::DATETIME_INTERNAL_FORMAT, null, $useTimeZone)->toString($format);
            }
            return $data;
        }
        return $this->getColumn()->getDefault();
    }
}