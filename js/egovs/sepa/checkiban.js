// More languages are welcome. Please send your list of country names, error messages, page text and explain text
// to TBG5 administrator. More advice at the end of this script. Thnx

// Special thx to:
// italian: Renato Polo                         norwegian: Siri-Anne dos Santos
// french: Walter Hoffmann & Pierrick Daumain   polish: Norbert Wozniak
// romanian: Kalman Pusztai                     serbian: Aleksandar Blagojevic
// bulgarian: Luben Karavelov                   slovenian: Alfred Anzlovar
// dutsh: Mark Sensen                           russian: Vasiliy Marhotsky
// hungarian: Tibor Albert                      lithuanian: Edmundas Kausikas
// turkish: Oguz Cekmeceligil                   catalan: Cristòfol-Josep Bordes i Figuerola
// swedish: Lars Madej                          chinese: May Chen
// greek: Stamatis Liatsos & Ian Gourley        spanish: Jesús Ferreiro
// albanian: Artan Rrustemi                     portuguese: Antonio Aguiar
// czech: Pavel Pech & Eva Marešová             finnish: Juha Keski-Nisula
// slovak: Lubomir Duchon                       danish: Christian Staal
// croatian: Zoran Babić                        latvian: Toms Abeltins
// estonian: Sven-Olav Paavel                   japanese: Kenji Itoh
// georgian: Mikheil Kapanadze                  mongolian: Solongo Luvsan

// Other: Markus Olderdissen, Gabriele Del Prete, scripting; google.com, translation;

// Scripting: Hendrik Muus

// add in_array method to arrays
Array.prototype.in_array = function(value) {
	var found = false;
	for (var i=0; i<this.length; i++) {
		if (this[i] == value) {
			found = i;
			break; }}
	return found; }
// add ISO13616Prepare method to strings
String.prototype.ISO13616Prepare = function() {
	var isostr = this.toUpperCase();
	isostr = isostr.substr(4) + isostr.substr(0,4);
	for (var i = 0; i <= 25; i++) {
		while (isostr.search(String.fromCharCode(i+65)) != -1) {
			isostr = isostr.replace(String.fromCharCode(i+65), String(i+10)); }}
	return isostr; }
// add ISO7064Mod97_10 method to strings
String.prototype.ISO7064Mod97_10 = function() {
	var parts = Math.ceil(this.length/7);
	var remainer = "";
	for (var i = 1; i <= parts; i++) {
		remainer = String(parseFloat(remainer+this.substr((i-1)*7, 7))%97); }
	return remainer; }
// replacement of === for javascript version < 1.2
function is_ident(a,b) {
	var identical = false;
	if (typeof(a)==typeof(b)) {
		if (a==b) {
			identical = true; }}
	return identical; }

