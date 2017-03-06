<?php
class B3it_Modelhistory_Adminhtml_Modelhistory_ModelhistoryController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction() {
        $this->loadLayout();
        return $this;
    }

    public function indexAction() {
        $this->_initAction();

        $this->renderLayout();
        return $this;
    }

    public function restoreAction() {
        return;

        $id = $this->getRequest()->getParam('id');
        $log = Mage::getModel("b3it_modelhistory/history")->load($id);
        
        if (empty($log->getData())) {
            // TODO add Error
            // log not found
            $this->_redirect('index');
            return;
        }

        $model = $log->getData('model');

        $model_id = $log->getData('model_id');

        $obj = Mage::getModel($model)->load($model_id);

        if (!empty($obj->getData())) {
            $newData = json_decode($log->getData("value"), true);

            $obj->setData($newData)->save();
        } else {
            // TODO session add Error
            // model not found
        }

        $this->_redirect('*/*/index');
    }
}