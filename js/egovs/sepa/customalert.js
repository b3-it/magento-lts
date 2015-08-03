
//
// thanks to http://slayeroffice.com/code/custom_alert/ for initial code example
//
// this code works together with customalert.css and dragdrop.js
//

var ALERT_TITLE = "Message                                                                                                                             ";
var ALERT_BUTTON_TEXT = "OK";
var ALERT_QUEUE = new Array();

var myStyle = document.createElement("link");
myStyle.setAttribute("rel", "stylesheet");
myStyle.setAttribute("type", "text/css");
myStyle.setAttribute("href", "http://www.tbg5-finance.org/customalert.css");
document.getElementsByTagName("head")[0].appendChild(myStyle);

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
		removeCustomAlert(); }}

function removeCustomAlert() {
	if (ALERT_QUEUE.length > 0) {
		document.getElementById('alerttext').innerHTML = ALERT_QUEUE.shift(); }
	else {
		document.getElementsByTagName("body")[0].removeChild(document.getElementById("documentoverlay")); }}

function prepareCustomAlert(text) {
	var newtext = text;
	while (newtext.indexOf("|") >= 0) {
		newtext = newtext.replace("|", "<b>");
		newtext = newtext.replace("|", "</b>"); }
	newtext = newtext.replace(/\n/g, "<br>");
	newtext = unescape(newtext);
	return newtext;}

if(document.getElementById) {
	window.alert = function(text) { 
		createCustomAlert(text); }}
