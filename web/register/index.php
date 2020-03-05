<?php 
include '../../lib/database.class.php';
include '../../lib/admin_users.class.php';
include '../../lib/general.class.php';
$objAdminUser = new AdminUser();
$objMySqlDb = new MySqlDb();

if (isset($_POST['btnSubmit']) || isset($_POST['btnSubmit_x']))
{
    $objAdminUser -> voidSetUsername($_POST['txtUsername']);
    $objAdminUser -> voidSetPassword($_POST['txtPassword']);
    $objAdminUser -> voidSetFirstName($_POST['txtFirstName']);
    $objAdminUser -> voidSetLastName($_POST['txtLastName']);
    $objAdminUser -> voidSetDate(date("Y-m-d"));
    $objAdminUser -> voidSetUserLevel("2");
    $objAdminUser -> voidSetIsActive("1");
    
    $intIsAdded = $objAdminUser -> intInsertAdminUser();
    if ($intIsAdded)
    {
        General::voidRedirectUrl('../login/index.php');
    }
    else
    {
        $strMessage = 'Error while adding the new registration';
    }
}
?>
<html>
<title>Welcome Institute of Studies Registration</title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../scripts/style.css" />
<script type="text/javascript" src="../scripts/default.js"></script>

<script type="text/javascript">
function checkUsername(str) {
	  if (str=="") {
		    document.getElementById("txtHint").innerHTML="";
		    return;
		  } 
		  if (window.XMLHttpRequest) {
		    // code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
		    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
		    if (this.readyState==4 && this.status==200) {
		      document.getElementById("txtHint").innerHTML=this.responseText;
		    }
		  }
		  xmlhttp.open("GET","check_user.php?user="+str,true);
		  xmlhttp.send();
}

function validatePassword() {
	strPassword = document.frmUserRegistration.txtPassword.value;
	strConfirmPassword = document.frmUserRegistration.txtConfirmPassword.value;
	if (strPassword == strConfirmPassword) {
		return true;
	} else {
		alert("Password and Confirm Password did not match");
		return false;
	}
	
}

function validateForm() {
	var strMessage = "";
	
	var strUsername = document.frmUserRegistration.txtUsername.value;
	var strFirstName = document.frmUserRegistration.txtFirstName.value;
	var strLastName = document.frmUserRegistration.txtLastName.value;
	var strPassword = document.frmUserRegistration.txtPassword.value;
	var strConfirmPassword = document.frmUserRegistration.txtConfirmPassword.value;
	
	if (strUsername=="") {
		strMessage += "Username\n";
	}
	
	if (strFirstName=="") {
		strMessage += "First Name\n";
	}
	
	if (strLastName=="") {
		strMessage += "Last Name\n";
	}

	if (strPassword=="") {
		strMessage += "Password\n";
	}
	
	if (strConfirmPassword=="") {
		strMessage += "Confirm Password\n";
	}

	if (strMessage=="") {
    		if (strPassword == strConfirmPassword) {
    			return true;
    		} else {
    			alert("Password and Confirm Password did not match");
    			return false;
    		}
	}  
	else
	{
		alert("The following fields are required!\n" + strMessage);
		return false;
	}
	
}
</script>
</head>
<body>
<table id="Table_01" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td background="../images/logo-background.png"><img src="../images/welcome-logo.png"></td>
	</tr>
	</table>
<form name="frmUserRegistration" id="frmUserRegistration" method="post" onsubmit="validateForm()">

<table cellpadding="2" cellspacing="1" width="100%">
	<tr>
		<td colspan="2" align="center" valign="middle">&nbsp;&nbsp;<strong><?php print $objAdminUser -> strGetMessage() ?></strong></td>
	</tr>
	<tr>
		<td class="Heading" colspan="2"><img src="../images/docs_icon.gif">&nbsp;&nbsp;USER REGISTRATION</td>
	</tr>
	<tr class="tbltitle_header">
		<td colspan="2" align="left" valign="middle">&nbsp;&nbsp;<strong>Create your profile</strong></td>
	</tr>
	<tr class="tblrow1">
		<td>Username:</td>
		<td><input type="text" name="txtUsername" value="" class="text" onfocusout="checkUsername(this.value)"/> &nbsp;<div id="txtHint"></div></td>
	</tr>
	<tr class="tblrow1">
		<td>Password:</td>
		<td><input type="password" name="txtPassword" value="" class="text"/></td>
	</tr>
	<tr class="tblrow1">
		<td>Confirm Password:</td>
		<td><input type="password" name="txtConfirmPassword" value="" class="text" onfocusout="validatePassword()"/></td>
	</tr>
	<tr class="tblrow1">
		<td>First Name:</td>
		<td><input type="text" name="txtFirstName" value="" class="text"/></td>
	</tr>
	<tr class="tblrow1">
		<td>Last Name:</td>
		<td><input type="text" name="txtLastName" value="" class="text"/></td>
	</tr>
	<tr class="tblrow1">
		<td colspan="2" align="right">
			<input type="submit" name="btnSubmit" value="Save" class="formbutton">
			<input type="button" name="btnCancel" value="Cancel" class="formbutton" onClick="location.href='../login/index.php'">
		</td>
	</tr>
</table>
</form>
</body>
</html>