// language codes
//			  1    2    3    4    5    6    7    8    9   10   11   12   13   14   15   16   17   18   19   20   21   22   23   24   25   26   27   28   29   30   31   32
var lngc = new Array (	"de","en","it","no","fr","pl","ro","sr","bg","sl","nl","ru","hu","lt","tr","ca","sv","zh","el","es","sq","pt","cs","fi","sk","da","hr","lv","et","ja","ka","mn");
// we have currently these languages:	1 deutsch, german, 2 english, english, 3 italiano, italian, 4 norske, norwegian, 5 français, french, 6 polska, polish, 7 română, romanian,
//					8 srpski, serbian, 9 Български, bulgarian, 10 slovenščina, slovenian, 11 nederlands, dutch, 12 русско, russian, 13 magyar, hungarian,
//					14 lietuvos, lithuanian, 15 türkçe, turkish, 16 català, catalan, 17 svenska, swedish, 18 中文, chinese, 19 Έλληνες, greek, 20 español, spanish,
//					21 shqiptar, albanian, 22 português, portuguese, 23 česky, czech, 24 suomalainen, finnish, 25 slovenskému, slovak, 26 dansk, danish,
//					27 hrvatski, croatian, 28 latvijā, latvian, 29 eesti, estonian, 30 日本, japanese, 31 ქართული, georgian, 32 mонгол хэлээр, mongolian
// language selector
var lngsel = "<option value=\"9\">Български, bulgarian</option>"+
             "<option value=\"16\">català, catalan</option>"+
             "<option value=\"23\">česky, czech</option>"+
             "<option value=\"18\">中文, chinese</option>"+
             "<option value=\"27\">hrvatski, croatian</option>"+
             "<option value=\"26\">dansk, danish</option>"+
             "<option value=\"1\">deutsch, german</option>"+
             "<option value=\"29\">eesti, estonian</option>"+
             "<option value=\"2\">english, english</option>"+
             "<option value=\"20\">español, spanish</option>"+
             "<option value=\"5\">français, french</option>"+
             "<option value=\"31\">ქართული, georgian</option>"+
             "<option value=\"19\">Έλληνες, greek</option>"+
             "<option value=\"3\">italiano, italian</option>"+
             "<option value=\"30\">日本, japanese</option>"+
             "<option value=\"14\">lietuvos, lithuanian</option>"+
             "<option value=\"28\">latvijā, latvian</option>"+
             "<option value=\"13\">magyar, hungarian</option>"+
             "<option value=\"32\">mонгол хэлээр, mongolian</option>"+
             "<option value=\"11\">nederlands, dutch</option>"+
             "<option value=\"4\">norske, norwegian</option>"+
             "<option value=\"6\">polska, polish</option>"+
             "<option value=\"22\">português, portuguese</option>"+
             "<option value=\"7\">română, romanian</option>"+
             "<option value=\"12\">русский, russian</option>"+
             "<option value=\"21\">shqiptar, albanian</option>"+
             "<option value=\"25\">slovenskému, slovak</option>"+
             "<option value=\"10\">slovenščina, slovenian</option>"+
             "<option value=\"8\">srpski, serbian</option>"+
             "<option value=\"24\">suomalainen, finnish</option>"+
             "<option value=\"17\">svenska, swedish</option>"+
             "<option value=\"15\">türkçe, turkish</option>";
