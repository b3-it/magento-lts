<?php /** @noinspection ForgottenDebugOutputInspection */

class B3it_Modelhistory_Adminhtml_Modelhistory_SettingsController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction() {
        $this->loadLayout();
        return $this;
    }
    
    public function indexAction() {
        $this->_initAction();
        
        
        //$this->output();
        
        $this->renderLayout();
        return $this;
    }
    
    public function newAction() {
        $this->_initAction();
        
        $this->renderLayout();
        return $this;
    }
    
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $modelName = $data["model"];
            
            $model = Mage::getModel("b3it_modelhistory/settings");
            $model->setData('model', $modelName);
            $model->setData('blocked', true);
            $model->save();

            // TODO fixed redirect
            $this->_redirect('*/*/index');

            return $this;
        }
        $this->_redirect('*/*/index');
        return $this;
    }
    
    public function output() {
        
        $data = array();
        $resources = array();
        foreach (Mage::getConfig()->getNode('models', 'global')->children() as $key=>$value) {
            
            $classes = $value->xpath('class');
            if (empty($classes)) {
                continue;
            }
            /**
             * @var Mage_Core_Model_Config_Element $class
             **/
            $class = $classes[0];
            $className = $class->asArray();
            
            $rModels = $value->xpath('resourceModel');
            if (empty($rModels)) {
                $entities = $value->xpath('entities');
                
                if (empty($entities)) {
                    //var_dump($value);
                    continue;
                }
                
                /**
                 * @var Mage_Core_Model_Config_Element $e
                 */
                $e = $entities[0];
                //if ($e === null) {
                //    var_dump($value);
                //}
                
                $resources[$key] = array_keys($e->asArray());
                
            } else {
                $data[$className] = $rModels[0]->asArray();
            }
        }
        
        $combined = [[]];
        foreach ($data as $k => $v) {
            $r = $resources[$v];
            if ($r === null) {
                // can't get class names without resources
                continue;
            }
            
            $combined[] = array_map(function($n) use ($k) {
                $x = $k."_".ucwords($n, '_');
                try {
                    if (!class_exists($x)) {
                        return null;
                    }
                    return $x;
                    /**
                    $reflectionClass = new ReflectionClass($x);
                    if ($reflectionClass->isInstantiable()) {
                        return $x;
                    }
                    return null;
                    //**/
                } catch (Exception $e) {
                    return null;
                }
            }, $r);
            
            //var_dump($resources[$v]);
            
            //$names = array_map('ucwords', $val, array_fill(0, count($val), "_"));
            
            //$combined[$k] = $names;
        }
        if (version_compare(PHP_VERSION, '5.6', '>=')) {
            $combined = array_merge(...$combined);
        } else {
            /* PHP below 5.6 */
            $combined = call_user_func_array('array_merge', $combined);
        }
        $combined = array_filter($combined);
        
        var_dump($combined);
        exit;
    }
    
    public function _isAllowed()
    {
        /**
         * @var Mage_Admin_Model_Session $session
         */
        $session = Mage::getSingleton('admin/session');
        if (!$session || !$session->isLoggedIn()) {
            return false;
        }
        /**
         * @var Mage_Admin_Model_User $user
         */
        $user = $session->getUser();
        if (!$user) {
            return false;
        }
        // hardcoded check only for "root" user
        return $user->getUsername() === "root";
    }
    
}