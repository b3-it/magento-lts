<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Model_Queue_Ruleset
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
*  @method int getId()
*  @method setId(int $value)
*  @method string getName()
*  @method setName(string $value)
*  @method int getStatus()
*  @method setStatus(int $value)
*  @method string getCategory()
*  @method setCategory(string $value)
*  @method string getRecipients()
*  @method setRecipients(string $value)
*  @method int getOwnerId()
*  @method setOwnerId(int $value)
*  @method string getTemplate()
*  @method setTemplate(string $value)
*  @method string getTransfer()
*  @method setTransfer(string $value)
*  @method string getFormat()
*  @method setFormat(string $value)
*/
class B3it_Messagequeue_Model_Queue_Ruleset extends Mage_Core_Model_Abstract
{
	protected $_rules = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_mq/queue_ruleset');
    }
    
    public function getRules()
    {
    	if($this->_rules == null)
    	{
    		$collection = Mage::getModel('b3it_mq/queue_rule')->getCollection();
    		$collection->getSelect()->where('ruleset_id =?',intval($this->getId()));
    		$this->_rules= $collection->getItems();
    	}
    	
    	return $this->_rules;
    
    }

    public function processEvent($data,$event)
    {
        $message = Mage::getModel('b3it_mq/queue_message');
        $message->setRulesetId($this->getId());
        $message->setOwnerId($this->getOwnerId());
        $message->setRecipients($this->getRecipients());
        $message->setCategory($this->getCategory());
        $message->setCreatedAt(now());
        $message->setEvent($event);
        $message->setStatus(B3it_Messagequeue_Model_Queue_Messagestatus::STATUS_NEW);
        //$message->setStoreId($data->getStoreId());
        $message->setSubject($this->getSubject());

        $model = $this->_getProcessingModel();
        if($model)
        {
           if($model->preProcessing($this,$message,$data))
           {
           		$model->processText($this, $message, $data);
           		$message->save();
           }
        }
    }


    protected function _getProcessingModel()
    {
        return  Mage::getModel('b3it_mq/queue_category')->getModelByName($this->getCategory());
    }

}