// country codes, fixed length for those countries, inner structure, IBAN example, IBAN requirement,
// SEPA, appliance of EU REGULATION 924/2009;260/2012 and EUR
// inner structure: F=0-9, L=a-z, U=A-Z, A=F+L+U=0-9A-Za-z, B=F+U=0-9A-Z, C=L+U=A-Za-z,  W=F+L=0-9a-z plus count
// 2014-08-13
var ilbced = new Array (
	"AD", 24, "F04F04A12",		      "AD1200012030200359100100",		    "n", "n", "n", "n",
	"AE", 23, "F03F16",		          "AE070331234567890123456",		    "n", "n", "n", "n",
	"AL", 28, "F08A16",		          "AL47212110090000000235698741",	  "n", "n", "n", "n",
	"AT", 20, "F05F11",		          "AT611904300234573201",		        "y", "y", "y", "y",
	"AZ", 28, "U04A20",		          "AZ21NABZ00000000137010001944",	  "n", "n", "n", "n",
	"BA", 20, "F03F03F08F02",	      "BA391290079401028494",		        "n", "n", "n", "n",
	"BE", 16, "F03F07F02",		      "BE68539007547034",		            "y", "y", "y", "y",
	"BG", 22, "U04F04F02A08",	      "BG80BNBG96611020345678",		      "y", "y", "y", "n",
	"BH", 22, "U04A14",		          "BH67BMAG00001299123456",		      "y", "n", "n", "n",
	"BR", 29, "F08F05F10U01A01",    "BR9700360305000010009795493P1",  "n", "n", "n", "n",
	"CH", 21, "F05A12",		          "CH9300762011623852957",		      "n", "y", "n", "n",
	"CR", 21, "F03F14",		          "CR0515202001026284066",		      "n", "n", "n", "n",
	"CY", 28, "F03F05A16",		      "CY17002001280000001200527600",   "y", "y", "y", "y",
	"CZ", 24, "F04F06F10",		      "CZ6508000000192000145399",		    "y", "y", "y", "n",
	"DE", 22, "F08F10",		          "DE89370400440532013000",		      "y", "y", "y", "y",
	"DK", 18, "F04F09F01",          "DK5000400440116243",		          "y", "y", "y", "n",
	"DO", 28, "U04F20",		          "DO28BAGR00000001212453611324",   "n", "n", "n", "n",
	"EE", 20, "F02F02F11F01",		    "EE382200221020145685",		        "y", "y", "y", "y",
	"ES", 24, "F04F04F01F01F10",    "ES9121000418450200051332",		    "y", "y", "y", "y",
	"FI", 18, "F06F07F01",		      "FI2112345600000785",		          "y", "y", "y", "y",
	"FO", 18, "F04F09F01",		      "FO6264600001631634",		          "n", "y", "n", "n",
	"FR", 27, "F05F05A11F02",		    "FR1420041010050500013M02606",    "y", "y", "y", "y",
	"GB", 22, "U04F06F08",		      "GB29NWBK60161331926819",		      "y", "y", "y", "n",
	"GE", 22, "U02F16",		          "GE29NB0000000101904917",		      "n", "n", "n", "n",
	"GI", 23, "U04A15",		          "GI75NWBK000000007099453",		    "y", "y", "y", "n",
	"GL", 18, "F04F09F01",		      "GL8964710001000206",		          "n", "y", "n", "n",
	"GR", 27, "F03F04A16",		      "GR1601101250000000012300695",	  "y", "y", "y", "y",
	"GT", 28, "A04A20",		          "GT82TRAJ01020000001210029690",	  "n", "n", "n", "n",
	"HR", 21, "F07F10",		          "HR1210010051863000160",		      "y", "y", "y", "n",
	"HU", 28, "F03F04F01F15F01",    "HU42117730161111101800000000",	  "y", "y", "y", "n",
	"IE", 22, "U04F06F08",		      "IE29AIBK93115212345678",		      "y", "y", "y", "y",
	"IL", 23, "F03F03F13",		      "IL620108000000099999999",		    "n", "n", "n", "n",
	"IS", 26, "F04F02F06F10",		    "IS140159260076545510730339",		  "n", "y", "n", "n",
	"IT", 27, "U01F05F05A12",		    "IT60X0542811101000000123456",	  "y", "y", "y", "y",
	"JO", 30, "U04F04A18",		      "JO94CBJO0010000000000131000302",	"y", "n", "n", "n",
	"KW", 30, "U04A22",		          "KW81CBKU0000000000001234560101",	"y", "n", "n", "n",
	"KZ", 20, "F03A13",		          "KZ86125KZT5004100100",		        "n", "n", "n", "n",
	"LB", 28, "F04A20",		          "LB62099900000001001901229114",	  "n", "n", "n", "n",
	"LI", 21, "F05A12",		          "LI21088100002324013AA",	        "y", "y", "y", "n",
	"LT", 20, "F05F11",		          "LT121000011101001000",		        "y", "y", "y", "n",
	"LU", 20, "F03A13",		          "LU280019400644750000",		        "y", "y", "y", "y",
	"LV", 21, "U04A13",		          "LV80BANK0000435195001",		      "y", "y", "y", "n",
	"MC", 27, "F05F05A11F02",		    "MC5811222000010123456789030",	  "n", "y", "n", "n",
	"MD", 24, "A20",		            "MD24AG000225100013104168",		    "n", "n", "n", "n",
	"ME", 22, "F03F13F02",		      "ME25505000012345678951",		      "n", "n", "n", "n",
	"MK", 19, "F03A10F02",		      "MK07250120000058984",		        "n", "n", "n", "n",
	"MR", 27, "F05F05F11F02",		    "MR1300020001010000123456753",	  "n", "n", "n", "n",
	"MT", 31, "U04F05A18",		      "MT84MALT011000012345MTLCAST001S","y", "y", "y", "y",
	"MU", 30, "U04F02F02F12F03U03",	"MU17BOMM0101101030300200000MUR", "n", "n", "n", "n",
	"NL", 18, "U04F10",             "NL91ABNA0417164300",	            "y", "y", "y", "y",
	"NO", 15, "F04F06F01",		      "NO9386011117947",		            "n", "y", "n", "n",
	"PK", 24, "U04A16",		          "PK36SCBL0000001123456702",		    "n", "n", "n", "n",
	"PL", 28, "F08F16",		          "PL61109010140000071219812874",	  "y", "y", "y", "n",
	"PS", 29, "U04A21",		          "PS92PALS000000000400123456702",	"n", "n", "n", "n",
	"PT", 25, "F04F04F11F02",		    "PT50000201231234567890154",		  "y", "y", "y", "y",
	"QA", 29, "U04A21",		          "QA58DOHB00001234567890ABCDEFG",	"y", "n", "n", "n",
	"RO", 24, "U04A16",		          "RO49AAAA1B31007593840000",		    "y", "y", "y", "n",
	"RS", 22, "F03F13F02",		      "RS35260005601001611379",		      "n", "n", "n", "n",
	"SA", 24, "F02A18",		          "SA0380000000608010167519",		    "y", "n", "n", "n",
	"SE", 24, "F03F16F01",		      "SE4550000000058398257466",		    "y", "y", "y", "n",
	"SI", 19, "F05F08F02",		      "SI56263300012039086",		        "y", "y", "y", "n",
	"SK", 24, "F04F06F10",		      "SK3112000000198742637541",		    "y", "y", "y", "y",
	"SM", 27, "U01F05F05A12",		    "SM86U0322509800000000270100",	  "n", "y", "n", "n",
	//"TL", 23, "F03F14F02",		      "TL380080012345678910157",		    "n", "n", "n", "n",
	"TN", 24, "F02F03F13F02",		    "TN5910006035183598478831",		    "n", "n", "n", "n",
	"TR", 26, "F05A01A16",		      "TR330006100519786457841326",		  "y", "n", "n", "n",
	"VG", 24, "U04F16",		          "VG96VPVG0000012345678901",		    "n", "n", "n", "n"//,
	//"XK", 20, "F04F10F02",          "XK051212012345678906",		        "n", "y", "n", "y"
	);
