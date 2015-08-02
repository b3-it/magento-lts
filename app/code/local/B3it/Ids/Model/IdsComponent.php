<?php
/**
 *
 *  Ids Observer
 *  @category B3It
 *  @package  B3it_Admin_Model_Observer
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2015 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


/**
 * test mit ?test='%20OR%201=1--
 */


set_include_path(get_include_path().PS.Mage::getBaseDir('lib').DS.'IDS');

use IDS\Init;
use IDS\Monitor;

require_once(Mage::getBaseDir('lib').DS.'IDS'.DS.'Init.php');
require_once(Mage::getBaseDir('lib').DS.'IDS'.DS.'Monitor.php');
//require_once('tcpdf.php');

class B3it_Ids_Model_IdsComponent extends Varien_Object
{
	
	private $threshold = array(
			'log'      => 3,
			'mail'     => 9,
			'deny'     => 81
	);
	
	
	public function detect($data)
	{
		
		$init = Init::init(Mage::getBaseDir('lib').DS.'IDS' . '/Config/Config.ini.php');
		if($init)
		{
			$init->config['General']['base_path'] = Mage::getBaseDir('lib').DS.'IDS'.DS ;
			$init->config['General']['filter_path'] = Mage::getBaseDir('lib').DS.'ids'.DS.'default_filter.xml' ;
			$init->config['General']['tmp_path'] = Mage::getBaseDir('var').DS.'ids'.DS ;
			
			$init->config['General']['use_base_path'] = false;
			
			$init->config['Caching']['caching'] = 'none';
			/*Mage_Core_Controller_Request_Http */
			$rq = $data->getRequest();
			
			$path = explode('/', trim($data->getRequest()->getPathInfo(), '/'));
			
			$request = array(
					'REQUEST' => $_REQUEST,
					'GET' => $_GET,
					'POST' => $_POST,
					'COOKIE' => $_COOKIE,
					'PATH' => $path
			);
			
			
			$ids = new Monitor($init);			
			$result = $ids->run($request);
			
			if($result)
			{
				if (!$result->isEmpty()) {
					
					//echo $result;
					$reaction = $this->react($result);
					if(isset($reaction['log'])){
						$this->log($result,$reaction);
					}
					if(isset($reaction['mail'])){
						$this->mail($result,$reaction);
					}
					if(isset($reaction['deny'])){
						die('Deny4You');
					}
			}	
			}
		}
			
	}
	
	
	private function log($result, $reaction)
	{
		
			$ip = ($_SERVER['SERVER_ADDR'] != '127.0.0.1') ?
			$_SERVER['SERVER_ADDR'] :
			(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ?
					$_SERVER['HTTP_X_FORWARDED_FOR'] :
					'127.0.0.1');
				
			foreach ($result as $event) {
				$data = array(
						'name'      => $event->getName(),
						'value'     => mysql_escape_string(stripslashes($event->getValue())),
						'page'      => $_SERVER['REQUEST_URI'],
						//'userid'    => $user,
						'session'   => session_id() ? session_id() : '0',
						'ip'        => $ip,
						'reaction'  => implode(', ',$reaction),
						//'impact'    => $result->getImpact()
						'impact'    => $event->getImpact()
				);
				$ids = Mage::getModel('b3it_ids/idsEvent');
				$ids->setData($data);
				$ids->save();
				foreach ($event->getFilters() as $filter) {
					$idsfilter = Mage::getModel('b3it_ids/idsEventFilter');
					$idsfilter->setEventId($ids->getId());
					$idsfilter->setDescription($filter->getDescription());
					$idsfilter->setImpact($filter->getImpact());
					$idsfilter->setTags(implode(', ', $filter->getTags()));
					$idsfilter->setRuleId($filter->getId());
					$idsfilter->save();
						
				}
			}
	}
	
	
	private function react($result)
	{
		$res = array();
	
		$impact = $result->getImpact();
		
		
		if ($impact >= $this->threshold['deny']) {
			$res['log'] = 'log';
			$res['email'] = 'email';
			$res['deny'] = 'deny';
			return $res;
		} elseif ($impact >= $this->threshold['mail']) {
			$res['log'] = 'log';
			$res['email'] = 'email';
			return $res;
		} elseif ($impact >= $this->threshold['log']) {
			$res['log'] = 'log';
			return $res;
		} 
		
		return $res;
	}

}