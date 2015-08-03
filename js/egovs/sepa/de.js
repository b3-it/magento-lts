// language file for checkiban.js

// deutsch, german ++++++++++++++++++++++++++++++++
// country names
var ctynm =	new Array (	"Andorra", "Vereinigte Arabische Emirate", "Albanien", "Österreich", "Aserbaidschan", "Bosnien und Herzegowina", "Belgien", "Bulgarien", "Bahrain", "Brasilien", "Schweiz", "Costa Rica", "Zypern", "Tschechische Republik", 
				"Deutschland", "Dänemark", "Dominikanische Republik", "Estland", "Spanien", "Finnland", "Färöer", "Frankreich", "Großbritannien", "Georgien", "Gibraltar", 
				"Grönland", "Griechenland", "Guatemala", "Kroatien", "Ungarn", "Irland", "Israel", "Island", "Italien", "Kuwait", "Kasachstan", "Libanon", 
				"Liechtenstein", "Litauen", "Luxemburg", "Lettland", "Monaco", "Moldawien", "Montenegro", "Mazedonien", "Mauretanien", "Malta", "Mauritius", "Niederlande", "Norwegen", "Pakistan", 
				"Polen", "Palästinensische Gebiete", "Portugal", "Rumänien", "Serbien", "Saudi-Arabien", "Schweden", "Slowenien", "Slowakei", "San Marino", "Tunesien", "Türkei", "Britische Jungferninseln");
// error messages
var altxt =	new Array (	"Die IBAN enthält unzulässige Zeichen.",
				"Die Struktur der IBAN ist falsch.",
				"Die Prüfziffern der IBAN sind falsch.",
				"Die Länge der IBAN kann nicht geprüft werden, weil "," zur Zeit nicht berücksichtigt ist.",
				"Die Länge der IBAN ist falsch. Die IBAN für "," muss "," Zeichen lang sein.",
				"Die IBAN scheint korrekt zu sein.",
				"Die IBAN ist nicht korrekt.");
// web page
var wptxt =	new Array (	1,"Bei folgenden Ländern (geordnet nach Länderkode) wird zur Zeit die zusätzliche Längenprüfung berücksichtigt:",
				"letzte Änderung: "," Unterliegt","unterliegt nicht","Testen einer gegebenen IBAN.","Druckform"
				,"Elektronische Form","Länge: ","Beispiel: ","IBAN für Transaktionen erforderlich !");
// additional explanations
var xpltxt =			"IE Irland kann für GB Großbritannien Konten benutzt werden im Fall, dass die servisierende "+
				"Bank in Nord Irland situiert ist und das Clearingsystem Irlands benutzt; GG Guernsey und "+
				"JE Jersey benutzen entweder GB Großbritannien oder FR Frankreich abhängig vom Clearingsystem, "+
				"das die servisierende Bank benutzt; GF Französisch Guyana, GP Guadeloupe, MQ Martinique und "+
				"RE Réunion benutzen FR Frankreich und unterliegen der EU-Regulative 924/2009; NC Neu Kaledonien, "+
				"PF Französisch Polynesien, PM Saint Pierre und Miquelon, TF Südfranzösische Territorien, "+
				"WF Wallis und Futuna und YT Mayotte benutzen FR Frankreich; ES Spanien inkludiert die "+						
				"Kanarischen Inseln, Ceuta und Melilla; PT Portugal inkludiert die Azoren und Madeira";
// deutsch, german ++++++++++++++++++++++++++++++++

// translators please take a source language including // language ++++... from a language script e.g. en.js
// translate and store in UTF-8 encoding to support your national characters
// only care about text surrounded by quotes, i.e. leave all other characters and format as is 
// send it
//
// please observe following special notation in translation of "web page" text
//
//                                    V
// wptxt = wptxt.concat ( new Array ( 0 ,"text 1","text 2","text 3","text 4","text 5","text 6","text 7","text 8","text 9"));
// results in
// "("+" EU Regulation 924/2009 "+"text 3"+"/"+"text 4"+")"
//
// while
//                                    V
// wptxt = wptxt.concat ( new Array ( 1 ,"text 1","text 2","text 3","text 4","text 5","text 6","text 7","text 8","text 9"));
// results in
// "("+"text 3"+"/"+"text 4"+" EU Regulation 924/2009 "+")"
//
// i.e. it is a language adaptor. Please choose properly. Thx
//
// therefore
// with 0 make it "text3","text 4 "
// with 1 make it " text3","text 4"

// script end