// we have currently # countries
var ctcnt = ilbced.length/8;

// the magic core routine
function checkibancore(iban) {
	var standard = -1;
	illegal = /\W|_/; // contains chars other than (a-zA-Z0-9)
	if(illegal.test(iban)) { // yes, alert and exit
		illegal = /((\W|_)+)/g;
		var ichars;
		var aliban = "";
		var lindex = -1;
		while (ichars = illegal.exec(iban)) {
			aliban += iban.substring(lindex+1,ichars.index)+"<strong>"+ichars[1]+"</strong>";
			lindex = ichars.index;
		}
		aliban += iban.substr(lindex+1);
		aliban = aliban.replace(/\|/g, "%7C");
		alert(aliban+"\n\n"+altxt[0]);
		return "0"; }
	else { // no, continue
		illegal = /^\D\D\d\d.+/; // first chars are letter letter digit digit
		if(illegal.test(iban) == false) { // no, alert and exit
			alert("|"+iban.substr(0,4)+"|"+iban.substr(5)+"\n\n"+altxt[1]);
			return "0"; }
		else { // yes, continue
			illegal = /^\D\D00.+|^\D\D01.+|^\D\D99.+/; // check digit are 00 or 01 or 99
			if(illegal.test(iban)) { // yes, alert and exit
				alert(iban.substr(0,2)+"|"+iban.substr(2,2)+"|"+iban.substr(5)+"\n\n"+altxt[2]);
				return "0"; }
			else { // no, continue
				lofi = ilbc.slice(0,ctcnt).in_array(iban.substr(0,2).toUpperCase()); // test if country respected
				if (is_ident(false,lofi)) { ctck=-1; lofi=6; }  // country not respected
				else { ctck=lofi; lofi=ilbc[lofi+ctcnt*1]; } // country respected
				if (lofi == 6) { // not respected, alert
					alert(altxt[3]+iban.substr(0,2).toUpperCase()+altxt[4]);
					lofi = iban.length; }  // but continue
				if ((iban.length-lofi) != 0) { // fits length to country
					alert(altxt[5]+ctynm[ctck]+altxt[6]+ilbc[ctck+ctcnt*1]+altxt[7]); // no, alert and exit
					return "0"; } // yes, continue
				if (ctck >= 0) { illegal = buildtest("B04" +ilbc[ctck+ctcnt*2],standard); } // fetch sub structure of respected country
				else { illegal = /.+/; } // or take care of not respected country
				if (illegal.test(iban) == false) { // fits sub structure to country
					alert(getstructurealert(ilbc[ctck+ctcnt*2],iban)+"\n\n"+altxt[1]); // no, alert and exit
					return "0"; }
				else { // yes, continue
					return iban.ISO13616Prepare().ISO7064Mod97_10();
				}
			}
		}
	}
} // calculate and return the remainer
// perform the check
function checkiban(iban) {
	if (checkibancore(iban) == "1") { alert(altxt[8]); } // and prompt result
	else { alert(altxt[9]); }}
