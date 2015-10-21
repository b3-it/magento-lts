
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
	document.onmouseup = dragstop; }

function dragstart(element) {
	dragobjekt = document.getElementById(element);
	dragx = currentx - dragobjekt.offsetLeft;
	dragy = currenty - dragobjekt.offsetTop; }

function dragstop() {
	dragobjekt=null; }

function drag(dragevent) {
	currentx = document.all ? window.event.clientX : dragevent.pageX;
	currenty = document.all ? window.event.clientY : dragevent.pageY;
	if(dragobjekt != null) {
		dragobjekt.style.left = (currentx - dragx) + "px";
		dragobjekt.style.top = (currenty - dragy) + "px"; }}
		
draginit();