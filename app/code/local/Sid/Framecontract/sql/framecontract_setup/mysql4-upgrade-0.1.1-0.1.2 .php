<?php
   
$emailData = array();
$emailData['template_code'] = "Rahmenverträge (Template)";
$emailData['template_subject'] = "Rahmenvertrag";
$emailData['config_data_path'] = "framecontract/email/vendor_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<h1>Rahmenvertrag</h1> {{var contractnumber}} / {{var title}} ';

$this->createEmail($emailData);

