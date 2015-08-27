<?php
class Dimdi_Report_Block_Adminhtml_Widget_Grid_Column_Renderer_Plaintext extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{


    /**
     * Renders grid column
     *
     * @param Varien_Object $row
     * @return mixed
     */
    public function _getValue(Varien_Object $row)
    {
        $format = ( $this->getColumn()->getFormat() ) ? $this->getColumn()->getFormat() : null;
        $defaultValue = $this->getColumn()->getDefault();
        $data = parent::_getValue($row);
        $string = is_null($data) ? $defaultValue : $data;
        return html_entity_decode($string,ENT_QUOTES,'UTF-8');
        //return $string;
       
    }
}
