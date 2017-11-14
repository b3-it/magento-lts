<?php
// $sURL = Internetseite, die aufgerufen werden soll
// $sMessage = Array mit POST-Variablen (optional)
function CurlPost($sURL)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_URL, $sURL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    

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