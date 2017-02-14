<?php
class B3it_Pendelliste_Model_RestImport
{
    public function importTaskList()
    {
        $tasks = $this->_getTaskList();
        /* @var $storage B3it_Pendelliste_Model_Pendelliste */
        $storage = Mage::getModel('pendelliste/pendelliste');
        $storage->getResource()->clear();
        foreach($tasks as $task)
        {
        	$storage->unsetData('id');
           	$storage->setUpdateTime(now());
           	$storage->setCreatedTime(now());
           	//$storage->setModel($task->taskTemplate->model);
           	$storage->setTitle($task->taskTemplate->title);
           	$storage->setContent($task->showData);
           	$storage->setTaskId($task->id);
           	//$storage->setTaskId($task->id);
            $storage->save();
        }
    }

	protected function _getTaskList()
	{
		
		$result = array();
        $url = Mage::getStoreConfig('pendelliste/pendelliste_portal/url');
        $webshop_id = Mage::getStoreConfig('pendelliste/pendelliste_portal/webshop_id');
        if (isset($url) && !empty($url)) {
            $url =   rtrim($url,'/');
            $url .= "/magento/{$webshop_id}";
            $client = new Varien_Http_Client($url);
            $client->setMethod(Varien_Http_Client::GET);

            try{
                $response = $client->request();
                if ($response->isSuccessful()) {
                    $res = $response->getBody();
                    $res = json_decode($res);
                    foreach($res as $item){
                    	$result[] = $item;
                    }
                    //$tasks = $res->tasks;

                    return $result;
                }
            } catch (Exception $e) {
                // TODO add more Exception!!!
            }
        } else {
        	// TODO add Exception!!!
        }

        return array();
    }
    
    
    public function getTask($id)
    {
    	$result = array();
    	$url = Mage::getStoreConfig('pendelliste/pendelliste_portal/url');
    	$webshop_id = Mage::getStoreConfig('pendelliste/pendelliste_portal/webshop_id');
    	if (isset($url) && !empty($url)) {
    		$url =   rtrim($url,'/');
    		$url .= "/magento/attr/{$id}";
    		$client = new Varien_Http_Client($url);
    		$client->setMethod(Varien_Http_Client::GET);
    
    		try{
    			$response = $client->request();
    			if ($response->isSuccessful()) {
    				$res = $response->getBody();
    				$res = json_decode($res);
    				
    				foreach($res->taskTemplate->modelParams as $param)
    				{
    					$result[] = B3it_Pendelliste_Model_Import_Abstract::create($param->model, $param->params, $res, $param);
    				}
    				
    				
    			}
    		} catch (Exception $e) {
    			// TODO add more Exception!!!
    		}
    	} else {
    		// TODO add Exception!!!
    	}
    
    	return $result;
    }
}