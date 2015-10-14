<?php
/**
 * Model Resource-Setup
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$emailData = array();
$emailData['template_code'] = "Merklisten (Template)";
$emailData['template_subject'] = "Merkliste";
$emailData['config_data_path'] = "sidwishlist/general/email_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<h1>Merklisten</h1> {{var message}} <a href="{{var link}}">Merkliste öffnen</a><br> {{var items}}';

$this->createEmail($emailData);


