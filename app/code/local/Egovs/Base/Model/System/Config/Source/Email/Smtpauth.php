<?php

class Egovs_Base_Model_System_Config_Source_Email_Smtpauth
{
    public function toOptionArray()
    {
        return array(
        	//value muss Klasse in: 'Zend_Mail_Protocol_Smtp_Auth_' entsprechen
            array('value'=>'NONE', 'label'=>'NONE'),
//             array('value'=>'Plain', 'label'=>'PLAIN'),
            array('value'=>'Login', 'label'=>'LOGIN'),
//             array('value'=>'Crammd5', 'label'=>'CRAM-MD5'),
        );
    }
}