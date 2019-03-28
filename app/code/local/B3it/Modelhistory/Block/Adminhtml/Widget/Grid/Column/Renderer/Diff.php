<?php
class  B3it_Modelhistory_Block_Adminhtml_Widget_Grid_Column_Renderer_Diff extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $newValue = $this->_getValue($row);

        $oldValue = $row->getData('old_value');

        $shortDiff = $this->getColumn()->getShortDiff();

        if (isset($oldValue) && isset($newValue) && $shortDiff) {
            $newValue = json_decode($newValue, true);
            $oldValue = json_decode($oldValue, true);

            $oldValueResult = array_filter($oldValue, function ($value, $key) use ($newValue) {
                if (isset($newValue[$key]) && $newValue[$key] === $value) {
                    return false;
                } else {
                    return true;
                }
            }, ARRAY_FILTER_USE_BOTH);

            $newValueResult = array_filter($newValue, function ($value, $key) use ($oldValue) {
                if (isset($oldValue[$key]) && $oldValue[$key] === $value) {
                    return false;
                } else {
                    return true;
                }
            }, ARRAY_FILTER_USE_BOTH);

            // empty array are rendered as [] instead as {} as i want
            if (empty($oldValueResult)) {
                $oldValueResult = (object) null;
            }
            if (empty($newValueResult)) {
                $newValueResult = (object) null;
            }

            $oldValue = json_encode($oldValueResult, JSON_UNESCAPED_UNICODE);
            $newValue = json_encode($newValueResult, JSON_UNESCAPED_UNICODE);
        }

        $opCodes = FineDiff::getDiffOpcodes($oldValue, $newValue);

        return FineDiff::renderDiffToHTMLFromOpcodes($oldValue, $opCodes);
    }
}