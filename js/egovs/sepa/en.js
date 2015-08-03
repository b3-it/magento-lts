// language file for checkiban.js

// english, english +++++++++++++++++++++++++++++++
// country names
var ctynm =	new Array (	"Andorra", "United Arab Emirates", "Albania", "Austria", "Azerbaijan", "Bosnia and Herzegovina", "Belgium", "Bulgaria", "Bahrain", "Brazil", "Switzerland", "Costa Rica", "Cyprus", "Czech Republic", 
				"Germany", "Denmark", "Dominican Republic", "Estonia", "Spain", "Finland", "Faroe Islands", "France", "United Kingdom", "Georgia", "Gibraltar", 
				"Greenland", "Greece", "Guatemala", "Croatia", "Hungary", "Ireland", "Israel", "Iceland", "Italy", "Kuwait", "Kazakhstan", "Lebanon", "Liechtenstein", 
				"Lithuania", "Luxembourg", "Latvia", "Monaco", "Moldova", "Montenegro", "Macedonia", "Mauritania", "Malta", "Mauritius", "Netherlands", "Norway", "Pakistan", "Poland", 
				"Palestinian Territory", "Portugal", "Romania", "Serbia", "Saudi Arabia", "Sweden", "Slovenia", "Slovakia", "San Marino", "Tunisia", "Turkey", "Virgin Islands, British");
// error messages
var altxt =	new Array (	"The IBAN contains illegal characters.",
				"The structure of IBAN is wrong.",
				"The check digits of IBAN are wrong.",
				"Can not check correct length of IBAN because "," is currently not respected.",
				"The length of IBAN is wrong. The IBAN of "," needs to be "," characters long.",
				"The IBAN seems to be correct.",
				"The IBAN is incorrect.");
// web page
var wptxt =	new Array (	0,"Currently the additional length check of following countries is respected (ordered by country code):",
				"last update: ","applies","applies not ","Test of a given IBAN.","Print form",
				"Electronic form","Length: ","Example: ","IBAN required for transactions !");
// additional explanations
var xpltxt =			"IE Ireland may be used for GB Great Britain accounts in case the servicing bank is situated "+
				"in North Ireland and uses the clearing system of the Republic of Ireland; GG Guernsey and JE Jersey "+
				"are using either GB Great Britain or FR France depending on the clearing system used by the "+
				"servicing bank; GF French Guiana, GP Guadeloupe, MQ Martinique and RE Reunion are using FR France "+
				"and EU REGULATION 924/2009 applies; NC New Caledonia, PF French Polynesia, PM Saint Pierre and "+
				"Miquelon, TF French Southern Territories, WF Wallis and Futuna and YT Mayotte are using FR France; "+
				"ES Spain includes Canary Islands, Ceuta and Melilla; "+
				"PT Portugal includes Azores and Madeira";
// english, english +++++++++++++++++++++++++++++++

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
