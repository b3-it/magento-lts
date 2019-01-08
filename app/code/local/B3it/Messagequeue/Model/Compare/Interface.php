<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Messagequeue
 * @name       	B3it_Messagequeue_Model_Compare_Interface
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
interface  B3it_Messagequeue_Model_Compare_Interface 
{
 	public function getOptionArray();
 	
 	public function getFormInputHtml();
 	
 	public function getLabel4Value($value);
}