function buildtest(structure,kind) {
	var result = "";
	var testpattern = structure.match(/([ABCFLUW]\d{2})/g);
	var patterncount = testpattern.length;
	for (var i = 0; i < patterncount; ++i) {
		if (((kind >= 0)&&(i != kind))||(kind == -2)) {
			result += testpart(testpattern[i],"any"); }
		else {
			result += testpart(testpattern[i],"standard"); }}
	return new RegExp(result); }
function testpart(pattern,kind) {
	var testpattern = "(";
	if (kind == "any") {
		testpattern += "."; }
	else {
		testpattern += "[";
		if (kind == "reverse") {
			testpattern += "^"; }
		switch (pattern.substr(0,1)) {
			case "A": testpattern += "0-9A-Za-z"; break;
			case "B": testpattern += "0-9A-Z"; break;
			case "C": testpattern += "A-Za-z"; break;
			case "F": testpattern += "0-9"; break;
			case "L": testpattern += "a-z"; break;
			case "U": testpattern += "A-Z"; break;
			case "W": testpattern += "0-9a-z"; break; }
		testpattern += "]"; }
	if (((pattern.substr(1,2)*1) > 1) && (kind != "reverse")) {
		testpattern += "{"+String(pattern.substr(1,2)*1)+"}"; }
	testpattern += ")";
	return testpattern;
}
function getstructurealert(structure,iban) {
	any = -2;
	structure = "B04" + structure;
	var result = "";
	var failpattern = "";
	var testpattern = structure.match(/([ABCFLUW]\d{2})/g);
	var patterncount = testpattern.length;
	for (var i = 0; i < patterncount; ++i) {
		failpattern = buildtest(structure,i);
		if (!failpattern.test(iban)) {
			failpattern = buildtest(structure,any);
			var ibanparts = iban.match(failpattern);
			var ibanpart = ibanparts[i+1];
			var partpattern = structure.match(/([ABCFLUW]\d{2})/g);
			var failures = ibanpart.match(new RegExp(testpart(partpattern[i],"reverse"),"g"));
			var failure = 0;
			var pos = 0;
			while ((pos < ibanpart.length) && (failure < failures.length)) {
				if (ibanpart.substr(pos,1) == failures[failure]) {
					result += "|"+ibanpart.substr(pos,1)+"|";
					++failure; }
				else {
					result += ibanpart.substr(pos,1); }
				++pos; }
			result += ibanpart.substr(pos)+" "; }
		else {
			var ibanparts = iban.match(failpattern);
			result += ibanparts[i+1]+" "; }}
	result = result.replace(/||/g, "");
	return result;
}
// some convenience for web page
function langsel() { document.write(lngsel); } //language selector
function lginfo() {
	if (is_ident(false,lngc.in_array(hlc.substr(1,2)))) {
		document.write("<BR><small>"+hlc+" currently not translated, like to translate?</small>");
	}
}
function rwt(tnum) {
	document.write(wptxt[tnum]);
} //web page text by number
function rwt2(pos) {
	var eu_260 = 'http://eur-lex.europa.eu/legal-content/EN/ALL/?uri=CELEX:32012R0260';
	var eu_924 = 'http://eur-lex.europa.eu/legal-content/EN/TXT/?qid=1449153295357&uri=CELEX:32009R0924';

	if (wptxt[0] == pos) {
		document.write(" <a href='"+eu_924+"' target='_blank' title='Regulation 924 on eur-lex.europa.eu'>EU Regulation 924/2009</a>;"+
		               " <a href='"+eu_260+"' target='_blank' title='Regulation 260 on eur-lex.europa.eu'>EU Regulation 260/2012 </a>");
	}
} //special web page text
// whole line of special web page text
function rwt3() {
	document.write("<small><BR>(");
	rwt2(0);
	document.write("<span class=\"tbg5eray\">");
	rwt(3);
	document.write("</span> / <span class=\"tbg5eran\">");
	rwt(4);
	document.write("</span>");
	rwt2(1);
	document.write(")<BR><BR></small>"); }
