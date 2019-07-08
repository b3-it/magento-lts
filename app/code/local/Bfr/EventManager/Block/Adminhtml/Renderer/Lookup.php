<?php
class Bfr_EventManager_Block_Adminhtml_Renderer_Lookup extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    
    public function render(Varien_Object $row)
    {
        $value = ($this->_getValue($row));

        if (!$value) {
            return "";
        }
        $ids =  explode(',', $value);

        /**
         * @var $column Mage_Adminhtml_Block_Widget_Grid_Column
         */
        $column = $this->getColumn();
        // get Options set in the Grid, it should be id => label
        $options = $column->getData('options');
        $str = '<ul>';
        foreach ($ids as $value) {
            if (isset($options[$value])) {
                $str.='<li>'.$options[$value].'</li>';            
            }
        }
        $str.= '</ul>';

        return $str;
    }
    
}