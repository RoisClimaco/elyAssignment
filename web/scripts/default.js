function validate_multiple_checkbox(objField)
{
	
	if (typeof objField.length != 'undefined')
	{
		intNumEntries = objField.length;
		for (i = 0; i < intNumEntries; i++)
		{
			if (objField[i].checked == true)
			{
				return true;
			}
		}
	}
	else
	{
		if (objField.checked == true)
		{
			return true;
		}
	}
	return false;
	
}

function tick_box(objForm, chkValue, chkName)
{	
	intElementCnt = objForm.elements.length;	
	for (i = 0; i < intElementCnt; i++)
	{				
		if (objForm.elements[i].name == chkName)
		{	
			if(chkValue == true)
			{
				objForm.elements[i].checked = true;
			}
			else
			{
				objForm.elements[i].checked = false;
			}
		}
	}		
}

function confirm_multiple_delete(objForm, objField)
{		
	if (validate_multiple_checkbox(objField))
	{
		if (confirm('Are you sure you want to delete the selected items?') == 1)
		{
			objForm.mode.value = 'del';
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		alert('Please choose the items you want to delete!');
		return false;
	}
}

NS4 = (document.layers) ? 1 : 0;
IE4 = (document.all) ? 1 : 0;
W3C = (document.getElementById) ? 1 : 0;
var objLayerShow;
var objLayerHide;


function show_field(lyrText, lyrField, btnText, btnField)
{
  	if (W3C) 
	{
		objLayerText = document.getElementById(lyrText);
		objLayerField = document.getElementById(lyrField);
		objLayerTextButton = document.getElementById(btnText);
		objLayerFieldButton = document.getElementById(btnField);
	}
	else if (NS4)
	{
 		objLayerText = document.layers[lyrText];
 		objLayerField = document.layers[lyrField];
 		objLayerTextButton = document.layers[btnText];
 		objLayerFieldButton = document.layers[btnField];
	} 
	else 
	{
 		objLayerText = document.all[lyrText];
 		objLayerField = document.all[lyrField];
 		objLayerTextButton = document.all[btnText];
 		objLayerFieldButton = document.all[btnField];
	}
	objLayerText.style.display = 'none';
	objLayerField.style.display = 'block';
	objLayerTextButton.style.display = 'none';
	objLayerFieldButton.style.display = 'block';
}

function show_text(lyrText, lyrField, btnText, btnField)
{
  	if (W3C) 
	{
		objLayerText = document.getElementById(lyrText);
		objLayerField = document.getElementById(lyrField);
		objLayerTextButton = document.getElementById(btnText);
		objLayerFieldButton = document.getElementById(btnField);
	}
	else if (NS4)
	{
 		objLayerText = document.layers[lyrText];
 		objLayerField = document.layers[lyrField];
 		objLayerTextButton = document.layers[btnText];
 		objLayerFieldButton = document.layers[btnField];
	} 
	else 
	{
 		objLayerText = document.all[lyrText];
 		objLayerField = document.all[lyrField];
 		objLayerTextButton = document.all[btnText];
 		objLayerFieldButton = document.all[btnField];
	}
	objLayerText.style.display = 'block';
	objLayerField.style.display = 'none';
	objLayerTextButton.style.display = 'block';
	objLayerFieldButton.style.display = 'none';
}

function swap_layer(lyrShow, lyrHide)
{
  	if (W3C) 
	{
		objLayerShow = document.getElementById(lyrShow);
		objLayerHide = document.getElementById(lyrHide);
	}
	else if (NS4)
	{
 		objLayerShow = document.layers[lyrShow];
 		objLayerHide = document.layers[lyrHide];
	} 
	else 
	{
 		objLayerShow = document.all[lyrShow];
 		objLayerHide = document.all[lyrHide];
	}	
	
	objLayerShow.style.display = 'block';
	objLayerHide.style.display = 'none';
}

function confirmDelete(objForm)
{
	var i=0;
	for(i=0; i <= objForm.elements.length; i++)
	{
		if (objForm.elements[i].value == '')
		{
			alert("The an item to be deleted");
			return false;
		}
		else
		{
			if (confirm("Are you sure you want to delete the selected Items") == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	} 
}

MDMG_menusection = new Array();

MDMG_MovabilityOfSubMenuPositions = "static";

MDMG_menusection[1] = "main_section";
MDMG_menusection[2] = "downloads_section";
MDMG_menusection[3] = "tutorials_section";


//
// End of customization sections.
///////////////////////////////////////////////////////////////


MDMG_menusection[0] = "unused";
MDMG_menusectionprinted = new Array();
for(i = 0; i < MDMG_menusection.length; i++) { MDMG_menusectionprinted[i] = false; }
bNS4 = bNS6 = bIE = bOPERA = false;
if     (navigator.userAgent.indexOf("Opera") != -1) { bOPERA = true; }
else if(navigator.userAgent.indexOf("Gecko") != -1) { bNS6 = true;   }
else if(document.layers)                            { bNS4 = true;   }
else if(document.all)                               { bIE = true;    }

MDMGx = MDMGxx = MDMGy = MDMGyy = 0;
var MDMG_mousex;
var MDMG_mousey;
STO = null;
if(bNS4 || bNS6 || bOPERA) { document.captureEvents(Event.MOUSEMOVE); }
document.onmousemove = MDMG_getmouseposition;


// Functions used by all browsers

function MDMG_getmouseposition(e){
if(bIE || bOPERA) { 
	MDMG_mousex = event.clientX;
	MDMG_mousey = event.clientY;
	}
else if(bNS6 || bNS4) {
	MDMG_mousex = e.pageX;
	MDMG_mousey = e.pageY;
	}
} // MDMG_getmouseposition()

function MDMG_HideIfOutsideRectangle()
{
	if(MDMG_mouseinrectangle()) { STO = setTimeout('MDMG_HideIfOutsideRectangle()',10); }
	else { clearTimeout(STO); MDMG_hideallmenusections(); }
} // MDMG_HideIfOutsideRectangle()

function MDMG_mouseinrectangle() {
if(MDMG_mousex >= MDMGx && MDMG_mousex <= MDMGxx && MDMG_mousey >= MDMGy && MDMG_mousey <= MDMGyy) { return true; }
else { return false; }
} // MDMG_mouseinrectangle()



// Functions to relay browser type to custom functions

function MDMG_showsection(m_section) {
clearTimeout(STO);
if(bIE) {
	MDMG_bIE_hideallmenusections();
	MDMG_bIE_showit(m_section);
	}
else if(bNS6) {
	MDMG_bNS6_hideallmenusections();
	MDMG_bNS6_showit(m_section);
	}
else if(bOPERA) {
	MDMG_bOPERA_hideallmenusections();
	MDMG_bOPERA_showit(m_section);
	}
else if(bNS4) {
	MDMG_bNS4_hideallmenusections();
	MDMG_bNS4_showit(m_section);
	}
} // MDMG_showsection()

function MDMG_hideallmenusections() {
clearTimeout(STO);
if(bIE) { MDMG_bIE_hideallmenusections(); }
else if(bNS6) { MDMG_bNS6_hideallmenusections(); }
else if(bOPERA) { MDMG_bOPERA_hideallmenusections(); }
else if(bNS4) { MDMG_bNS4_hideallmenusections(); }
} // MDMG_hideallmenusections()




// IE functions

function MDMG_bIE_hidesection(m_section) {
if(MDMG_mouseinrectangle()) { return; }
eval(MDMG_menusection[m_section] + '.style.visibility="hidden"');
MDMG_menusectionprinted[m_section] = false;
} // MDMG_bIE_hidesection()

function MDMG_bIE_hideallmenusections() {
for(i = 1; i < MDMG_menusection.length; i++) { 
	eval(MDMG_menusection[i] + '.style.visibility="hidden"');
	MDMG_menusectionprinted[i] = false;
	}
} // MDMG_bIE_hideallmenusections()

function MDMG_bIE_showit(m_section) {
	if(MDMG_menusectionprinted[m_section] == true) { return; }
	clearTimeout(STO);
	MDMG_bIE_hideallmenusections();
	MDMG_menusectionprinted[m_section] = true;
	var x = MDMG_mousex - 1;
	if(x < 0) { x = 0; }
	var y = MDMG_mousey - 1;
	if(y < 0) { y = 0; }
	if(MDMG_MovabilityOfSubMenuPositions != "static") {
		eval(MDMG_menusection[m_section] + '.style.left="' + x + '"');
		eval(MDMG_menusection[m_section] + '.style.top="' + y + '"');
		}
	eval(MDMG_menusection[m_section] + '.style.visibility="visible"');
	MDMGx = eval(MDMG_menusection[m_section] + '.style.pixelLeft');
	MDMGxx = eval(MDMG_menusection[m_section] + '.scrollWidth') + MDMGx;
	MDMGy = eval(MDMG_menusection[m_section] + '.style.pixelTop');
	MDMGyy = eval(MDMG_menusection[m_section] + '.scrollHeight') + MDMGy;
	STO = setTimeout('MDMG_HideIfOutsideRectangle()',2000);
} // MDMG_bIE_showit()



// Netscape 6 functions

function MDMG_bNS6_hidesection(m_section) {
if(MDMG_mouseinrectangle()) { return; }
document.getElementById(MDMG_menusection[m_section]).style.visibility="hidden";
MDMG_menusectionprinted[m_section] = false;
} // MDMG_bNS6_hidesection()

function MDMG_bNS6_hideallmenusections() {
for(i = 1; i < MDMG_menusection.length; i++) { 
	document.getElementById(MDMG_menusection[i]).style.visibility="hidden";
	MDMG_menusectionprinted[i] = false;
	}
} // MDMG_bNS6_hideallmenusections()

function MDMG_bNS6_showit(m_section) {
	if(MDMG_menusectionprinted[m_section] == true) { return; }
	clearTimeout(STO);
	MDMG_bNS6_hideallmenusections();
	MDMG_menusectionprinted[m_section] = true;
	var x = MDMG_mousex - 1;
	if(x < 0) { x = 0; }
	var y = MDMG_mousey - 1;
	if(y < 0) { y = 0; }
	if(MDMG_MovabilityOfSubMenuPositions != "static") {
		document.getElementById(MDMG_menusection[m_section]).style.left = x + 'px';
		document.getElementById(MDMG_menusection[m_section]).style.top = y + 'px';
		}
	document.getElementById(MDMG_menusection[m_section]).style.visibility="visible";
	var padding = 0;
	if(parseInt(document.getElementById(MDMG_menusection[m_section]).style.padding) > 0) { padding = parseInt(document.getElementById(MDMG_menusection[m_section]).style.padding) * 2; }
	MDMGx = parseInt(document.getElementById(MDMG_menusection[m_section]).style.left);
	MDMGxx = parseInt(document.getElementById(MDMG_menusection[m_section]).style.width) + MDMGx + padding;
	MDMGy = parseInt(document.getElementById(MDMG_menusection[m_section]).style.top);
	MDMGyy = parseInt(document.getElementById(MDMG_menusection[m_section]).style.height) + MDMGy + padding;
	STO = setTimeout('MDMG_HideIfOutsideRectangle()',2000);
} // MDMG_bNS6_showit()



// Opera 5 and Opera 6 functions
function MDMG_bOPERA_hidesection(m_section) {
if(MDMG_mouseinrectangle()) { return; }
document.getElementById(MDMG_menusection[m_section]).style.visibility="hidden";
MDMG_menusectionprinted[m_section] = false;
} // MDMG_bOPERA_hidesection()

function MDMG_bOPERA_hideallmenusections() {
for(i = 1; i < MDMG_menusection.length; i++) { 
	document.getElementById(MDMG_menusection[i]).style.visibility="hidden";
	MDMG_menusectionprinted[i] = false;
	}
} // MDMG_bOPERA_hideallmenusections()

function MDMG_bOPERA_showit(m_section) {
	if(MDMG_menusectionprinted[m_section] == true) { return; }
	clearTimeout(STO);
	MDMG_bOPERA_hideallmenusections();
	MDMG_menusectionprinted[m_section] = true;
	var x = MDMG_mousex - 1;
	if(x < 0) { x = 0; }
	var y = MDMG_mousey - 1;
	if(y < 0) { y = 0; }
	if(MDMG_MovabilityOfSubMenuPositions != "static") {
		document.getElementById(MDMG_menusection[m_section]).style.left = x + 'px';
		document.getElementById(MDMG_menusection[m_section]).style.top = y + 'px';
		}
	document.getElementById(MDMG_menusection[m_section]).style.visibility="visible";
	var padding = 0;
	if(parseInt(document.getElementById(MDMG_menusection[m_section]).style.padding) > 0) { padding = parseInt(document.getElementById(MDMG_menusection[m_section]).style.padding) * 2; }
	MDMGx = parseInt(document.getElementById(MDMG_menusection[m_section]).style.left);
	MDMGxx = parseInt(document.getElementById(MDMG_menusection[m_section]).style.width) + MDMGx + padding;
	MDMGy = parseInt(document.getElementById(MDMG_menusection[m_section]).style.top);
	MDMGyy = parseInt(document.getElementById(MDMG_menusection[m_section]).style.height) + MDMGy + padding;
	STO = setTimeout('MDMG_HideIfOutsideRectangle()',2000);
} // MDMG_bOPERA_showit()



// Netscape 4 functions

function MDMG_bNS4_hidesection(m_section) {
if(MDMG_mouseinrectangle()) { return; }
eval('document.' + MDMG_menusection[m_section] + '.visibility="hide"');
MDMG_menusectionprinted[m_section] = false;
} // MDMG_bNS4_hidesection()

function MDMG_bNS4_hideallmenusections() {
for(i = 1; i < MDMG_menusection.length; i++) { 
	eval('document.' + MDMG_menusection[i] + '.visibility="hide"');
	MDMG_menusectionprinted[i] = false;
	}
} // MDMG_bNS4_hideallmenusections()

function MDMG_bNS4_showit(m_section) {
	if(MDMG_menusectionprinted[m_section] == true) { return; }
	clearTimeout(STO);
	MDMG_bNS4_hideallmenusections();
	MDMG_menusectionprinted[m_section] = true;
	var x = MDMG_mousex - 1;
	if(x < 0) { x = 0; }
	var y = MDMG_mousey - 1;
	if(y < 0) { y = 0; }
	if(MDMG_MovabilityOfSubMenuPositions != "static") {
		eval('document.' + MDMG_menusection[m_section] + '.left="' + x + '"');
		eval('document.' + MDMG_menusection[m_section] + '.top="' + y + '"');
		}
	eval('document.' + MDMG_menusection[m_section] + '.visibility="show"');
	MDMGx = eval('parseInt(document.' + MDMG_menusection[m_section] + '.left)');
	MDMGxx = eval('parseInt(document.' + MDMG_menusection[m_section] + '.clip.width)') + MDMGx;
	MDMGy = eval('parseInt(document.' + MDMG_menusection[m_section] + '.top)');
	MDMGyy = eval('parseInt(document.' + MDMG_menusection[m_section] + '.clip.height)') + MDMGy;
	STO = setTimeout('MDMG_HideIfOutsideRectangle()',2000);
} // MDMG_bNS4_showit()

//-->