// some convenience to list the countries
// 3 IBAN example, 4 IBAN requirement, 5 SEPA, 6 appliance of EU REGULATION 924/2009;260/2012 and 7 EUR
function rcr(tnum) { return ilbc[tnum+ctcnt*6]; } //country regulatory info by number (EU regulation)
function rcl(tnum) { return wptxt[8]+ilbc[tnum+ctcnt*1]; } //hover text for code (length)
function rce(tnum) { return wptxt[9]+ilbc[tnum+ctcnt*3]; } //hover text for name (example)
function rir(tnum,ipath) {  //note mark (IBAN requirement etc)
	rirrt = ""
	if (ilbc[tnum+ctcnt*4] == "y") {	// IBAN requirement
		rirrt = "<img border=\"0\" width=\"13\" height=\"13\" src=\""+ipath+"iban.png\" alt=\""+wptxt[10]+"\" title=\""+wptxt[10]+"\">"; }
	else {
		rirrt = "<img border=\"0\" width=\"13\" height=\"13\" src=\""+ipath+"empt.png\">"; }
	if (ilbc[tnum+ctcnt*5] == "y") {	// SEPA
		rirrt += "<img border=\"0\" width=\"13\" height=\"13\" src=\""+ipath+"sepa.png\" alt=\"SEPA\" title=\"SEPA\"><br/>"; }
	else {
		rirrt += "<img border=\"0\" width=\"13\" height=\"13\" src=\""+ipath+"empt.png\"><br/>"; }
	if (ilbc[tnum+ctcnt*6] == "y") {	// appliance of EU REGULATION 924/2009;260/2012
		rirrt += "<img border=\"0\" width=\"13\" height=\"13\" src=\""+ipath+"eulx.png\" alt=\"EU Regulation\" title=\"EU Regulation\">"; }
	else {
		rirrt += "<img border=\"0\" width=\"13\" height=\"13\" src=\""+ipath+"empt.png\">"; }
	if (ilbc[tnum+ctcnt*7] == "y") {	// EUR
		rirrt += "<img border=\"0\" width=\"13\" height=\"13\" src=\""+ipath+"euro.png\" alt=\"EURO\" title=\"EURO\">"; }
	else {
		rirrt += "<img border=\"0\" width=\"13\" height=\"13\" src=\""+ipath+"empt.png\">"; }
	return rirrt;}
