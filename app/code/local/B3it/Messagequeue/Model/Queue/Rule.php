<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Model_Queue_Rule
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getRulesetId()
 *  @method setRulesetId(int $value)
 *  @method string getJoin()
 *  @method setJoin(string $value)
 *  @method string getOperator()
 *  @method setOperator(string $value)
 *  @method string getCompare()
 *  @method setCompare(string $value)
 *  @method string getCompareValue()
 *  @method setCompareValue(string $value)
 *  @method string getSource()
 *  @method setSource(string $value)
 *  @method int getIsNot()
 *  @method setIsNot(int $value)
 */

class B3it_Messagequeue_Model_Queue_Rule extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_mq/queue_rule');
    }
}
