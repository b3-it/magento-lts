<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Controller_Adminhtml_Abstract
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Controller_Adminhtml_Abstract extends Mage_Adminhtml_Controller_action
{


    protected function _sendUploadResponse($fileName, $content, $type)
    {
    	$this->saveAccess($type);
    	$contentType='application/octet-stream';
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
    
    
    
    private function saveAccess($type)
    {
    	
      $from = $this->getRequest()->getParam('from');
  	  $to =  $this->getRequest()->getParam('to');
  	  $to =  $this->getDateTime($to,(24 *60*60) -1);
  	  $from =  $this->getDateTime($from);
    
  	  $owner = Mage::getSingleton('admin/session')->getUser();
  	  
    	$access = Mage::getModel('ibewi/access');
    	$access->setUser($owner->getName())
    		->setRequestBegin($from)
    		->setRequestEnd($to)
    		->setType($type)
    		->setCreatedTime(now())
    		->save();
    }
    
 	private function getDateTime($date,$add=0)
  	{
  		$format = 'Y-m-d H:i:s';
        $timestamp = Mage::getModel('core/date')->gmtTimestamp($date);
  		
        $timestamp += $add ;
        
  		return date($format, $timestamp);		
  	}
  	
  	protected function verifyDate()
  	{
  		return $this;
  	  	$from = $this->getRequest()->getParam('from');
  	  	$to =  $this->getRequest()->getParam('to');
  	  
  	  	if($from || $to)
  	  	{

  	  	  if(!strtotime($from))
  	  	  {
  	  	  	//Mage::throwException(Mage::helper('ibewi')->__("From Date is wrong!"));
  	  	  	$this->getLayout()->getMessagesBlock()->addError(Mage::helper('ibewi')->__("From Date is wrong!"));
  	  	  	return $this;
  	  	  }	
  	  	  
  	  	  if(!strtotime($to))
  	  	  {
  	  	  	//Mage::throwException(Mage::helper('ibewi')->__("From Date is wrong!"));
  	  	  	$this->getLayout()->getMessagesBlock()->addError(Mage::helper('ibewi')->__("To Date is wrong!"));
  	  	  	return $this;
  	  	  }	
  	  		
	  	  if(Mage::getModel('core/date')->gmtTimestamp($from) > Mage::getModel('core/date')->gmtTimestamp($to))
	  	  {
	  	  		$this->getLayout()->getMessagesBlock()->addNotice(Mage::helper('ibewi')->__("To Date is less then from Date!"));
	  	  }
  		 
	  	  if(Mage::getModel('core/date')->gmtTimestamp(time()) < Mage::getModel('core/date')->gmtTimestamp($to)+24*60*60)
	  	  {
	  	  		//$this->getLayout()->getMessagesBlock()->addNotice(Mage::helper('ibewi')->__("Report is not in past!"));
	  	  		Mage::throwException(Mage::helper('ibewi')->__("Report is not in past!"));
	  	  }
  	  	}
	  	  return $this;
  	}
  	
  	protected function toDateToString()
  	{
  		$to =  $this->getRequest()->getParam('to');
  		if($to)
  		{
  			return date('dmy',Mage::getModel('core/date')->gmtTimestamp($to) + (24 *60*60) -1);
  		}
  		
  		return date('dmy');
  	
  	}
    
}