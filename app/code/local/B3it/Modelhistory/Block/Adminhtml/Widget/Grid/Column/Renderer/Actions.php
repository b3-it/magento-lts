<?php
class B3it_Modelhistory_Block_Adminhtml_Widget_Grid_Column_Renderer_Actions extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action {
    
    
    protected function _toLinkHtml($action, Varien_Object $row)
    {
        if (!$this->__optionEnabled($row)) {
            return '';
        }

        return parent::_toLinkHtml($action, $row);
    }
    
    private function __optionEnabled($row) {
        // disabled for now
        return false;
        
        $modelTable = $row->getData('model');
        // without model, treat it as ConfigData
        if (!$modelTable) {
            $modelTable = 'Mage_Core_Model_Config_Data';
        }
        
        // get model id
        $model_id = $row->getData('model_id');
        
        // get model, return empty if model does not exist
        $model =  Mage::getModel($modelTable);
        if (!$model) {
            return false;
        }
        
        // check if model exist to restore
        $obj = $model->load($model_id);
        // model does not exist, does not show options
        if (empty($obj->getData())) {
            return false;
        }
        
        return true;
    }

    protected function _toOptionHtml($action, Varien_Object $row)
    {
        if (!$this->__optionEnabled($row)) {
            return '';
        }

        return parent::_toOptionHtml($action, $row);
    }
}