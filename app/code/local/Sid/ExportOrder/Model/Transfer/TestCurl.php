<?php
// $sURL = Internetseite, die aufgerufen werden soll
// $sMessage = Array mit POST-Variablen (optional)
function CurlPost($sURL)
{
    $ch = curl_init();
    $curl_opt = array();
    $curl_opt[CURLOPT_SSL_VERIFYPEER] = 0;
    $curl_opt[CURLOPT_SSL_VERIFYHOST] = 0;
    $curl_opt[CURLOPT_URL] = $sURL;
    $curl_opt[CURLOPT_POST] = 1;
    $curl_opt[CURLOPT_HEADER] = 0;
    $curl_opt[CURLOPT_RETURNTRANSFER] = 1;
   
    
    foreach($curl_opt as $opt=>$value)
    {
    	curl_setopt($ch, $opt, $value);
    	echo 'Curl SetOpt: '.$opt."=". $value ."\n";
    }

    $sResult = curl_exec($ch);
    if (curl_errno($ch)) 
    {
        // Fehlerausgabe
        print curl_error($ch);
    } else 
    {
        // Kein Fehler, Ergebnis zurückliefern:
        curl_close($ch);
        return $sResult;
    }    
}

// Beispielaufruf:
print CurlPost("https://cb-ppu.essendi.de/CertificateBroker");


?>