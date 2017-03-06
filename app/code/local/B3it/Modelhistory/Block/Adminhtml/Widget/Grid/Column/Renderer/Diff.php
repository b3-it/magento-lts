<?php
class  B3it_Modelhistory_Block_Adminhtml_Widget_Grid_Column_Renderer_Diff extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $value = $this->_getValue($row);

        $oldValue = $row->getData('old_value');

        $opCodes = FineDiff::getDiffOpcodes($oldValue, $value);

        return FineDiff::renderDiffToHTMLFromOpcodes($oldValue, $opCodes);
    }
}