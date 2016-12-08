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
           	$storage->setUpdateTime(now());
           	$storage->setCreatedTime(now());
           	$storage->setModel($task->model);
           	$storage->setTitle($task->title);
           	$storage->setTaskId($task->taskid);
            $storage->save();
        }
    }

	protected function _getTaskList()
	{
        $url = Mage::getStoreConfig('pendelliste/pendelliste_portal/url');
        $webshop_id = Mage::getStoreConfig('pendelliste/pendelliste_portal/webshop_id');
        if (isset($url) && !empty($url)) {
            $url =   rtrim($url,'/');
            $url .= "/task/magento/{$webshop_id}/";
            $client = new Varien_Http_Client($url);
            $client->setMethod(Varien_Http_Client::GET);

            try{
                $response = $client->request();
                if ($response->isSuccessful()) {
                    $res = $response->getBody();
                    $res = json_decode($res);
                    $tasks = $res->tasks;

                    return $tasks;
                }
            } catch (Exception $e) {
                // TODO add more Exception!!!
            }
        } else {
        	// TODO add Exception!!!
        }

        return array();
    }
}