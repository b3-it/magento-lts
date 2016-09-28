<?php
/**
 * Sid ExportOrder
 * 
 * 
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_IndexController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$ident = trim($this->getRequest()->getParam('ident',null));
    	if(!empty($ident) && $this->_is_hex($ident))
    	{
    		$link = Mage::getModel('exportorder/link')->load($ident,'ident');
    		if($link->getId()){
    			$file =  $link->getDirectory().$link->getFilename();
    			if(file_exists($file)){
    				try{
	    				$content = file_get_contents($file);
	    				$link->setDownload($link->getDownload() + 1)
	    				->setDownloadTime(now())
	    				->save();
    				}
    				catch(Exception $ex){
    					Mage::logException($ex);
    				}
    				$this->_sendUploadResponse($link->getSendFilename(), $content);
    				
    				
    			}
    		}
    	}
    	
    	die('<h1>File not found!</h1>');
    }
    
    protected function _is_hex($hex_code) 
    {
        return @preg_match("/^[a-f0-9]{2,}$/i", $hex_code) && (strlen($hex_code) > 8);
	} 
    
    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
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
}