// list countries in x columns with language y ##### old, use new please #####
function listcountries(columni,llngg) {
	listcountriesnew(columni,llngg,"n",""); }
// list countries in x columns with language y show flag y/n from path ##### new #####
// make sure the flag images are available at path and provide a style declaration like "img.tbg5cdf { height:20px; }" !!
function listcountriesnew(columni,llngg,flag,ipath) {
	lngg = llngg; //use language parameter
	if ((lngg < 1) || (lngg > lngc.length)) {
		lngg = 2; }
	if (flag == "n") {
		document.write("<table class=\"tbg5ct\">\r\n<TR class=\"tbg5crt\"><TD class=\"tbg5cdt\" colspan=\""+columni*3+"\"> </TD></TR>\r\n"); }
	else {	document.write("<table class=\"tbg5ct\">\r\n<TR class=\"tbg5crt\"><TD class=\"tbg5cdt\" colspan=\""+columni*4+"\"> </TD></TR>\r\n"); }
	var numberofrows = Math.ceil(ctcnt/columni); //calculate rows
	for (i = 0; i < numberofrows; i++) { //for each row
		document.write("<tr class=\"tbg5crl\">");
		for (var j = 0; j < columni; j++) { //for each column
			if ((i*columni+j)<ctcnt) { //fill cells
				document.write("<td class=\"tbg5cdc\" title=\""+rcl(i*columni+j)+"\"><span class=\"tbg5era"+rcr(i*columni+j)+"\">"+ilbc[i*columni+j]+"</span></td>"); //country code
				document.write("<td class=\"tbg5cdc\" style=\"border:1px solid grey;white-space:nowrap;\">"+rir(i*columni+j,ipath)+"</td>"); //country code
				if (flag == "y") { //show flag
					document.write("<td class=\"tbg5cdf\"><img class=\"tbg5cdf\" src=\""+ipath+ilbc[i*columni+j]+".png\" alt=\""+ctynm[i*columni+j]+"\" title=\""+ctynm[i*columni+j]+"\"></td>"); }
				document.write("<td class=\"tbg5cdn\" title=\""+rce(i*columni+j)+"\"><span class=\"tbg5era"+rcr(i*columni+j)+"\">"+ctynm[i*columni+j]+"</span></td>"); }} //country name
		document.write("</tr>\r\n"); }
	document.write("</table>\r\n");
	if (document.dlang) {
		if (document.dlang.mlang) {
			for (var i = 1; i <= document.dlang.mlang.length; i++) {
				if (document.dlang.mlang[i-1].value==lngg) {
					document.dlang.mlang[i-1].selected=true;
				}
			}
		}
	}
}
// some convenience for additional explanations
function doexplain(llngg) {
	document.write(xpltxt);
}

// load languagefile
function llanguagefile(language) {
	document.write('<script charset="utf-8" src="'+language+'" type="text/JavaScript"><\/script>');
}
function llanguage(language) {
	jsfile = 'http://www.tbg5-finance.org/'+lngc[language-1]+'.js';
	llanguagefile(jsfile);
}

// load helperfiles
function helperjsfile(file) {
	document.write('<script src="'+file+'" type="text/JavaScript"><\/script>');
}
function helpers() {
	jsfile = 'http://www.tbg5-finance.org/dragdrop.js';
	helperjsfile(jsfile);
	jsfile = 'http://www.tbg5-finance.org/customalert.js';
	helperjsfile(jsfile);
}

// dragdrop.js
//
// set property "onmousedown" of element to dragdrop to "dragstart(element id)"
//
// "element id" is typically this.id
//

var dragobjekt = null;
var dragx = 0;
var dragy = 0;
var currentx = 0;
var currenty = 0;

function draginit() {
	document.onmousemove = drag;
	document.onmouseup = dragstop;
}

