<?php
include '../../conf/config.php';

$objSession = new Session();
$objMySqlDb = new MySqlDb();
$strMessage = '';

if(isset($_POST['txtUsername']) && isset($_POST['txtPassword']))
{
	$objAdminUser = new AdminUser();
	$objAdminUser -> voidSetUsername($_POST['txtUsername']);
	$objAdminUser -> voidSetPassword($_POST['txtPassword']);
	$objAdminUser -> voidSetUserLevel($_POST['cboUserLevel']);

	if ($_POST['txtUsername'] == '' || $_POST['txtPassword'] == '')
	{
			$strMessage = '<span class="msgerror">Please Type Your Username and Password!</span>';
	}
	else
	{
		if($objAdminUser -> blnGetAdminUser())
		{
				//set session
				$arrSessionVars = array('intAdminUserId','strUsername','strFirstName', 'strLastName', 'intUserLevel');
				$arrSessionValues = array($objAdminUser -> intGetId(), $objAdminUser -> strGetUsername(), $objAdminUser -> strGetFirstName(), $objAdminUser -> strGetLastName(), $objAdminUser -> strGetUserLevel());

				$objSession -> blnSetVariable($arrSessionVars, $arrSessionValues);
				$objSession -> blnRegisterSessionKey(AD_DB_HASH_KEY, $objAdminUser -> intGetId());
				if (($_SESSION['intUserLevel'] == '1') || ($_SESSION['intUserLevel'] == '2'))
				{
					General::voidRedirectUrl('../main-form/index.php');
				}
				if ($_SESSION['intUserLevel'] == '3')
				{
					General::voidRedirectUrl('../main-form/index.php');
				}
				else
				{
					General::voidRedirectUrl('../main-form/index.php');
				}
		} 
		else
		{
				$strMessage = '<span class="msgerror">Invalid Username or Password!</span>';
		}
	}
}
?> 
<html>
<title><?php print AD_CLIENT_TITLE ?></title>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="scripts/style.css" />
</head>
<body>
<br /><br /><br /><br /><br /><br />
<table width="299" border="0" bgcolor="#8d5c3c" align="center" padding="10px, 10px, 10px, 10px;">
<tr>
<td><img src="../images/welcome-logo.png" width="328" height="130" alt=""></td>
</tr>
<tr>
<td align="center" class="tbltitle_header">Log-In</td>

</tr>
<tr>
<td bgcolor="f2eed3">
	<form name="frmindex" method="post">
	<table width="299" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td class="rightalign">&nbsp;</td>
		  <td align="left">&nbsp;</td>
	    </tr>
		<tr>

			<td width="88" align="right">Username:</td>
			<td width="214" align="left"><input type="text" name="txtUsername" class="text" size="20" /></td>
		</tr>
		<tr>
			<td align="right">Password:</td>
			<td align="left"><input type="password" name="txtPassword" class="text" size="20"  /></td>
		</tr>
		<tr>
	        <td align="right">User Level:</td>
			<td align="left"><?php print $objMySqlDb -> strPopulateSelectSql('cboUserLevel', 'SELECT fulId, fulName FROM tblUserLevel ORDER BY fulName', 'fulId', 'fulName','' ,'SELECT USER LEVEL','class="select"')?>
			</td>
		</tr>	
		<tr>
		  <td class="rightalign"></td>
		  <td align="left"	>&nbsp;</td>
	    </tr>
		<tr>
		<td colspan="2" align="center"><input type="submit" name="x" value="Login" class="formbutton"  />
				<input type="reset" name="y" value="Reset"  class="formbutton" /></td>
		</tr>

	</table></form>
</td>
</tr>
</table>
<div align="center" style="margin-top: 5px;"><a style="text-decoration: none;" href="../register/index.php">New User? Click here to register</a></div>
</body>
</html>
