<?php
/**
 *  Haushalt Helper
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Checks the observer's cron expression against time
	 *
	 * Supports $this->setCronExpr('* 0-5,10-59/5 2-10,15-25 january-june/2 mon-fri')
	 *
	 * @param Varien_Event $event
	 * @return boolean
	 */
	public function canSchedule($expr)
	{
		$e = preg_split('#\s+#', $expr, null, PREG_SPLIT_NO_EMPTY);
		if (sizeof($e)<5 || sizeof($e)>6) {
			throw Mage::exception('Sid ExportOrder', 'Invalid cron expression: '.$expr);
		}
	
	
		$d = getdate(Mage::getSingleton('core/date')->timestamp(time()));
	
		$match = $this->matchCronExpression($e[0], $d['minutes'])
		&& $this->matchCronExpression($e[1], $d['hours'])
		&& $this->matchCronExpression($e[2], $d['mday'])
		&& $this->matchCronExpression($e[3], $d['mon'])
		&& $this->matchCronExpression($e[4], $d['wday']);
	
	
		return $match;
	}
	
	public function matchCronExpression($expr, $num)
	{
		// handle ALL match
		if ($expr==='*') {
			return true;
		}
	
		// handle multiple options
		if (strpos($expr,',')!==false) {
			foreach (explode(',',$expr) as $e) {
				if ($this->matchCronExpression($e, $num)) {
					return true;
				}
			}
			return false;
		}
	
		// handle modulus
		if (strpos($expr,'/')!==false) {
			$e = explode('/', $expr);
			if (sizeof($e)!==2) {
				throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting 'match/modulus': ".$expr);
			}
			if (!is_numeric($e[1])) {
				throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting numeric modulus: ".$expr);
			}
			$expr = $e[0];
			$mod = $e[1];
		} else {
			$mod = 1;
		}
	
		// handle all match by modulus
		if ($expr==='*') {
			$from = 0;
			$to = 60;
		}
		// handle range
		elseif (strpos($expr,'-')!==false) {
			$e = explode('-', $expr);
			if (sizeof($e)!==2) {
				throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting 'from-to' structure: ".$expr);
			}
	
			$from = $this->getNumeric($e[0]);
			$to = $this->getNumeric($e[1]);
		}
		// handle regular token
		else {
			$from = $this->getNumeric($expr);
			$to = $from;
		}
	
		if ($from===false || $to===false) {
			throw Mage::exception('Mage_Cron', "Invalid cron expression: ".$expr);
		}
	
		return ($num>=$from) && ($num<=$to) && ($num%$mod===0);
	}
	
	public function getNumeric($value)
	{
		static $data = array(
				'jan'=>1,
				'feb'=>2,
				'mar'=>3,
				'apr'=>4,
				'may'=>5,
				'jun'=>6,
				'jul'=>7,
				'aug'=>8,
				'sep'=>9,
				'oct'=>10,
				'nov'=>11,
				'dec'=>12,
	
				'sun'=>0,
				'mon'=>1,
				'tue'=>2,
				'wed'=>3,
				'thu'=>4,
				'fri'=>5,
				'sat'=>6,
		);
	
		if (is_numeric($value)) {
			return $value;
		}
	
		if (is_string($value)) {
			$value = strtolower(substr($value,0,3));
			if (isset($data[$value])) {
				return $data[$value];
			}
		}
	
		return false;
	}
	
}