function dragstart(element) {
	dragobjekt = document.getElementById(element);
	dragx = currentx - dragobjekt.offsetLeft;
	dragy = currenty - dragobjekt.offsetTop;
}

function dragstop() {
	dragobjekt=null;
}

function drag(dragevent) {
	currentx = document.all ? window.event.clientX : dragevent.pageX;
	currenty = document.all ? window.event.clientY : dragevent.pageY;
	if(dragobjekt != null) {
		dragobjekt.style.left = (currentx - dragx) + "px";
		dragobjekt.style.top = (currenty - dragy) + "px";
	}
}
// dragdrop.js

// customalert.js
//
// thanks to http://slayeroffice.com/code/custom_alert/ for initial code example
//
// this code works together with customalert.css and dragdrop.js
//

var ALERT_TITLE = "Message";
var ALERT_BUTTON_TEXT = "OK";
var ALERT_QUEUE = new Array();

function createCustomAlert(ALERT_TEXT) {
	ALERT_QUEUE.push(prepareCustomAlert(ALERT_TEXT));
	d = document;
	if (d.getElementById("documentoverlay")) {
		return; }
	myObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
	myObj.id = "documentoverlay";
	myObj.style.height = document.documentElement.scrollHeight + "px";
	alertObj = myObj.appendChild(d.createElement("div"));
	alertObj.id = "alertbox";
	if (d.all && !window.opera) {
		alertObj.style.top = document.documentElement.scrollTop + "px"; }
	alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
	alertTitle = alertObj.appendChild(d.createElement("h1"));
	alertTitle.appendChild(d.createTextNode(ALERT_TITLE));
	alertTitle.onmousedown = function() {
		dragstart('alertbox');
		return; }
	alertMsg = alertObj.appendChild(d.createElement("p"));
	alertMsg.id = "alerttext";
	alertMsg.innerHTML = ALERT_QUEUE.shift();
	alertButton = alertObj.appendChild(d.createElement("button"));
	alertButton.id = "closebutton";
	alertButton.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
	alertButton.onclick = function() {
		removeCustomAlert(); }
	alertClose = alertObj.appendChild(d.createElement("button"));
	alertClose.id = "cancelbutton";
	alertClose.onclick = function() {
		removeCustomAlert();
	}
}

function removeCustomAlert() {
	if (ALERT_QUEUE.length > 0) {
		document.getElementById('alerttext').innerHTML = ALERT_QUEUE.shift();
	}
	else {
		document.getElementsByTagName("body")[0].removeChild(document.getElementById("documentoverlay"));
	}
}

function prepareCustomAlert(text) {
	var newtext = text;
	while (newtext.indexOf("|") >= 0) {
		newtext = newtext.replace("|", "<b>");
		newtext = newtext.replace("|", "</b>");
	}
	newtext = newtext.replace(/\n/g, "<br>");
	newtext = unescape(newtext);
	return newtext;
}

if(document.getElementById) {
	window.alert = function(text) {
		createCustomAlert(text);
	}
}
// customalert.js



$j(document).ready(function(){
    var lngg = 1;

    // use language 2 (english) by default
    if ((typeof(lngg) == 'undefined') || (lngg > lngc.length) || (lngg < 1)) {
    	lngg = 2;
    	// workaround
    	if ((location.search != "") && (location.search != "?")) {
    		sstr = window.location.search.substr(1,window.location.search.length-1);
    		if (!isNaN(sstr ) && (sstr*1 > 0) && (sstr*1 <= lngc.length)) {
    			lngg = Number(sstr);
    		}
    	}
    }

    // rearange country codes and related info
    var ilbc = new Array ();
    for (j = 0; j < 8; j++) {
    	for (i = 0; i < ctcnt; i++) {
    		ilbc[ilbc.length]=ilbced[j+i*8];
    	}
    }

    //llanguage(lngg);
    //helpers();
    draginit();
});

// translators please take a source language including // language ++++... from laguage file e.g. en.js
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
