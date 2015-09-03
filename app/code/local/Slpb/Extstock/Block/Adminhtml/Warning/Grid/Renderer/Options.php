<?php

class Slpb_Extstock_Block_Adminhtml_Warning_Grid_Renderer_Options extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Options
{
/**
     * Render a grid cell as options
     *
     * @param Varien_Object $row Zeile
     * 
     * @return string
     */
    public function render(Varien_Object $row) {
        $options = $this->getColumn()->getOptions();
        $showMissingOptionValues = (bool)$this->getColumn()->getShowMissingOptionValues();
        $isForCommit = (bool)$this->getColumn()->getIsForCommit();
        if (!empty($options) && is_array($options)) {
            $value = $row->getData($this->getColumn()->getIndex());
            $hiddenInputTemplate = '<input type="hidden" name="%s_array[]" value="%s" />';
            if (is_array($value)) {
                $res = array();                
                foreach ($value as $item) {
                    if (isset($options[$item])) {
                        $res[] = $options[$item];
                    } elseif ($showMissingOptionValues) {
                        $res[] = $item;
                    }
                }
                return implode(', ', $res);
            } elseif (isset($options[$value])) {
                $res = $options[$value];
            	if ($isForCommit) {
                	$res .= sprintf(" ".$hiddenInputTemplate, $this->getColumn()->getId(), $value);
                }
            	return $res;
            } elseif ($showMissingOptionValues) {
            	return $value;
            }
            return '';
        }
    }
}
