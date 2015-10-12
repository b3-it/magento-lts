<?php
  
$emailData = array();
$emailData['template_code'] = "Auskunftsdienst Kundeninfo (Template)";
$emailData['template_subject'] = "Ihre Anfrage {{var request_title}}";
$emailData['config_data_path'] = "informationservice/email/customer_template";
$emailData['template_type'] = "2";
$emailData['text'] = "<h1>Ihre Anfrage \"{{var request_title}}\"</h1><p> Es wurde folgender Schritt hinzugefuegt: \"{{var task_title}}\".</p> Neuer Status ist: {{var status}}";

$this->createEmail($emailData);

$emailData = array();
$emailData['template_code'] = "Auskunftsdienst Bearbeiterinfo (Template)";
$emailData['template_subject'] = "Anfrage {{var request_id}} {{var request_title}}";
$emailData['config_data_path'] = "informationservice/email/owner_template";
$emailData['template_type'] = "2";
$emailData['text'] = "<h1>Ihnen wurde folgende Anfrage zur Bearbeitung uebergeben \"{{var request_title}}\"</h1><p> Es wurde folgender Schritt hinzugefuegt: \"{{var task_title}}\".</p> Neuer Status ist: {{var status}}";

$this->createEmail($emailData);

