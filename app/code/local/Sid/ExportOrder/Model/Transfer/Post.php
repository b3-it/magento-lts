<?php
/**
 * Sid ExportOrder_Transfer
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Transfer
 * @name       	Sid_ExportOrder_Transfer_Model_Post
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Transfer_Post extends Sid_ExportOrder_Model_Transfer
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/transfer_post');
    }
    
    public function send($content,$order = null)
    {
    	$postfields = array();
    	$postfields['data'] = ($content);
    	    	
    	$ch = curl_init();
    	
    	// Follow any Location headers
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	
    	curl_setopt($ch, CURLOPT_URL, $this->getAddress());
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	
    	// Alert cURL to the fact that we're doing a POST, and pass the associative array for POSTing.
    	curl_setopt($ch, CURLOPT_POST, 1);
    	
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    	
    	$output = curl_exec($ch);
    	curl_close($ch);
    }
}
